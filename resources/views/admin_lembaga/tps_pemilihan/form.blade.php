<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
				{!! Form::mySelect('prov_id', 'Provinsi', $provinsi_untuk_select2, isset($item->prov_id) ? (int) $item->prov_id : null, ['class' => 'form-control select2', 'id' => 'provinsi_id']) !!}

				{!! Form::mySelect('kab_id', 'Kabupaten', isset($kabupaten_untuk_select2) ? $kabupaten_untuk_select2 : array(), isset($item->kab_id) ? $item->kab_id : null, ['class' => 'form-control select2']) !!}

				{!! Form::mySelect('kec_id', 'Kecamatan', isset($kecamatan_untuk_select2) ? $kecamatan_untuk_select2 : array(), isset($item->kec_id) ? $item->kec_id : null, ['class' => 'form-control select2']) !!}

				{!! Form::mySelect('kel_id', 'Kelurahan', isset($kelurahan_untuk_select2) ? $kelurahan_untuk_select2 : array(), isset($item->kel_id) ? $item->kel_id : null, ['class' => 'form-control select2']) !!}

				{!! Form::myInput('total_suara', 'total_suara', 'Total Suara') !!}

				{!! Form::myInput('suara_tidak_sah', 'suara_tidak_sah', 'Suara Tidak Sah') !!}

				{!! Form::myInput('suara_tidak_digunakan', 'suara_tidak_digunakan', 'Suara Yang Tidak Digunakan') !!}

				{!! Form::myInput('no_tps', 'no_tps', 'Nomor TPS') !!}

				{!! Form::myInput('jumlah_dpt', 'jumlah_dpt', 'Jumlah Data Pemilih') !!}

				{!! Form::myFile('images', 'Input C1') !!}

				{!! Form::myInput('id_pemilihan', 'id_pemilihan', 'ID Pemilihan') !!}

				{!! Form::mySelect('saksi_id', 'Saksi', $saksi_untuk_select2, isset($item->saksi_id) ? $item->saksi_id : null, ['class' => 'form-control select2']) !!}

				{!! Form::myInput('hidden', 'lembaga_id', '', array(), Auth::user()->lembaga_id) !!}


		</div>
	</div>
</div>
