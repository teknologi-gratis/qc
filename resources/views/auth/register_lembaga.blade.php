@extends('layouts.app')

@section('content')
    <h4 class="fw-300 c-grey-900 mB-40">Register</h4>
    <div class="row form-group">
        <div class="col-xs-12">
            <ul class="nav nav-pills nav-justified thumbnail setup-panel">
                <li class="active"><a href="#step-1">
                    <h4 class="list-group-item-heading">Step 1</h4>
                    <p class="list-group-item-text">Data Lembaga Survey</p>
                </a></li>
                <li class="disabled"><a href="#step-2">
                    <h4 class="list-group-item-heading">Step 2</h4>
                    <p class="list-group-item-text">Akun</p>
                </a></li>
            </ul>
        </div>
	</div>
    <form method="POST" action="{{ route('registrasi_lembaga_proses') }}">
        {{ csrf_field() }}

        {!! Form::myInput('text', 'nama', 'Nama') !!}
		
				{!! Form::mySelect('prov_id', 'Provinsi', $provinsi_untuk_select2, isset($item->prov_id) ? $item->prov_id : null, ['class' => 'form-control select2']) !!}	
		
				{!! Form::mySelect('kab_id', 'Kabupaten', $kabupaten_untuk_select2, isset($item->kab_id) ? $item->kab_id : null, ['class' => 'form-control select2']) !!}
		
				{!! Form::mySelect('kec_id', 'Kecamatan', $kecamatan_untuk_select2, isset($item->kec_id) ? $item->kec_id : null, ['class' => 'form-control select2']) !!}

				{!! Form::myTextArea('alamat', 'Alamat') !!}

				{!! Form::myInput('kontak', 'kontak', 'Kontak') !!}

				{!! Form::mySelect('jenis', 'Jenis', config('variables.jenis'), isset($item->jenis) ? $item->jenis : null, ['class' => 'form-control select2']) !!}
				
                {!! Form::myInput('hidden', 'status', '', array(), 'aktif') !!}

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
