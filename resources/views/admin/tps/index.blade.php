@extends('admin.default')


@section('page-header')
    TPS <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel TPS </h4>
        <a href="{{ route(ADMIN . '.tps.create') }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{ trans('app.add_button') }}
        </a>
        <a href="" class="btn btn-info pull-right mR-10 mT-5" data-toggle="modal" data-target="#importExcel">
            <i class="fa fa-plus"></i> {{trans('Import Excel')}}
            </a>
    </div>
    <!-- <div class="bgc-white bd bdrs-3 pB-50">

    </div> -->
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
				<form method="post" action="/admin/tps/import_excel" enctype="multipart/form-data">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
						</div>
						<div class="modal-body">

							{{ csrf_field() }}

							<label>Pilih file excel</label>
							<div class="form-group">
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
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Lembaga</th>
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                    <th>ID Pemilihan</th>
                    <th>Nomor TPS</th>
                    <th>Jumlah Data Pemilih</th>
                    <th>C1</th>
                    <th>Total Suara</th>
                    <th>Suara Tidak Sah</th>
                    <th>Apakah Sample</th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td><a href="{{ route(ADMIN . '.tps.edit', $item->id) }}">
                            @if(isset($item->lembaga_survey->nama))
                                {{ $item->lembaga_survey->nama }}
                            @endif
                        </a></td>
                        <td>
                            @if(isset($item->provinsi->nama))
                            {{ $item->provinsi->nama }}
                            @endif
                        </td>

                        <td>
                            @if(isset($item->kabupaten->nama))
                            {{ $item->kabupaten->nama }}
                            @endif
                        </td>
                        <td>
                            @if(isset($item->kecamatan->nama))
                            {{ $item->kecamatan->nama }}
                            @endif
                        </td>

                        <td>
                            @if(isset($item->kelurahan->nama))
                            {{ $item->kelurahan->nama }}
                            @endif
                        </td>
                        <td>{{ $item->id_pemilihan }}</td>
                        <td>{{ $item->no_tps }}</td>
                        <td>{{ $item->jumlah_dpt }}</td>
                        <td>

                            @if(!$item->images == "")
                            <!-- Button untuk memnculkan modal nya -->
                            <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-target="#image-gallery">
                                            <img class="img-responsive" src="{{url('c1/', $item->images)}}" alt="Belum Ada">
                                        </a>

                            @else
                            Belum ada
                            @endif
                        </td>
                        <td>{{ $item->total_suara }}</td>
                        <td>{{ $item->suara_tidak_sah }}</td>
                        <td>
                            @if($item->is_sample == 1)
                                <p class="text-success">Ya</p>
                            @else
                                <p class="text-danger">Tidak</p>
                            @endif
                        </td>
                        <!-- <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route(ADMIN . '.tps.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route(ADMIN . '.tps.destroy', $item->id),
                                        'method' => 'DELETE',
                                        ])
                                    !!}

                                        <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i class="ti-trash"></i></button>

                                    {!! Form::close() !!}
                                </li>
                            </ul>
                        </td> -->
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    <!-- Modal untuk Image -->
    
    <!-- End Javascript Modal Image -->
@endsection
