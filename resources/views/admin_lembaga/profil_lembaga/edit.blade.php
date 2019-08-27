@extends('admin_lembaga.default')

@section('page-header')
	User <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['Admin_lembaga\ProfilLembagaController@update', $item->id],
			'method' => 'put', 
			'files' => true
		])
	!!}

		@include('admin_lembaga.profil_lembaga.form')

		<button type="submit" class="btn btn-primary">{{ trans('Submit') }}</button>
		<button type="submit" class="btn btn-danger">{{ trans('Cancel') }}</button>
		
	{!! Form::close() !!}
	
@stop
