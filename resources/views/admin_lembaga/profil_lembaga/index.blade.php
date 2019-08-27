@extends('admin_lembaga.default')

@section('page-header')
    Saksi TPS <small>{{ trans('app.manage') }}</small>
@endsection

@section('content')
    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Tabel Saksi TPS </h4>
        
        <a href="{{ route('admin_lembaga' . '.profil.create') }}" class="btn btn-info pull-right mR-10 mT-5">
            <i class="fa fa-plus"></i> {{ trans('app.add_button') }}
        </a>
        
        
    </div>


    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <table id="dataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>ID Pemilihan</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td><a href="{{ route('admin_lembaga' . '.profil_lembaga.edit', $item->id) }}">{{ $item->nama }}</a></td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->id_pemilihan }}</td>

                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a href="{{ route('admin_lembaga' . '.profil_lembaga.edit', $item->id) }}" title="{{ trans('app.edit_title') }}" class="btn btn-primary btn-sm"><span class="ti-pencil"></span></a></li>
                                <li class="list-inline-item">
                                    {!! Form::open([
                                        'class'=>'delete',
                                        'url'  => route('admin_lembaga' . '.profil_lembaga.destroy', $item->id), 
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