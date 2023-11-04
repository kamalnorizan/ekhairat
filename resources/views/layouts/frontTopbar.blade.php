<!-- Primary Navigation
      ============================================= -->
<nav class="primary-menu">
    @if (Route::is('index'))
    <ul class="menu-container one-page-menu" data-easing="easeInOutExpo" data-speed="1500">
            <li class="menu-item"><a class="menu-link" href="#" data-href="#slider">
                    <div>Utama</div>
                </a></li>
            <li class="menu-item">
                <a class="menu-link" href="{{ !Route::is('index') ? route('index').'#mengenai' : '#' }}" data-href="#mengenai">
                    <div>Mengenai BKKSAH</div>
                </a>
            </li>
            <li class="menu-item mega-menu">
                <a class="menu-link" href="#" data-href="#pengumuman">
                    <div>Pengumuman</div>
                </a>
            </li>
            <li class="menu-item mega-menu">
                <a class="menu-link" href="#" data-href="#co">
                    <div>Kelebihan</div>
                </a>
            </li>
            <li class="menu-item mega-menu">
                <a class="menu-link" href="#" data-href="#carta">
                    <div>Carta Organisasi</div>
                </a>
            </li>
            <li class="menu-item">
                <a class="menu-link" href="#">
                    <div>Keahlian</div>
                </a>
                <ul class="sub-menu-container">
                    <li class="menu-item">
                        <a class="menu-link" id="menuSemakKeahlian" href="#" data-href="#semakKeahlian">
                            <div>Semak Keahlian</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link"  href="#" data-href="#semakKeahlian">
                            <div>Daftar Keahlian</div>
                        </a>
                    </li>
                </ul>
            </li>
            @guest
                <li class="menu-item">
                    <a class="menu-link" href="{{route('login')}}">
                        <div>Log Masuk</div>
                    </a>
                </li>
            @endguest
            @auth
                <li class="menu-item">
                    <a class="menu-link" href="{{route('dashboard')}}">
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link logoutBtn" href="#">
                        <div>Log Keluar</div>
                    </a>
                </li>
            @endauth
        </ul>
    @else
    <ul class="menu-container">
        <li class="menu-item"><a class="menu-link" href="{{route('index')}}?#slider">
            <div>Utama</div>
        </a></li>
        <li class="menu-item">
            <a class="menu-link" href="{{route('index')}}?#mengenai">
                <div>Mengenai BKKSAH</div>
            </a>
        </li>
        <li class="menu-item mega-menu">
            <a class="menu-link" href="{{route('index')}}?#pengumuman">
                <div>Pengumuman</div>
            </a>
        </li>
        <li class="menu-item mega-menu">
            <a class="menu-link" href="{{route('index')}}?#co">
                <div>Kelebihan</div>
            </a>
        </li>
        <li class="menu-item mega-menu">
            <a class="menu-link" href="{{route('index')}}?#carta">
                <div>Carta Organisasi</div>
            </a>
        </li>
        <li class="menu-item">
            <a class="menu-link" href="#">
                <div>Keahlian</div>
            </a>
            <ul class="sub-menu-container">
                <li class="menu-item">
                    <a class="menu-link" id="menuSemakKeahlian" href="{{route('index')}}?#semakKeahlian">
                        <div>Semak Keahlian</div>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="menu-link"  href="{{route('index')}}?#semakKeahlian">
                        <div>Daftar Keahlian</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item">
            <a class="menu-link" href="{{route('login')}}">
                <div>Log Masuk</div>
            </a>
        </li>
    </ul>
    @endif

    <form action="{{route('logout')}}" method="post" id="logoutForm">@csrf</form>
</nav>
<script>

</script>

