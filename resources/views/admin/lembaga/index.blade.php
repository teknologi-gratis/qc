@extends('admin.default')

@section('page-header')
    Lembaga Survey <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel Lembaga Survey </h4>
        <a href="{{ route(ADMIN . '.lembaga.create') }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{ trans('app.add_button') }}
        </a>
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <th>Kecamatan</th>
                    <th>Alamat</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Jenis</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->nama }}
                        <a href="{{ url('/admin/lembaga/data', $item->id) }}"><br><button class="btn btn-success btn-mini">Lihat Detail</button></a></td>
                        <td>{{ $item->provinsi->nama }}</td>
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
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->kontak }}</td>
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route(ADMIN . '.lembaga.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route(ADMIN . '.lembaga.destroy', $item->id), 
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