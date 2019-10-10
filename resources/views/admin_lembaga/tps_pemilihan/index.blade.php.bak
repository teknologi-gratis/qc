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
            {!! Form::open([
                'action' => ['Admin_lembaga\TpsPemilihanController@generateSample'],
            ]) !!}
            {!! Form::myInput('text','threshold', 'Threshold') !!}
            <button type="submit" class="btn btn-primary"><i class="fa fa-cogs"></i> Generate</button>
            {!! Form::close() !!}
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
                    
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                    <th>Nomor TPS</th>
                    <th>Jumlah Data Pemilih</th>
                    <th>C1</th>
                    <th>Total Suara</th>
                    <th>Suara Tidak Sah</th>
                    <th>Apakah Sample</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td><a href="{{ url('/admin_lembaga/pemilihan/tps/edit', $item->id) }}">{{ $item->provinsi->nama }}</a></td>
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
                        <td>{{ $item->no_tps }}</td>
                        <td>{{ $item->jumlah_dpt }}</td>
                        <td>
                          
                            @if(!$item->images == "")
                            <img src="{{url('c1/', $item->images)}}"> <a href="{{route('gambar.download', $item->id)}}" class="btn btn-success btn-mini">Download</a>
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
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ url('/admin_lembaga/pemilihan/tps/edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => url('/admin_lembaga/pemilihan/tps', $item->id), 
                                        'method' => 'DELETE',
                                        ]) 
                                    !!}

                                        <button class="btn btn-danger btn-sm" title="{{ trans('app.delete_title') }}"><i class="ti-trash"></i></button>
                                        
                                    {!! Form::close() !!}
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        
        </table>
    </div>

@endsection