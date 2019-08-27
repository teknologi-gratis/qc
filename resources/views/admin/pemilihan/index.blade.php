@extends('admin.default')

@section('page-header')
    Pemilihan <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel Pemilihan </h4>
        <a href="{{ route(ADMIN . '.pemilihan.create') }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{ trans('app.add_button') }}
        </a>
    </div>
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Tahun</th>
                    <th>Provinsi</th>
                    <th>Kabupaten</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td><a href="{{ route(ADMIN . '.pemilihan.edit', $item->id) }}">{{ $item->jenis }}</a></td>
                        <td>{{ $item->tahun }}</td>
                        <td>    
                                {{ $item->provinsi->nama }}
                        </td>
                        <td>
                            @if($item->kab_id > 0)
                                {{ $item->Kabupaten->nama }}
                            @endif                            
                        </td>

                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ url('/admin/pemilihan/calon', $item->id) }}" class="btn btn-primary btn-sm"><span class="fa fa-users"></span></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ route(ADMIN . '.pemilihan.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route(ADMIN . '.pemilihan.destroy', $item->id), 
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