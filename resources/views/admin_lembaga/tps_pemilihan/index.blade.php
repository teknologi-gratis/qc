@extends('admin_lembaga.default')
@section('page-header')
TPS <small>{{ trans('app.manage') }}</small>
@endsection
@section('content')
    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel TPS Pemilihan {{ $pemilihan->jenis }} {{ $pemilihan->provinsi->nama }} {{ $pemilihan->kabupaten->nama }} {{$pemilihan->tahun}} </h4>
        <a href="{{ url('/admin_lembaga/pemilihan/tps/create', $id) }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{ trans('app.add_button') }}
        </a>
        <a href="" class="btn btn-info pull-right mR-10 mT-5" data-toggle="modal" data-target="#importExcel">
            <i class="fa fa-plus"></i> {{trans('Import Excel')}}
        </a>
    </div>
    <div class="bgc-white bd bdrs-3 pB-50">
        <div class="row mL-10">
            <div class="col-6">
                <form id="formThresold">
                    @csrf
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="form-group">
                        <label for="threshold">Threshold</label>
                        <input type="text" id="threshold" name="threshold" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-cogs"></i> Generate</button>
                </form>
            </div>
        </div>
    </div>
    {{-- notifikasi form validasi --}}
		@if ($errors->has('file'))
		<span class="invalid-feedback" role="alert">
			   <strong>{{ $errors->first('file') }}</strong>
		</span>
		@endif
		{{-- notifikasi sukses --}}
		@if ($sukses = Session::get('sukses'))
		<div class="alert alert-success alert-block">
  			<button type="button" class="close" data-dismiss="alert">×</button>
  			<strong>{{ $sukses }}</strong>
		</div>
		@endif
		<!-- Import Excel -->
		<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  			<div class="modal-dialog" role="document">
    				<form method="post" action="/admin_lembaga/tpspem/import_excel" enctype="multipart/form-data">
      		       <div class="modal-content">
        						<div class="modal-header">
        					       <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
        						</div>
        						<div class="modal-body">
          							{{ csrf_field() }}
                        <input type="hidden" name="id" value="{{ $id }}">
          							<div class="form-group">
                            <label>Pilih file excel</label>
            								<input type="file" name="file" required="required">
          							</div>
        						</div>
        						<div class="modal-footer">
          							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          							<button type="submit" class="btn btn-primary">Import</button>
        						</div>
      		       </div>
    				</form>
  			</div>
		</div>

    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="result" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                    <th>Nomor TPS</th>
                    <th>Jumlah Data Pemilih</th>
                    <th>Total Suara</th>
                    <th>Suara Tidak Sah</th>
                    <th>Suara Yang Tidak Digunakan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="result-body">
                @foreach($allTps as $item)
                <tr>
                    <td>{{ $item->provinsi->nama ?? $item->prov_id }}</td>
                    <td>{{ $item->kabupaten->nama ?? $item->kab_id }}</td>
                    <td>{{ $item->kecamatan->nama ?? $item->kec_id }}</td>
                    <td>{{ $item->kelurahan->nama ?? $item->kel_id }}</td>
                    <td>{{ $item->no_tps }}</td>
                    <td>{{ $item->jumlah_dpt }}</td>
                    <td>{{ $item->total_suara }}</td>
                    <td>{{ $item->suara_tidak_sah }}</td>
                    <td>{{ $item->suara_tidak_digunakan}}</td>
                    <td>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="{{ url('/admin_lembaga/pemilihan/tps/edit', $item->id) }}" title="Edit Item" class="btn btn-primary btn-sm">
                                    <span class="ti-pencil"></span>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <form method="POST" action="https://quickcount.zhanang.id/admin_lembaga/pemilihan/tps/{{ $item->id }}" class="delete">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Delete Item">
                                        <i class="ti-trash"></i>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
@section('js')
<script>
    $(function() {
        let threshold = $('#threshold')
        let tableResultDOM = $('#result')
        tableResultDOM.DataTable()
        let tableResultBodyDOM = $('#result-body')
        $('#formThresold').on('submit', function (e) {
            e.preventDefault()
            $.ajax({
                type: "post",
                url: '/generate-sample',
                data: $(this).serialize(),
                success: function (r) {
                    let tableContent = ``
                    $.each(r.data, function (i, v) {
                        tableContent += `
                          <tr>
                              <td>${v.provinsi}</td>
                              <td>${v.kabupaten}</td>
                              <td>${v.kecamatan}</td>
                              <td>${v.kelurahan}</td>
                              <td>${v.no_tps}</td>
                              <td>${v.jumlah_dpt}</td>
                              <td>${v.total_suara}</td>
                              <td>${v.suara_tidak_sah}</td>
                              <td>${v.suara_tidak_digunakan}</td>
                              <td>
                                  <ul class="list-inline">
                                      <li class="list-inline-item">
                                          <form method="POST" action="https://quickcount.zhanang.id/admin_lembaga/pemilihan/tps/${v.id}" class="delete">
                                              @csrf
                                              @method('DELETE')
                                              <button class="btn btn-danger btn-sm" title="Delete Item">
                                                  <i class="ti-trash"></i>
                                              </button>
                                          </form>
                                      </li>
                                  </ul>
                              </td>
                          </tr>
                        `
                    })
                    tableResultDOM.DataTable().destroy()
                    tableResultBodyDOM.empty()
                    tableResultBodyDOM.html(tableContent)
                    tableResultDOM.DataTable()
                    alert(r.message)
                },
                error: function (xhr, textStatus, error) {
                    console.log(xhr)
                    if (xhr.status == 419) {
                        alert('Terjadi kesalahan. Halaman akan dimuat ulang halaman!')
                        location.reload()
                    } else if (xhr.status == 422) {
                        alert('Threshold tidak boleh kosong!')
                    } else {
                        alert(xhr.responseJSON.message)
                    }
                }
            });
        })
    })
</script>
@endsection
