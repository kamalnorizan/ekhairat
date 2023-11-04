@if ($keahlian)
<h2>TAHNIAH</h2>
Anda adalah ahli BKKSAH 2023/2024
<hr>
No Kad Pengenalan: {{ $keahlian->nokp }}<br>
<strong>Status Ahli: AKTIF</strong><br>
Tarikh Tamat: <br>
<div class="mt-3">
    <button type="button" class="btn btn-secondary ttupModal" data-dismiss="modal">Tutup</button>
    <a class="btn btn-success" href="{{route('keahlian.front.perincian',['encid'=>Crypt::encrypt($keahlian->id)])}}">Papar Maklumat</a>
</div>
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
