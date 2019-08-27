@extends('admin.default')

@section('page-header')
    Detail Data Lembaga 
@endsection

@section('content')
    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel Pemilihan {{ $lembaga->nama }}  </h4>
        <!-- <a href="{{-- url('/admin/lembaga/pemilihan/create', $id) --}}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{-- trans('app.add_button') --}}
        </a> -->
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Tahun</th>
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td><a href="#">{{ $item->jenis }}</a></td>
                        <td>{{ $item->tahun }}</td>
                        <td>    
                                {{ $item->provinsi->nama }}
                        </td>
                        <td>
                            @if($item->kab_id > 0)
                                {{ $item->Kabupaten->nama }}
                            @endif                            
                        </td>

                        <!-- <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ url('/admin/pemilihan/calon', $item->id) }}" class="btn btn-primary btn-sm"><span class="fa fa-users"></span></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ url('/admin/lembaga/pemilihan/edit', $item->id) }} title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => url('/admin/lembaga/pemilihan', $item->id), 
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

    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel Calon Pemilihan {{ $lembaga->nama }} </h4>
        <!-- <a href="{{ url('/admin/pemilihan/calon/create', $id) }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ url('/admin/pemilihan/calon/create', $id) }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{ trans('app.add_button') }}
        </a> -->
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nomor Urut</th>
                    <th>Nama Calon Utama</th>
                    <th>Nama Calon Wakil</th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($calon as $item)
                    <tr>
                    <td><a href="#">{{ $item->calon_nomor_urut }}</a></td>
                        <td>{{ $item->calon_utama_nama }}</td>
                        <td>    
                                {{ $item->calon_wakil_nama }}
                        </td>

                        <!-- <td>
                            <ul class="list-inline">
                                
                                <li class="list-inline-item">
                                    <a href="{{ url('/admin/pemilihan/calon/edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => url('/admin/pemilihan/calon', $item->id), 
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


    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel Saksi {{ $lembaga->nama }} </h4>
        <!-- <a href="{{ url('/admin/lembaga/saksi/create', $id) }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{ trans('app.add_button') }}
        </a> -->
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor TPS</th>
                    <!-- <th>Actions</th> -->
                </tr>
            </thead>
            <tbody>
                @foreach ($saksi as $item)
                    <tr>
                        <td><a href="#">{{ $item->nama }}</a></td>
                        <td>{{ $item->email }}</td>
                        <td> 
                            {{ $item->no_tps}}
                        </td>
                        

                        <!-- <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ url('/admin/lembaga/saksi/edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => url('/admin/lembaga/saksi', $item->id), 
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

    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel TPS {{ $lembaga->nama }}</h4>
        <!-- <a href="{{ url('/admin/lembaga/tps/create', $id) }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{ trans('app.add_button') }}
        </a>
        <a href="" class="btn btn-info pull-right mR-10 mT-5" data-toggle="modal" data-target="#importExcel">
            <i class="fa fa-plus"></i> {{trans('Import Excel')}} 
            </a> -->
    </div>
    <!-- <div class="bgc-white bd bdrs-3 pB-50">
        
    </div> -->
    <!-- {{-- notifikasi form validasi --}}
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
		@endif -->
 
        		<!-- Import Excel -->
		<!-- <div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
		</div> -->
 
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
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
                    <!-- <th>Actions</th>  -->
                </tr>
            </thead>
            <tbody>
                @foreach ($tps as $item)
                    <tr>
                        <td><a href="#">
                        @if(isset($item->provinsi->nama))
                            {{ $item->provinsi->nama }}
                            @endif
                        </a></td>
                        
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
                        <!-- <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ url('/admin/lembaga/tps/edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => url('/admin/lembaga/tps', $item->id), 
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

@endsection