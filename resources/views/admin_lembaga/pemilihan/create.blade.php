@extends('admin_lembaga.default')

@section('page-header')
<div class="bgc-white bd bdrs-3 pB-50 mB-20">        
		<h4 class="pull-left mL-10 mT-5"> Tambah Jenis Pemilihan Baru </h4>
        <a href="{{ route('admin_lembaga' . '.pemilihan.index') }}" class="btn btn-secondary pull-right mR-10 mT-5">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
</div>
@stop

@section('content')
	{!! Form::open([
			'action' => ['Admin_lembaga\PemilihanController@store'],
			'files' => true
		])
	!!}

		@include('admin_lembaga.pemilihan.form')
		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
		
	{!! Form::close() !!}
	
@stop
