@extends('layouts.app')
@section('content')
    <h4 class="fw-300 c-grey-900 mB-40">Register</h4>
    <div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                <li class="active">
                    <a href="#step-1">
                        <h4 class="list-group-item-heading">Step 1</h4>
                        <p class="list-group-item-text">Data Lembaga Survey</p>
                    </a>
                </li>
                <li class="disabled">
                    <a href="#step-2">
                        <h4 class="list-group-item-heading">Step 2</h4>
                        <p class="list-group-item-text">Akun</p>
                    </a>
                </li>
            </ul>
        </div>
	</div>
    <form method="POST" action="{{ route('registrasi_lembaga_proses') }}">
        @csrf

        {!! Form::myInput('text', 'nama', 'Nama') !!}
        @error('nama')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        <div class="form-group">
            <label for="provinsi">Provinsi</label>
            <select name="prov_id" id="prov_id" class="form-control select2" data-placeholder="Pilih Provinsi">
                @foreach($provinsi as $item)
                <option value="{{ $item->id_prov }}">{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
        @error('prov_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        {!! Form::mySelect('kab_id', 'Kabupaten', [], null, ['class' => 'form-control select2']) !!}
        @error('kab_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        {!! Form::mySelect('kec_id', 'Kecamatan', [], null, ['class' => 'form-control select2']) !!}
        @error('kec_id')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        {!! Form::myTextArea('alamat', 'Alamat') !!}
        @error('alamat')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        {!! Form::myInput('kontak', 'kontak', 'Kontak') !!}
        @error('kontak')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        {!! Form::mySelect('jenis', 'Jenis', config('variables.jenis'), isset($item->jenis) ? $item->jenis : null, ['class' => 'form-control select2']) !!}
        @error('jenis')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        {!! Form::myInput('hidden', 'status', '', array(), 'aktif') !!}

        <div class="form-group">
            <div class="peers ai-c jc-sb fxw-nw">
                <div class="peer">
                    <a href="/login">I have an account</a>
                </div>
                <div class="peer">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script>
        $(function () {
            $('.select2').select2()
            let provinsiDOM = $('#prov_id')
            let kabupatenDOM = $('#kab_id')
            let kecamatanDOM = $('#kec_id')

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
        });
    </script>
@endsection
