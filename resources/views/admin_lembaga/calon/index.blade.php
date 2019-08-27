@extends('admin_lembaga.default')

@section('page-header')
    Calon <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel Calon Pemilihan {{ $pemilihan->jenis }} {{ $pemilihan->provinsi->nama }} {{ $pemilihan->kabupaten->nama }} {{$pemilihan->tahun}}</h4>
        <a href="{{ url('/admin_lembaga/pemilihan/calon/create', $id) }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ url('/admin_lembaga/pemilihan/calon/create', $id) }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{ trans('app.add_button') }}
        </a>
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nomor Urut</th>
                    <th>Nama Calon Utama</th>
                    <th>Nama Calon Wakil</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                    <td><a href="#">{{ $item->calon_nomor_urut }}</a></td>
                        <td>{{ $item->calon_utama_nama }}</td>
                        <td>    
                                {{ $item->calon_wakil_nama }}
                        </td>

                        <td>
                            <ul class="list-inline">
                                
                                <li class="list-inline-item">
                                    <a href="{{ url('/admin_lembaga/pemilihan/calon/edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => url('/admin_lembaga/pemilihan/calon', $item->id), 
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