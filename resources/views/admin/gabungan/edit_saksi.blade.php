@extends('admin.default')

@section('page-header')
	User <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['SaksiLembagaController@update', $item->id],
			'method' => 'put', 
			'files' => true
		])
	!!}

		@include('admin.gabungan.form_saksi')

		<button type="submit" class="btn btn-primary">{{ trans('Submit') }}</button>
		<button type="submit" class="btn btn-danger">{{ trans('Cancel') }}</button>
		
	{!! Form::close() !!}
	
@stop
