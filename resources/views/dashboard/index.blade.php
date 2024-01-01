@extends('layouts.app')

@section('head')
    <style>
        .cardDiv {
            cursor: pointer !important;
        }
    </style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Utama</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h5>Senarai Ahli Mengikut Kategori</h5>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card cardDiv" data-type="ahliBiasa" style="border-bottom: 10px solid #45289c">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-user fa-5x text-primary font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>{{ $ahli->ahli_count }}
                                </h3>
                                <span>AHLI BIASA</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card cardDiv" data-type="asnaf" style="border-bottom: 10px solid #927400">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-street-view fa-5x text-warning font-large-2 float-left"
                                    aria-hidden="true"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>{{ $asnaf->ahli_count }}
                                </h3>
                                <span>ASNAF</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card cardDiv" data-type="ajk" style="border-bottom: 10px solid #148e63">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-sitemap text-success fa-5x font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>{{ $countJawatan }}
                                </h3>
                                <span>AJK SURAU</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card cardDiv" data-type="seluruh" style="border-bottom: 10px solid #b82d23">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-users fa-5x  text-danger font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>{{ $countKeseluruhan }}</h3>
                                <span>KESELURUHAN</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h5>Maklumat Status Keahlian</h5>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card cardDiv" data-type="seluruh" style="border-bottom: 10px solid #148e63">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-plus-circle fa-5x  text-success font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>{{ $ahlibaru }}</h3>
                                <span>AHLI BAHARU</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card cardDiv" data-type="seluruh" style="border-bottom: 10px solid #25a075">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-check-circle fa-5x  font-large-2 float-left" style="color: #25a075"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>{{ $totalActive->where('tahun','2023')->first()->jumlah }}</h3>
                                <span>AHLI AKTIF 2023</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card cardDiv" data-type="seluruh" style="border-bottom: 10px solid rgb(69, 176, 139)">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-check-circle fa-5x font-large-2 float-left" style="color: rgb(69, 176, 139)"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>{{ $totalActive->where('tahun','2024')->first()->jumlah }}</h3>
                                <span>AHLI AKTIF 2024</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card cardDiv" data-type="seluruh" style="border-bottom: 10px solid rgb(63, 191, 146)">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="fa fa-check-circle fa-5x font-large-2 float-left" style="color: rgb(63, 191, 146)"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>{{ $totalActive->where('tahun','2025')->first()->jumlah }}</h3>
                                <span>AHLI AKTIF 2025</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h5>Senarai Ahli Mengikut Alamat</h5>
        </div>
        @foreach ($alamat->split(3) as $alamatGroup)
            <div class="col-md-4">
                <div class="card bg-success">
                    <div class="card-body">
                        @foreach ($alamatGroup as $alamatDiv)
                            <a href="#" class="text-white"><span
                                    class="">{{ $alamatDiv->keterangan }}</span><span
                                    class="float-right">{{ $alamatDiv->ahli_count }} <small>ahli</small></span></a><br>
                        @endforeach
                    </div>
                </div>

            </div>
        @endforeach
    </div>
    <div class="row">

    </div>
@endsection

@section('script')
    <script></script>
@endsection
