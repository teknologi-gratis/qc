<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
		{!! Form::mySelect('jenis', 'Jenis Pemilihan', config('variables.jenis_pil'), isset($item->jenis) ? $item->jenis : null, ['class' => 'form-control select2']) !!}
		
				{!! Form::myInput('tahun', 'tahun', 'Tahun') !!}

				{!! Form::mySelect('prov_id', 'Provinsi', $provinsi_untuk_select2, isset($item->prov_id) ? $item->prov_id : null, ['class' => 'form-control select2']) !!}
		
				{!! Form::mySelect('kab_id', 'Kabupaten', $kabupaten_untuk_select2, isset($item->kab_id) ? $item->kab_id : null, ['class' => 'form-control select2']) !!}
				
				
		</div>  
	</div>
</div>