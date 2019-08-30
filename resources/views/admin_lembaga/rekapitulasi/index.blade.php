@extends('admin_lembaga.default')
@section('page-header')
    Rekapitulasi <small>{{ trans('Suara') }}</small>
@endsection
@section('content')
    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Rekapitulasi Suara </h4>
    </div>
    <div class="row mb-40">
        <div class="col-sm-12">
            <div class="bgc-white p-20 bd">
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" id="filter-rekapitulasi">
                            @csrf
                            <div class="row">
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="tahun">Tahun Pemilihan</label>
                                        <select name="tahun" id="tahun" class="form-control select2">
                                            @foreach($pemilihan as $item)
                                                <option value="{{ $item->tahun }}">{{ $item->tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md">
                                    {!! Form::mySelect('jenis', 'Jenis Pemilihan', config('variables.jenis_pil'), isset($item->jenis) ? $item->jenis : null, ['class' => 'form-control select2']) !!}
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="jenis-filter">Jenis Filter</label>
                                        <select id="jenis-filter" name="filter" class="form-control select2">
                                            <option value="provinsi">Provinsi</option>
                                            <option value="kabupaten">Kabupaten</option>
                                            <option value="kecamatan">Kecamatan</option>
                                            <option value="kelurahan">Kelurahan</option>
                                        </select>
                                    </div>
                                </div>
                                @if(Auth::user()->role == 10)
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for="lembaga_survey">Lembaga Survey</label>
                                        <select id="lembaga_survey" name="lembaga_survey" class="form-control select2">
                                            @foreach($lembaga as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="provinsi">Provinsi</label>
                                        <select name="provinsi" id="provinsi" class="form-control select2" data-placeholder="Pilih Provinsi">
                                            @foreach($provinsi as $item)
                                            <option value="{{ $item->id_prov }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kabupaten">Kabupaten</label>
                                        <select name="kabupaten" id="kabupaten" disabled class="form-control select2" data-placeholder="Pilih Kabupaten"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <select name="kecamatan" id="kecamatan" disabled class="form-control select2" data-placeholder="Pilih Kecamatan"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="kelurahan">Kelurahan</label>
                                        <select name="kelurahan" id="kelurahan" disabled class="form-control select2" data-placeholder="Pilih Kelurahan"></select>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="bgc-white p-20 bd">
                            <h6 class="c-grey-900">Grafik Hasil</h6>
                            <div class="mt-30">
                                <canvas id="chart-result" height="220"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table id="table-result" class="table table-striped table-bordered mt-4"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.css"/>
<style>
    .dt-bootstrap4 .paginate_button:hover {
        background: none !important;
    }
</style>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-html5-1.5.6/b-print-1.5.6/datatables.min.js"></script>
<script>
    $(function () {
        var chart
        let provinsiDOM = $('#provinsi')
        let kabupatenDOM = $('#kabupaten')
        let kecamatanDOM = $('#kecamatan')
        let kelurahanDOM = $('#kelurahan')
        let filterForm = $('#filter-rekapitulasi')

        $('#jenis-filter').on('change', function (e) {
            e.preventDefault()
            let selectedFilter = $(this).val()
            switch (selectedFilter) {
                case 'provinsi':
                    kabupatenDOM.attr('disabled', true)
                    kecamatanDOM.attr('disabled', true)
                    kelurahanDOM.attr('disabled', true)
                    break;
                case 'kabupaten':
                    kabupatenDOM.removeAttr('disabled')
                    kecamatanDOM.attr('disabled', true)
                    kelurahanDOM.attr('disabled', true)
                    break;
                case 'kecamatan':
                    kabupatenDOM.removeAttr('disabled')
                    kecamatanDOM.removeAttr('disabled')
                    kelurahanDOM.attr('disabled', true)
                    break;
                case 'kelurahan':
                    kabupatenDOM.removeAttr('disabled')
                    kecamatanDOM.removeAttr('disabled')
                    kelurahanDOM.removeAttr('disabled')
                    break;
                default:
                    break;
            }
        })

        filterForm.on('submit', function (e) {
            e.preventDefault()
            let tableResultDOM = $('#table-result')
            let chartDOM = $('#chart-result')
            let chartData = {
                nama_pasangan: [],
                total_suara: [],
            }
            tableResultDOM.empty()
            if (chart) {
                chart.destroy()
            }
            $.ajax({
                type: "POST",
                url: route('ajax.filter'),
                data: filterForm.serialize(),
                success: function (r) {
                    let tableContent = `<thead><tr><th>No.</th><th>TPS</th>`
                    $.each(r.calon, function (i, v) {
                      let namaPasangan = `${v.calon_utama_nama} & ${v.calon_wakil_nama}`
                      tableContent += `<th>${namaPasangan}</th>`
                      chartData.nama_pasangan.push(namaPasangan)
                    });
                    tableContent += `</tr></thead><tbody>`
                    let count = 0

                    $.each(r.suara, function (i, v) {
                        count ++
                        tableContent += `<tr><td>${count}</td><td>${i.split('_').join(' ')}</td>`
                        $.each(v, function (x, val) {
                            let index = parseInt(val)
                            tableContent += `<td>${val} suara</td>`
                        });
                        tableContent += `</tr>`
                    });
                    tableResultDOM.append(tableContent)
                    tableResultDOM.DataTable().destroy()
                    tableResultDOM.DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'pdfHtml5',
                        ]
                    })

                    $.each(r.total, function (i, v) {
                        chartData.total_suara.push(v)
                    });

                    chart = new Chart(chartDOM, {
                        type: 'bar',
                        data: {
                            labels: chartData.nama_pasangan,
                            datasets: [{
                                label: 'Total Suara',
                                data: chartData.total_suara,
                                backgroundColor: '#aea8d3',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    })
                },
                error: function (xhr, textStatus, error) {
                    console.log(xhr)
                    if (xhr.status == 419) {
                        alert('Terjadi kesalahan. Halaman akan dimuat ulang halaman!')
                        location.reload()
                    } else {
                        alert('Error: ' + xhr.responseJSON.message)
                    }
                }
            });
        })

        provinsiDOM.on('change', function (e) {
            e.preventDefault()
            let provId = $(this).val()
            $.ajax({
                type: "GET",
                url: route('ajax.kabupaten', provId),
                success: function (d) {
                    kabupatenDOM.empty()
                    $.each(d, function (i, v) {
                        kabupatenDOM.append(`<option value="${v.id_kab}">${v.nama}</option>`)
                    })
                    kabupatenDOM.select2()
                },
                error: function (xhr, textStatus, error) {
                    if (xhr.status == 419) {
                        alert('Terjadi kesalahan. Halaman akan dimuat ulang halaman!')
                        location.reload()
                    } else {
                        alert('Error: ' + xhr.responseJSON.message)
                    }
                }
            })
        })

        kabupatenDOM.on('change', function (e) {
            e.preventDefault()
            let kabId = $(this).val()
            $.ajax({
                type: "GET",
                url: route('ajax.kecamatan', kabId),
                success: function (r) {
                    kecamatanDOM.empty()
                    $.each(r, function (i, v) {
                        kecamatanDOM.append(`<option value="${v.id_kec}">${v.nama}</option>`)
                    })
                    kecamatanDOM.select2()
                },
                error: function (xhr, textStatus, error) {
                    console.log(xhr)
                    if (xhr.status == 419) {
                        alert('Terjadi kesalahan. Halaman akan dimuat ulang halaman!')
                        location.reload()
                    } else {
                        alert('Error: ' + xhr.responseJSON.message)
                    }
                }
            })
        })

        kecamatanDOM.on('change', function (e) {
            e.preventDefault()
            let kecId = $(this).val()
            $.ajax({
                type: "GET",
                url: route('ajax.kelurahan', kecId),
                success: function (r) {
                    kelurahanDOM.empty()
                    $.each(r, function (i, v) {
                        kelurahanDOM.append(`<option value="${v.id_kel}">${v.nama}</option>`)
                    })
                    kelurahanDOM.select2()
                },
                error: function (xhr, textStatus, error) {
                    console.log(xhr)
                    if (xhr.status == 419) {
                        alert('Terjadi kesalahan. Halaman akan dimuat ulang halaman!')
                        location.reload()
                    } else {
                        alert('Error: ' + xhr.responseJSON.message)
                    }
                }
            })
        })

    })
</script>
@stop
