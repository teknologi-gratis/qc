@extends('admin_lembaga.default')

@section('page-header')
	Tps <small>{{ trans('app.update_item') }}</small>
@stop

@section('content')
	{!! Form::model($item, [
			'action' => ['Admin_lembaga\TpsController@update', $item->id],
			'method' => 'put', 
			'files' => true
		])
	!!}

		@include('admin_lembaga.tps.form')

		<button type="submit" class="btn btn-primary">{{ trans('Submit') }}</button>
		<button type="submit" class="btn btn-danger">{{ trans('Cancel') }}</button>
		
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
