@extends('admin_lembaga.default')


@section('page-header')
    Rekapitulasi <small>{{ trans('Suara') }}</small>
@endsection

@section('content')
    <div class="bgc-white bd bdrs-3 pB-50">
        <h4 class="pull-left mL-10 mT-5"> Rekapitulasi Suara </h4>
        
    </div>
    <div class="row mB-40">
        <div class="col-sm-12">
                <div class="bgc-white p-20 bd">
                    <!-- <div class="col-sm-3"> -->
                        <form method="POST" action="{{ route('rekapitulasi_suara_proses') }}">
                        {{ csrf_field() }}
                        <div class="container">
                        <div class="row">
                            <div class="col-md">
                                {!! Form::mySelect('jenis', 'Jenis Pemilihan', config('variables.jenis_pil'), isset($item->jenis) ? $item->jenis : null, ['class' => 'form-control select2']) !!}
                            </div>
                            <div class="col-md">
                            {!! Form::mySelect('prov_id', 'Provinsi', $provinsi_untuk_select2, isset($item->prov_id) ? (int) $item->prov_id : null, ['class' => 'form-control select2', 'id' => 'provinsi_id']) !!}	
                            </div>
                            <div class="col-md">
                            {!! Form::mySelect('kab_id', 'Kabupaten', isset($kabupaten_untuk_select2) ? $kabupaten_untuk_select2 : array(), isset($item->kab_id) ? $item->kab_id : null, ['class' => 'form-control select2']) !!}
                            </div>
                            <div class="col-md">
                            {!! Form::mySelect('kec_id', 'Kecamatan', isset($kecamatan_untuk_select2) ? $kecamatan_untuk_select2 : array(), isset($item->kec_id) ? $item->kec_id : null, ['class' => 'form-control select2']) !!}

                            </div>
                            <div class="col-md">
                            {!! Form::mySelect('kel_id', 'Kelurahan', isset($kelurahan_untuk_select2) ? $kelurahan_untuk_select2 : array(), isset($item->kel_id) ? $item->kel_id : null, ['class' => 'form-control select2']) !!}
                                
                            </div>
                        </div>
                        </div>
                        </form>
                        
                        <div class="masonry-item col-md-8">
                            <div class="bgc-white p-20 bd">
                                <h6 class="c-grey-900">Bar Chart</h6>
                                    <div class="mT-30">
                                        <canvas id="bar-chart" height="220"></canvas>
                                    </div>
                            </div>
                        </div>

						
                    <!-- </div> -->
                </div>
            </div>
    </div>       
    

@endsection

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
