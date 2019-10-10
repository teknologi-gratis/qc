@php
    $r = \Route::current()->getAction();
    $route = (isset($r['as'])) ? $r['as'] : '';
@endphp

<li class="nav-item mT-30">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.dash') ? 'active' : '' }}" href="{{ route(ADMIN . '.dash') }}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-home"></i>
        </span>
        <span class="title">Dashboard</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.lembaga') ? 'active' : '' }}" href="{{ route(ADMIN . '.lembaga.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 fa fa-institution"></i>
        </span>
        <span class="title">Lembaga Survey</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.users') ? 'active' : '' }}" href="{{ route(ADMIN . '.users.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 ti-user"></i>
        </span>
        <span class="title">Users</span>
    </a>
</li>

<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.pemilihan') ? 'active' : '' }}" href="{{ route(ADMIN . '.pemilihan.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 fa fa-pencil"></i>
        </span>
        <span class="title">Pemilihan</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.tps') ? 'active' : '' }}" href="{{ route(ADMIN . '.tps.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 fa fa-address-card"></i>
        </span>
        <span class="title">Data TPS</span>
    </a>
</li>
<li class="nav-item">
    <a class="sidebar-link {{ starts_with($route, ADMIN . '.tps') ? 'active' : '' }}" href="{{ route(ADMIN . '.rekapitulasi.index') }}">
        <span class="icon-holder">
            <i class="c-brown-500 fa fa-volume-up"></i>
        </span>
        <span class="title">Rekapitulasi Suara</span>
    </a>
</li>
