@extends('admin_lembaga.default')

@section('page-header')
<div class="bgc-white bd bdrs-3 pB-50 mB-20">        
		<h4 class="pull-left mL-10 mT-5"> Tambah TPS Baru </h4>
        <a href="{{ route('admin_lembaga' . '.tps.index') }}" class="btn btn-secondary pull-right mR-10 mT-5">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
</div>
@stop

@section('content')
	{!! Form::open([
			'action' => ['Admin_lembaga\TpsController@store'],
			'files' => true
		])
	!!}

		@include('admin_lembaga.tps.form')
		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
		
	{!! Form::close() !!}
	
@stop

@section('js')
<script>
	$(document).ready( function() {
		$("select[name='prov_id']").change(function(){
			var provinsi_id = $(this).val();
			var token = $("input[name='_token']").val();
			$.ajax({
				url: "{{ url('get_kabupaten_by_provinsi') }}",
				method: 'POST',
				data: {provinsi_id:provinsi_id, _token:token},
				success: function(data){
					var toAppend = '';
					$("select[name='kab_id']").empty();
					for (var key in data) {
						if (data.hasOwnProperty(key)) {
							toAppend += '<option value="'+ key +'">'+data[key]+'</option>';
						}
					}
					$("select[name='kab_id']").append(toAppend);					

				},
				error: function(msg){
					console.log(msg);
				}
			});
		});

		$("select[name='kab_id']").change(function(){
			var kabupaten_id = $(this).val();
			var token = $("input[name='_token']").val();
			$.ajax({
				url: "{{ url('get_kecamatan_by_kabupaten') }}",
				method: 'POST',
				data: {kabupaten_id:kabupaten_id, _token:token},
				success: function(data){
					var toAppend = '';
					$("select[name='kec_id']").empty();
					for (var key in data) {
						if (data.hasOwnProperty(key)) {
							toAppend += '<option value="'+ key +'">'+data[key]+'</option>';
						}
					}
					$("select[name='kec_id']").append(toAppend);					

				},
				error: function(msg){
					console.log(msg);
				}
			});
		});

		$("select[name='kec_id']").change(function(){
			var kecamatan_id = $(this).val();
			var token = $("input[name='_token']").val();
			$.ajax({
				url: "{{ url('get_kelurahan_by_kecamatan') }}",
				method: 'POST',
				data: {kecamatan_id:kecamatan_id, _token:token},
				success: function(data){
					var toAppend = '';
					$("select[name='kel_id']").empty();
					for (var key in data) {
						if (data.hasOwnProperty(key)) {
							toAppend += '<option value="'+ key +'">'+data[key]+'</option>';
						}
					}
					$("select[name='kel_id']").append(toAppend);					

				},
				error: function(msg){
					console.log(msg);
				}
			});
		});
	});
</script>
@stop