<div class="row mB-40">
	<div class="col-sm-12">
		<div class="bgc-white p-20 bd">
			{!! Form::myInput('text', 'nama', 'Nama') !!}
		
				{!! Form::myInput('email', 'email', 'Email') !!}
		
				{!! Form::myInput('password', 'password', 'Password') !!}
		
				{!! Form::myInput('password', 'password_confirmation', 'Tulis ulang password') !!}

				{!! Form::myInput('nik', 'nik', 'NIK') !!}

				{!! Form::myInput('kontak', 'kontak', 'Kontak') !!}
		
				{!! Form::mySelect('role', 'Role', config('variables.role'), isset($item->role) ? $item->role : null, ['class' => 'form-control select2']) !!}
				{!! Form::mySelect('lembaga_id', 'Lembaga', $lembaga_survey_untuk_select2, isset($item->lembaga_id) ? $item->lembaga_id : null, ['class' => 'form-control select2']) !!}
		
				{!! Form::myTextArea('bio', 'Biodata') !!}

				{!! Form::myFile('avatar', 'Foto') !!}

				
				
				
		</div>  
	</div>
</div>