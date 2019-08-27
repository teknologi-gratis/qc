@extends('layouts.app')

@section('content')
    <h4 class="fw-300 c-grey-900 mB-40">Register</h4>
    <div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                <li class="disabled"><a href="#step-1">
                    <h4 class="list-group-item-heading">Step 1</h4>
                    <p class="list-group-item-text">Data Lembaga Survey</p>
                </a></li>
                <li class="active"><a href="#step-2">
                    <h4 class="list-group-item-heading">Step 2</h4>
                    <p class="list-group-item-text">Akun</p>
                </a></li>
            </ul>
        </div>
	</div>
    <form method="POST" action="{{ route('registrasi_akun_proses') }}" > 
        {{ csrf_field() }}

                {!! Form::myInput('text', 'nama', 'Nama') !!}
		
				{!! Form::myInput('email', 'email', 'Email') !!}
		
				{!! Form::myInput('password', 'password', 'Password') !!}

                {!! Form::myFile('avatar', 'Foto') !!}

				{!! Form::myInput('hidden', 'role', '', array(), 20) !!}

                {!! Form::myInput('hidden', 'lembaga_id', '', array(), $lembaga_id) !!}

				{!! Form::myInput('nik', 'nik', 'NIK') !!}
		
				{!! Form::myTextArea('bio', 'Biodata') !!}


        <div class="form-group">
            <div class="peers ai-c jc-sb fxw-nw">
                <div class="peer">
                    <a href="/login">I have an account</a>
                </div>
                <div class="peer">
                    <button class="btn btn-primary">Register</button>
                </div>
            </div>
        </div>
    </form>

@endsection
