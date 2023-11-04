<style>
    .headGroup {
        background: #181819;
        height: 40px;
        border-left: 5px solid #76a1ad;
        /* text-align: center; */
        padding-left: 27px !important;
        padding-top: 10px !important;
        font-weight: bolder;
    }
</style>
<div class="sidebar-menu">
    <!-- BEGIN SIDEBAR MENU ITEMS-->
    <ul class="menu-items">
        @can('access-admin')
        <li class="m-t-20 {{ Route::is('dashboard') ? 'active' : ''}}">
            <a href="{{ route('dashboard') }}" class="title">
                <span class="title">Utama</span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">home</i></span>
        </li>
        @endcan
        <li>
            <a href="{{ route('profil.index') }}" class="title">
                <span class="title">Profil </span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">edit</i></span>
        </li>
        @can('access-admin')
        <li class="{{ Route::is('permohonan.index') ? 'active' : ''}}">
            <a href="{{ route('permohonan.index') }}" class="title">
                <span class="title">Permohonan</span>
            </a>
            <span class="icon-thumbnail"><span class="badge badge-success" id="permohonanCount">0</span></span>
        </li>

        <li class="{{ Route::is('pembaharuan.index') ? 'active' : ''}}">
            <a href="{{ route('pembaharuan.index') }}" class="title">
                <span class="title">Pembaharuan</span>
            </a>
            <span class="icon-thumbnail"><span class="badge badge-warning text-black" id="pembaharuanCount">0</span></span>
        </li>
        <li class="{{ Route::is('keahlianadm.index') ? 'active' : ''}}">
            <a href="{{ route('keahlianadm.index') }}" class="title">
                <span class="title">Senarai Ahli</span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">users</i></span>
        </li>
        <li class="{{ Route::is('carian.index') ? 'active' : ''}}">
            <a href="{{ route('carian.index') }}" class="title">
                <span class="title">Carian</span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">search</i></span>
        </li>
        @can(['access-superadmin'])
        <li class="{{ Route::is('penerima.index') ? 'active' : ''}}">
            <a href="{{ route('penerima.index') }}" class="title">
                <span class="title">Penerima</span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">search</i></span>
        </li>
        @endcan
        @can(['access-systemadmin'])
        <li class="{{ Route::is('sms.index') ? 'active' : ''}}">
            <a href="{{ route('sms.index') }}" class="title">
                <span class="title">SMS Blast</span>
            </a>
            <span class="icon-thumbnail"><i class="fa fa-ambulance"></i></span>
        </li>
        <li class="{{ Route::is('ketetapan.index') ? 'active' : ''}}">
            <a href="{{ route('ketetapan.index') }}" class="title">
                <span class="title">Ketetapan</span>
            </a>
            <span class="icon-thumbnail"><i class="pg-icon">cog</i></span>
        </li>
        @endcan
        @endcan
        <li class="">
            <a href="#" class="logoutBtn"><span class="title">Log Keluar</span></a>
            <span class="icon-thumbnail"><i class="pg-icon">card</i></span>
        </li>
    </ul>
    <div class="clearfix"></div>
</div>
