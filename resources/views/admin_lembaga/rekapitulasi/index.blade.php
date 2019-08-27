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
								<div class="form-group">
								<label for="tahun">Tahun Pemilihan</label>
								<select name="tahun" id="tahun" class="form-control select2">
									@foreach($pemilihan as $plh)
										<option value="{{$plh->tahun}}">{{$plh->tahun}}</option>
									@endforeach
								</select>
								</div>
							</div>
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
                                        <canvas id="barChart" height="220"></canvas>
                                    </div>
                            </div>
                        </div>
						<br><br><br>
						<table id="result" class="table table-striped table-bordered">
						</table>
                    <!-- </div> -->
                </div>
            </div>
    </div>       
    

@endsection

@section('js')
<script>
	$(document).ready( function() {
		var myChart
		function getRandomColor(index) {
			var color = [
							'#f1a9a0',
							'#aea8d3',
							'#81cfe0',
							'#f5e51b',
							'#f39c12',
							'#bdc3c7',
							'#d91e18',
							'#9b59b6',
							'#16a085'
						]
						return color[index];
					}			


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

					getRekapitulasiKecamatan(data);
					
				},
				error: function(msg){
					console.log(msg);
				}
			});
		});

		$("select[name='kel_id']").change(function(){
			var kel_id = $(this).val();
			var prov_id = $("#provinsi_id").val();
			var jenis = $("#jenis").val();
			var kab_id = $("#kab_id").val();
			var kec_id = $("#kec_id").val();
			var token = $("input[name='_token']").val();
			var tahun =  $("#tahun").val();
			$.ajax({
				url: "{{ url('get_rekapitulasi') }}",
				method: 'POST',
				data: {kelurahan:kel_id, provinsi:prov_id, jenis:jenis, kabupaten:kab_id, kecamatan: kec_id, tahun:tahun,  _token:token},
				success: function(data){
					var toAppend = '';
					var labels = [];
					var dataseets = [];

					$("#result").empty();
					if (data.hasOwnProperty(0)) {
						toAppend += '<thead><tr><td>TPS</td>';
						for (var x in data[0].calon) {
							toAppend += '<td>' + data[0].calon[x].nama_utama_calon + ' & ' + data[0].calon[x].nama_wakil_calon + '</td>';
							dataseets.push({
								label: data[0].calon[x].nama_utama_calon + ' & ' + data[0].calon[x].nama_wakil_calon,
								data: [0],
								backgroundColor : getRandomColor(x)
							})	
						}
						toAppend += '</tr></thead>';
						// $("#result").append(toAppend);
					}
					for (var key in data) {
						if (data.hasOwnProperty(key)) {
							toAppend += '<tr><td>'+data[key].tps.no_tps+'</td>';
							for(var x in data[key].calon){
								toAppend += '<td>'+data[key].calon[x].suara+'</td>';
								dataseets[x].data[0] = dataseets[x].data[0] + data[key].calon[x].suara;
							}
							toAppend += '</tr>';
						}
					}
					$("#result").append(toAppend);
				

					var ctxLine = document.getElementById("barChart").getContext("2d");
					if(myChart !== undefined) {
						myChart.destroy(); 
						myChart = new Chart(ctxLine, {});
					}

					const barChartBox = document.getElementById('barChart');
					
					if (barChartBox) {
					const barCtx = barChartBox.getContext('2d');
		
					myChart = new Chart(barCtx, {
						type: 'bar',
						data: {
						labels: ['Total Suara'],
						datasets: dataseets,
						},

						options: {
							responsive: true,
							legend: {
								position: 'bottom',
							},        
							scales: {
            					yAxes: [{
                					ticks: {
                    					beginAtZero: true
                					}
            					}]
        					}
						},
					});
					}

				},
				error: function(msg){
					console.log(msg);
				}
			});
		});

		function getRekapitulasiKecamatan(data){
			var prov_id = $("#provinsi_id").val();
			var jenis = $("#jenis").val();
			var kab_id = $("#kab_id").val();
			var kec_id = $("#kec_id").val();
			var token = $("input[name='_token']").val();
			var tahun =  $("#tahun").val();
			$.ajax({
				url: `{{ url('get_rekapitulasi?filterByKecamatan=${kec_id}') }}`,
				method: 'POST',
				data: {provinsi:prov_id, jenis:jenis, kabupaten:kab_id, kecamatan: kec_id, tahun:tahun,  _token:token},
				success: function(data){
					console.log(data);
			// 		var toAppend = '';
			// 		var labels = [];
			// 		var dataseets = [];

			// 		$("#result").empty();
			// 		if (data.hasOwnProperty(0)) {
			// 			toAppend += '<thead><tr><td>Kelurahan</td>';
			// 			for (var x in data.calon) {
			// 				toAppend += '<td>' + data.calon[x].nama_utama_calon + ' & ' + data.calon[x].nama_wakil_calon + '</td>';
			// 				dataseets.push({
			// 					label: data.calon[x].nama_utama_calon + ' & ' + data.calon[x].nama_wakil_calon,
			// 					data: [0],
			// 					backgroundColor : getRandomColor(x)
			// 				})	
			// 			}
			// 			toAppend += '</tr></thead>';
			// 			// $("#result").append(toAppend);
			// 		}
			// 		for (var key in data.tps) {
			// 			if (data.hasOwnProperty(key)) {
			// 				toAppend += '<tr><td>'+data.tps[x].nama+'</td>';
			// 				for(var x in data.calon){
			// 					toAppend += '<td>'+data.calon.[key].suara+'</td>';
			// 					dataseets[x].data[0] = dataseets[x].data[0] + data[key].calon[x].suara;
			// 				}
			// 				toAppend += '</tr>';
			// 			}
			// 		}
			// 		$("#result").append(toAppend);
				

			// 		var ctxLine = document.getElementById("barChart").getContext("2d");
			// 		if(myChart !== undefined) {
			// 			myChart.destroy(); 
			// 			myChart = new Chart(ctxLine, {});
			// 		}

			// 		const barChartBox = document.getElementById('barChart');
					
			// 		if (barChartBox) {
			// 		const barCtx = barChartBox.getContext('2d');
		
			// 		myChart = new Chart(barCtx, {
			// 			type: 'bar',
			// 			data: {
			// 			labels: ['Total Suara'],
			// 			datasets: dataseets,
			// 			},

			// 			options: {
			// 				responsive: true,
			// 				legend: {
			// 					position: 'bottom',
			// 				},        
			// 				scales: {
            // 					yAxes: [{
            //     					ticks: {
            //         					beginAtZero: true
            //     					}
            // 					}]
        	// 				}
			// 			},
			// 		});
			// 		}

				},
				error: function(msg){
					console.log(msg);
				}
			});
		}
	});

</script>
@stop
