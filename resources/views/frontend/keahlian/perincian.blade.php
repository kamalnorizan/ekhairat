@extends('layouts.appFront')

@section('head')
<style>
    .table-striped > tbody > tr:nth-child(odd) {
        background-color: rgba(25,134,84,0.05);
    }
</style>
@endsection

@section('header')
<section id="page-title" class="page-title-center">

    <div class="container clearfix">
        <h1>Maklumat Keahlian</h1>
        <span>Terima kasih kerana telah bersama kami.</span>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Utama</a></li>
            <li class="breadcrumb-item"><a href="#">Maklumat Perincian</a></li>
        </ol>
    </div>
</section>
@endsection
@section('content')
<div class="content-wrap">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card ">
                            <div class="card-body">
                                <div class="fancy-title title-bottom-border">
                                    <h4>Status keahlian<div class="badge bg-success float-end">Ahli Biasa</div></h4>
                                </div>
                                <strong>Nama Ahli:</strong> {{$keahlian->nama}}<br>
                                <hr>
                                <strong>Status Ahli:</strong> <span class="text-success">Aktif</span><br>
                                <hr>
                                @if($keahlian->bayaranDetailsPaid->where('jenis','yuran')->count()>0)
                                <strong>Tarikh Tamat:</strong> <span class="{{Carbon\Carbon::now()->endOfYear()->startOfDay()->lte(Carbon\Carbon::parse('31-12-'.$keahlian->bayaranDetailsPaid->where('jenis','yuran')->last()->tahun)) ? 'text-success' : 'text-danger' }}" >{{'31-12-'.$keahlian->bayaranDetailsPaid->where('jenis','yuran')->last()->tahun}} @if(Carbon\Carbon::now()->endOfYear()->startOfDay()->gt(Carbon\Carbon::parse('31-12-'.$keahlian->bayaranDetailsPaid->where('jenis','yuran')->last()->tahun)))&nbsp;<i class="fa fa-exclamation" aria-hidden="true"></i>@endif</span><br>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <div class="card ">
                            <div class="card-body">
                                <div class="fancy-title title-bottom-border">
                                    <h4>Maklumat Tanggungan</h4>
                                </div>
                                @php
                                    $tanggungan = $keahlian->tangungan->count();
                                    if($keahlian->namapasangan != ''){
                                        $tanggungan++;
                                    }
                                @endphp
                                @if ($keahlian->namapasangan != null || $keahlian->namapasangan != '')
                                <strong>Pasangan</strong><br>
                                {{$keahlian->namapasangan}}<br>
                                <small>
                                    @if ($keahlian->tlahirpasangan!=null)
                                    {{\Carbon\Carbon::parse($keahlian->tlahirpasangan)->diff(\Carbon\Carbon::now())->format('%y tahun, %m bulan')}}
                                    @else
                                    N/A
                                    @endif
                                </small>
                                <hr>
                                @endif
                                @forelse ($keahlian->tangungan as $key=>$tangungan)
                                <strong>Tanggungan {{$key+1}}</strong></strong><br>
                                {{$tangungan->nama}}<br>
                                <small>
                                    @if ($tangungan->tlahir!=null)
                                    {{\Carbon\Carbon::parse($tangungan->tlahir)->diff(\Carbon\Carbon::now())->format('%y tahun, %m bulan')}}
                                    @else
                                    N/A
                                    @endif
                                </small>
                                <hr>
                                @empty
                                    @if ($tanggungan == 0)
                                        <div class="mt-3 mb-3 text-muted text-center">Tiada Rekod Tanggungan</div>
                                    @endif
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header text-white  bg-success">Maklumat Pembayaran</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped" id="tableByrn">
                                    <thead>
                                        <tr>
                                            <th>Perkara</th>
                                            <th>Status</th>
                                            <th>Lampiran</th>
                                            <th>Jumlah (RM)</th>
                                            <th>No Resit(Janaan Komputer)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tahun as $t)
                                            @if ( $keahlian->bayaranDetails->where('jenis','yuran')->where('tahun',$t->tahun)->first()!=null)
                                            @if ( $keahlian->bayaranDetails->where('jenis','yuran')->where('tahun',$t->tahun)->first()->bayaran->carabayaran=='TAJAAN')
                                            <tr>
                                                <td>Yuran Tahun {{$t->tahun}}</td>
                                                <td colspan="4" class="text-center text-success">
                                                    <strong>TAJAAN BADAN KHAIRAT SAH BSP</strong>
                                                </td>
                                                <td class="d-none">

                                                </td>
                                                <td class="d-none">

                                                </td>
                                                <td class="d-none">

                                                </td>
                                            </tr>
                                            @else
                                            @php
                                                $bayaran=$keahlian->bayaranDetails->where('jenis','yuran')->where('tahun',$t->tahun)->first();
                                            @endphp
                                                <tr>
                                                    <td>Yuran Tahun {{$t->tahun}}</td>
                                                    <td align="center">
                                                            @php
                                                                $status = $keahlian->bayaranDetails->where('jenis','yuran')->where('tahun',$t->tahun)->first()->bayaran->statusbayaran;

                                                                switch ($status) {
                                                                    case '0':
                                                                        $stat = 'Belum Selesai';
                                                                        $color = 'bg-info';
                                                                        break;
                                                                    case '1':
                                                                        $stat = 'Selesai';
                                                                        $color = 'bg-success';
                                                                        break;
                                                                    case '2':
                                                                        $stat = 'Menunggu Pengesahan';
                                                                        $color = 'bg-warning';
                                                                        break;
                                                                    case '3':
                                                                        $stat = 'Batal';
                                                                        $color = 'bg-danger';
                                                                        break;
                                                                    case '4':
                                                                        $stat = 'Menunggu Pembayaran';
                                                                        $color = 'bg-warning';
                                                                        break;
                                                                }
                                                            @endphp
                                                        <span class="badge {{$color}}">
                                                            {{$stat}}
                                                        </span>
                                                    </td>
                                                    <td align="center">
                                                        @if ($bayaran->bayaran->lampiran!=null)
                                                        <a target="_blank" href="{{ asset($bayaran->bayaran->lampiran) }}" class="btn btn-link"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
                                                        @endif

                                                    </td>
                                                    <td align="center">
                                                        {{number_format($bayaran->amaun,2)}}
                                                    </td>
                                                    <td align="center">
                                                        @if($bayaran->bayaran->statusbayaran=='1')
                                                        <a href="{{route('keahlian.front.resit',['encnoresit'=>Crypt::encrypt($bayaran->bayaran->id),'status'=>'s'])}}">{{$bayaran->bayaran->noresitnew}}<i class="fa fa-download float-end mt-2" aria-hidden="true"></i></a>
                                                        @elseif($bayaran->bayaran->statusbayaran=='4')
                                                        <a href="{{env('TOYYIBPAYURL')}}/{{$bayaran->bayaran->billCode}}" class="btn btn-success btn-sm">Pembayaran FPX</a>
                                                        @endif
                                                        @if($bayaran->bayaran->noresit!=null)
                                                        <br><small>No Resit Lama :{{$bayaran->bayaran->noresit}}</small>
                                                        @endif

                                                    </td>
                                                </tr>
                                                @endif
                                            @elseif((int) $t->tahun>2023)
                                            <tr>
                                                <td>Yuran Tahun {{$t->tahun}}</td>
                                                <td align="center">
                                                    <span class="badge bg-warning">
                                                     Belum Selesai
                                                    </span>
                                                </td>
                                                <td>

                                                </td>
                                                <td align="center">
                                                    <span class="text-danger">
                                                        50.00
                                                    </span>
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                            @else
                                            <tr>
                                                <td>Yuran Tahun {{$t->tahun}}</td>
                                                <td colspan="4" class="text-center text-danger">
                                                    <strong>TIDAK AKTIF SEBAGAI AHLI BKKSAH BSP</strong>
                                                </td>
                                                <td class="d-none">

                                                </td>
                                                <td class="d-none">

                                                </td>
                                                <td class="d-none">

                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <a href="{{route('keahlian.front.kemaskini',['encid'=>Crypt::encrypt($keahlian->id)])}}" class="btn btn-warning float-center">Kemaskini Maklumat</a> &nbsp;
                                    @if ($configpendaftaran->value==1)
                                    <a href="{{route('keahlian.front.pembaharuan',['encid'=>Crypt::encrypt($keahlian->id),'type'=>'p'])}}" class="btn btn-success float-center">Pembaharuan Sesi {{$configtahunsemasa->value}}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 mt-2 text-center">
                                <span style="color:red; font-size: 10pt;">****Sebarang perubahan maklumat, Sila hubungi Pihak AJK BKKSAH atau log masuk ke <a href="{{route('login')}}"><strong>Sistem eKhairat BKKSAH, Bandar Saujana Putra</strong></a>.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $('#tableByrn').DataTable({
        "order": [[ 0, "asc" ]],
        "ordering": false,
        "searching": false,
        "paging": false,
        "responsive": true
    });


</script>
@endsection
