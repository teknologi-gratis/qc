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
    <form method="POST" action="{{ route('registrasi_akun_proses') }}" enctype="multipart/form-data">
        {{ csrf_field() }}

        {!! Form::myInput('text', 'nama', 'Nama', [], $lembaga->nama) !!}
        @error('nama')
        <span class="text-danger">{{ $message }}</span>
        @enderror

				{!! Form::myInput('email', 'email', 'Email') !!}
        @error('email')
        <span class="text-danger">{{ $message }}</span>
        @enderror

				{!! Form::myInput('password', 'password', 'Password') !!}
        @error('password')
        <span class="text-danger">{{ $message }}</span>
        @enderror

        {!! Form::myInput('password', 'password_confirmation', 'Konfirmasi Password') !!}

        {!! Form::myFile('avatar', 'Foto') !!}
        @error('avatar')
        <span class="text-danger">{{ $message }}</span>
        @enderror

				{!! Form::myInput('hidden', 'role', '', array(), $role ?? 20) !!}

        {!! Form::myInput('hidden', 'lembaga_id', '', array(), $lembaga_id) !!}

				{!! Form::myInput('nik', 'nik', 'NIK') !!}
        @error('nik')
        <span class="text-danger">{{ $message }}</span>
        @enderror

				{!! Form::myTextArea('bio', 'Biodata') !!}
        @error('bio')
        <span class="text-danger">{{ $message }}</span>
        @enderror


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
