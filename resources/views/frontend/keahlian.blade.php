@if ($keahlian)
    @if(!$aktifBayaran)
        @if($menungguPengesahan)
        <h2>MENUNGGU PENGESAHAN</h2>
        <p>Pihak kami sedang menyemak rekod pembayaran anda.</p>
        <div class="mt-3">
            <button type="button" class="btn btn-secondary ttupModal" data-dismiss="modal">Tutup</button>
            <a class="btn btn-success" href="{{route('keahlian.front.perincian',['encid'=>Crypt::encrypt($keahlian->id)])}}">Papar Maklumat</a>
        </div>
        @else
        <h2>MENUNGGU PEMBAYARAN</h2>
        Sila lengkapkan pendaftaran anda.
        <div class="mt-3">
            <button type="button" class="btn btn-secondary ttupModal" data-dismiss="modal">Tutup</button>
            <a class="btn btn-success" href="{{route('keahlian.front.pembaharuanbayaran',['encid'=>Crypt::encrypt($keahlian->id)])}}">Papar Maklumat</a>
        </div>
        @endif
    @else
        <h2>TAHNIAH</h2>
        Anda adalah ahli BKKSAH
        <hr>
        No Kad Pengenalan: {{ $keahlian->nokp }}<br>
        <strong>Status Keahlian</strong><br>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header @if($aktifBayaranSemasa) bg-success text-white @else bg-danger  text-white @endif">
                        SESI {{date('Y')}}/{{date('Y')+1}}
                    </div>
                    <div class="card-body">
                        @if($aktifBayaranSemasa)
                             <span class="text-success text-center">Aktif</span>
                        @else
                             <span class="text-danger text-center">Tidak Aktif</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                 <div class="card">
                    <div class="card-header @if($aktifBayaranSeterusnya) bg-success text-white @else bg-warning @endif">
                        SESI {{date('Y')+1}}/{{date('Y')+2}}
                    </div>
                    <div class="card-body">
                        @if($aktifBayaranSeterusnya)
                            <span class="text-success">Aktif</span>
                        @else
                            @if($menungguPengesahan)
                            <span class="text-warning">Menunggu Pengesahan</span>
                            @else
                            <span class="text-warning">Menunggu Pembayaran</span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-3">
            <button type="button" class="btn btn-secondary ttupModal" data-dismiss="modal">Tutup</button>
            <a class="btn btn-success" href="{{route('keahlian.front.perincian',['encid'=>Crypt::encrypt($keahlian->id)])}}">Papar Maklumat</a>
        </div>
    @endif
@else
    <h2>MAAF</h2>
    Maklumat anda tiada dalam pengkalan data BKKSAH.<br>
    @if($configDaftar->value =='0')
    <small class="text-danger">Tarikh pendaftaran {{$configTahunSemasa->value}} telah ditutup</small>
    @endif
    <div class="mt-3">
        <button type="button" class="btn btn-secondary ttupModal" data-dismiss="modal">Tutup</button>
        @if($configDaftar->value =='1')
        <a class="btn btn-success" href="{{route('keahlian.front.index')}}">Daftar Keahlian</a>

        @endif
    </div>
@endif
