<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
			{!! Form::myInput('text', 'nama', 'Nama') !!}
		
				{!! Form::mySelect('prov_id', 'Provinsi', $provinsi_untuk_select2, isset($item->prov_id) ? $item->prov_id : null, ['class' => 'form-control select2']) !!}	
		
				{!! Form::mySelect('kab_id', 'Kabupaten', $kabupaten_untuk_select2, isset($item->kab_id) ? $item->kab_id : null, ['class' => 'form-control select2']) !!}
		
				{!! Form::mySelect('kec_id', 'Kecamatan', $kecamatan_untuk_select2, isset($item->kec_id) ? $item->kec_id : null, ['class' => 'form-control select2']) !!}

				{!! Form::myTextArea('alamat', 'Alamat') !!}

				{!! Form::myInput('kontak', 'kontak', 'Kontak') !!}
		
				{!! Form::mySelect('status', 'Status', config('variables.status'), isset($item->status) ? $item->status : null, ['class' => 'form-control select2']) !!}

				{!! Form::mySelect('jenis', 'Jenis', config('variables.jenis'), isset($item->jenis) ? $item->jenis : null, ['class' => 'form-control select2']) !!}
				
		
				

				

				
				
				
		</div>  
	</div>
</div>