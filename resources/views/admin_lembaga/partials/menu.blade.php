@php
    $r = \Route::current()->getAction();
    $route = (isset($r['as'])) ? $r['as'] : '';
@endphp

<li class="nav-item mT-30">
    <a class="sidebar-link {{ starts_with($route, 'admin_lembaga' . '.dash') ? 'active' : '' }}" href="{{ route('admin_lembaga' . '.dash') }}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-home"></i>
        </span>
        <span class="title">Dashboard</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, 'admin_lembaga' . '.pemilihan') ? 'active' : '' }}" href="{{ route('admin_lembaga' . '.pemilihan.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 fa fa-pencil"></i>
        </span>
        <span class="title">Pemilihan</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, 'admin_lembaga' . '.users') ? 'active' : '' }}" href="{{ route('admin_lembaga' . '.users.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
        <span class="title">Saksi TPS</span>
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, 'admin_lembaga' . '.tps') ? 'active' : '' }}" href="{{ route('admin_lembaga' . '.tps.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 fa fa-address-card"></i>
        </span>
        <span class="title">Data TPS</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route,   'rekapitulasi_suara') ? 'active' : '' }}" href="{{ route( 'rekapitulasi.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 fa fa-volume-up"></i>
        </span>
        <span class="title">Rekapitulasi Suara</span>
    </a>
</li>