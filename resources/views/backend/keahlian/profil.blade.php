@extends('layouts.app')

@section('head')
<style>
    .radio>label {
        display: inline-block;
        font-size: 13px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #555;
        margin-bottom: 10px;
        cursor: pointer;
    }

    .required-label::before {
        content: "*";
        color: red;
    }

    label.error{
        color: red;
        display: block!important;
    }

    hr {
        clear: both;
        margin-bottom: 15px;
        margin-top: 15px;
        border: 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.13);
    }
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Profil</a></li>
@endsection



@section('content')
@if ($keahlian->bayaran->where('statusbayaran',2)->count()>0)
<div class="alert alert-warning" role="alert">
    <strong>Menunggu Pengesahan: </strong>
        @if ($keahlian->bayaran->where('jenisPermohonan',1)->where('statusbayaran',2)->count()>0)
            Pembayaran untuk pembaharuan keahlian perlu disahkan.
        @elseif($keahlian->bayaran->where('jenisPermohonan',2)->where('statusbayaran',2)->count()>0)
            Pendaftaran keahlian perlu disahkan.
        @endif
</div>
@endif
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#profil">Profil Ahli</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#bayaran">Rekod Pembayaran</a>
    </li>
</ul>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content">
                    <div class="tab-pane container active" id="profil">
                        <div class="row">
                            <div class="col-md-12">
                                {!! Form::open(['method' => 'POST', 'route' => 'profil.update', 'id'=>'formDaftar']) !!}
                                <input type="hidden" name="type" id="type" class="form-control" value="{{ $type }}">
                                <input type="hidden" name="id" id="id" class="form-control" value="{{ $keahlian->id }}">

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="highlight-me">Maklumat Ketua Keluarga</h4>
                                    </div>
                                    <div class="col-md-12 form-group form-group-default{{ $errors->has('nama') ? ' has-error' : '' }}">
                                        {!! Form::label('nama', 'Nama Penuh', ['class' => 'required-label']) !!}
                                        {!! Form::text('nama', $keahlian->nama ?? null, [
                                            'class' => 'form-control',
                                            'required' => 'required',
                                            'placeholder' => 'NAMA PENUH',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('nama') }}</small>
                                    </div>
                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('nokp') ? ' has-error' : '' }}">
                                        {!! Form::label('nokp', 'No Kad Pengenalan', ['class' => 'required-label']) !!}
                                        {!! Form::text('nokp', $keahlian->nokp ?? null, [
                                            'class' => 'form-control nokp',
                                            'required' => 'required',
                                            'placeholder' => 'cth: 840909-10-4543',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('nokp') }}</small>
                                    </div>

                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('tlahir') ? ' has-error' : '' }}">
                                        {!! Form::label('tlahir', 'Tarikh Lahir') !!}
                                        {!! Form::date('tlahir', $keahlian->tlahir ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'TARIKH LAHIR',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('tlahir') }}</small>
                                    </div>
                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('umur') ? ' has-error' : '' }}">
                                        {!! Form::label('umur', 'Umur') !!}
                                        {!! Form::text(
                                            'umur',
                                            $keahlian->tlahir != null ? \Carbon\Carbon::parse($keahlian->tlahir)->diffInYears(\Carbon\Carbon::now()) : null,
                                            ['class' => 'form-control umur', 'placeholder' => 'UMUR'],
                                        ) !!}
                                        <small class="text-danger">{{ $errors->first('umur') }}</small>
                                    </div>
                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('notel_r') ? ' has-error' : '' }}">
                                        {!! Form::label('notel_r', 'No Phone(R)') !!}
                                        {!! Form::text('notel_r', $keahlian->notel_r ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => '0X-XXXXXXXX',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('notel_r') }}</small>
                                    </div>
                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('notel_hp') ? ' has-error' : '' }}">
                                        {!! Form::label('notel_hp', 'No Phone(HP)', ['class' => 'required-label']) !!}
                                        {!! Form::text('notel_hp', $keahlian->notel_hp ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => '0X-XXXXXXXX',
                                            'required' => 'required',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('notel_hp') }}</small>
                                    </div>
                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('notel_p') ? ' has-error' : '' }}">
                                        {!! Form::label('notel_p', 'No Phone(P)', ['class' => '']) !!}
                                        {!! Form::text('notel_p', $keahlian->notel_p ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => '0X-XXXXXXXX',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('notel_p') }}</small>
                                    </div>
                                    <div class="col-md-6 form-group form-group-default{{ $errors->has('pekerjaan') ? ' has-error' : '' }}">
                                        {!! Form::label('pekerjaan', 'Pekerjaan') !!}
                                        {!! Form::text('pekerjaan', $keahlian->pekerjaan ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'PEKERJAAN',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('pekerjaan') }}</small>
                                    </div>
                                    <div class="col-md-6 form-group form-group-default{{ $errors->has('email') ? ' has-error' : '' }}">
                                        {!! Form::label('email', 'Email', ['class' => 'required-label']) !!}
                                        {!! Form::email('email', $keahlian->user->email ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'cth: example@gmail.com'
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                    </div>
                                    <div class="col-md-8 form-group form-group-default{{ $errors->has('alamat') ? ' has-error' : '' }}">
                                        {!! Form::label('alamat', 'Alamat', ['class' => 'required-label']) !!}
                                        {!! Form::text('alamat', $keahlian->alamat ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'ALAMAT',
                                            'required' => 'required',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                    </div>
                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('ltalamat_id') ? ' has-error' : '' }}">
                                        {!! Form::label('ltalamat_id', 'Kawasan Alamat') !!}
                                        {!! Form::select('ltalamat_id', $lt_alamat, $keahlian->ltalamat_id ?? null, [
                                            'id' => 'ltalamat_id',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('ltalamat_id') }}</small>
                                    </div>
                                    <div class="radio{{ $errors->has('status') ? ' has-error' : '' }} form-group form-group-default-default ">
                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! Form::label('status', 'STATUS') !!}
                                            </div>
                                        </div>
                                        <label for="status">
                                            {!! Form::radio('status', 1, $keahlian->status == 1 ? true : false, [
                                                'id' => 'radio_status_1',
                                                'class' => 'statusRadio',
                                            ]) !!} Berkahwin
                                        </label>&nbsp;&nbsp;&nbsp;
                                        <label for="status">
                                            {!! Form::radio('status', 2, $keahlian->status == 2 ? true : false, [
                                                'id' => 'radio_status_2',
                                                'class' => 'statusRadio',
                                            ]) !!} Janda
                                        </label>&nbsp;&nbsp;&nbsp;
                                        <label for="status">
                                            {!! Form::radio('status', 3, $keahlian->status == 3 ? true : false, [
                                                'id' => 'radio_status_3',
                                                'class' => 'statusRadio',
                                            ]) !!} Duda
                                        </label>&nbsp;&nbsp;&nbsp;
                                        <label for="status">
                                            {!! Form::radio('status', 4, $keahlian->status == 4 ? true : false, [
                                                'id' => 'radio_status_4',
                                                'class' => 'statusRadio',
                                            ]) !!} Bujang
                                        </label>&nbsp;&nbsp;&nbsp;
                                        <small class="text-danger">{{ $errors->first('status') }}</small>
                                    </div>
                                </div>
                                <div class="row" id="divPasangan">
                                    <div class="col-md-12 mt-3">
                                        <hr>
                                        <h4 class="highlight-me">Maklumat Pasangan</h4>
                                    </div>
                                    <div class="col-md-12 form-group form-group-default{{ $errors->has('namapasangan') ? ' has-error' : '' }}">
                                        {!! Form::label('namapasangan', 'Nama Penuh') !!}
                                        {!! Form::text('namapasangan', $keahlian->namapasangan ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'NAMA PENUH PASANGAN',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('namapasangan') }}</small>
                                    </div>
                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('nokppasangan') ? ' has-error' : '' }}">
                                        {!! Form::label('nokppasangan', 'No Kad Pengenalan') !!}
                                        {!! Form::text('nokppasangan', $keahlian->nokppasangan ?? null, [
                                            'class' => 'form-control nokp',
                                            'required' => 'required',
                                            'placeholder' => 'cth: 840909-10-4543',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('nokppasangan') }}</small>
                                    </div>
                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('tlahirpasangan') ? ' has-error' : '' }}">
                                        {!! Form::label('tlahirpasangan', 'Tarikh Lahir') !!}
                                        {!! Form::date('tlahirpasangan', $keahlian->tlahirpasangan ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'TARIKH LAHIR PASANGAN',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('tlahirpasangan') }}</small>
                                    </div>
                                    <div class="col-md-4 form-group form-group-default{{ $errors->has('umurpasangan') ? ' has-error' : '' }}">
                                        {!! Form::label('umurpasangan', 'Umur') !!}
                                        {!! Form::text('umurpasangan', $keahlian->umurpasangan ?? null, [
                                            'class' => 'form-control umur',
                                            'placeholder' => 'UMUR PASANGAN',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('umurpasangan') }}</small>
                                    </div>

                                    <div class="col-md-6 form-group form-group-default{{ $errors->has('pekerjaanpasangan') ? ' has-error' : '' }}">
                                        {!! Form::label('pekerjaanpasangan', 'Pekerjaan') !!}
                                        {!! Form::text('pekerjaanpasangan', $keahlian->pekerjaanpasangan ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'PEKERJAAN PASANGAN',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('pekerjaanpasangan') }}</small>
                                    </div>
                                    <div class="col-md-6 form-group form-group-default{{ $errors->has('notelpasangan_hp') ? ' has-error' : '' }}">
                                        {!! Form::label('notelpasangan_hp', 'No Telefon Pasangan') !!}
                                        {!! Form::text('notelpasangan_hp', $keahlian->notelpasangan_hp ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => '0X-XXXXXXXX',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('notelpasangan_hp') }}</small>
                                    </div>
                                </div>
                                <div class="row" id="divAnak">
                                    <div class="col-md-12 mt-3">
                                        <hr>
                                        <h4 class="highlight-me">Maklumat anak-anak yang berumur 1 tahun sehingga 23 tahun yang masih dalam tanggungan
                                        </h4>
                                        <div class="col-md-12" id="tanggunganDiv">
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-primary" id="tambahTanggungan"> <i class="fa fa-plus"
                                                    aria-hidden="true"></i> Tambah Tanggungan</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="divWaris">
                                    <div class="col-md-12 mt-3">
                                        <hr>
                                        <h4 class="highlight-me">Waris Terdekat (Jika berlaku kecemasan & rujukan)</h4>
                                    </div>
                                    <div class="col-md-6 form-group form-group-default{{ $errors->has('namawaris') ? ' has-error' : '' }}">
                                        {!! Form::label('namawaris', 'Nama Penuh', ['class' => 'required-label']) !!}
                                        {!! Form::text('namawaris', $keahlian->namawaris ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => 'NAMA PENUH WARIS',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('namawaris') }}</small>
                                    </div>
                                    <div class="col-md-6 form-group form-group-default{{ $errors->has('hubungan') ? ' has-error' : '' }}">
                                        {!! Form::label('hubunganwaris', 'Hubungan') !!}
                                        {!! Form::select(
                                            'hubunganwaris',
                                            [
                                                'Ayah Kandung' => 'AYAH',
                                                'Ibu Kandung' => 'IBU',
                                                'Mertua' => 'MERTUA',
                                                'Anak Kandung' => 'ANAK',
                                                'Menantu' => 'MENANTU',
                                                'Anak Tiri' => 'ANAK TIRI',
                                                'Adik Beradik' => 'ADIK BERADIK',
                                                'Ipar' => 'IPAR',
                                                'Saudara' => 'SAUDARA',
                                            ],
                                            $keahlian->hubunganwaris ?? null,
                                            ['id' => 'hubunganwaris', 'class' => 'form-control', 'required' => 'required'],
                                        ) !!}
                                        <small class="text-danger">{{ $errors->first('hubunganwaris') }}</small>
                                    </div>
                                    <div class="col-md-6 form-group form-group-default{{ $errors->has('notelwaris_1') ? ' has-error' : '' }}">
                                        {!! Form::label('notelwaris_1', 'No Telefon 1', ['class' => 'required-label']) !!}
                                        {!! Form::text('notelwaris_1', $keahlian->notelwaris_1 ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => '01X-XXXXXXX',
                                            'required',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('notelwaris_1') }}</small>
                                    </div>
                                    <div class="col-md-6 form-group form-group-default{{ $errors->has('notelwaris_2') ? ' has-error' : '' }}">
                                        {!! Form::label('notelwaris_2', 'No Telefon 2') !!}
                                        {!! Form::text('notelwaris_2', $keahlian->notelwaris_2 ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => '01X-XXXXXXX',
                                        ]) !!}
                                        <small class="text-danger">{{ $errors->first('notelwaris_2') }}</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 mt-2 text-center">
                                        <button class="btn btn-lg btn-primary btnPembayaran"  type="button" data-type='kemaskini'>Kemaskini Maklumat Keahlian</button>
                                        @if ($configpendaftaran->value==1)
                                        <button class="btn btn-lg btn-success btnPembayaran" data-type='pembaharuan'>Pembaharuan Sesi {{$configtahunsemasa->value}}</button>
                                        @else
                                            @canany(['access-systemadmin','access-admin','access-superadmin'])
                                            <button class="btn btn-lg btn-success btnPembayaran" data-type='pembaharuan'>Pembaharuan Sesi {{$configtahunsemasa->value}}</button>
                                            @endcanany
                                        @endif
                                    </div>
                                </div>

                                <input type="hidden" name="requestType" id="requestType" class="form-control" value="">

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane container fade" id="bayaran">
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
                                                                        $color = 'bg-warning pengesahan';
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
                                                        @if ($bayaran->bayaran->buktibayaran!=null)
                                                        <a target="_blank" href="{{ asset($bayaran->bayaran->buktibayaran) }}" class="btn btn-link"><i class="fa fa-paperclip fa-2x" aria-hidden="true"></i></a>
                                                        @endif

                                                    </td>
                                                    <td align="center">
                                                        {{number_format($bayaran->amaun,2)}}
                                                    </td>
                                                    <td align="center">
                                                        @if($bayaran->bayaran->statusbayaran=='1')
                                                        <a href="{{route('keahlian.front.resit',['encnoresit'=>Crypt::encrypt($bayaran->bayaran->id),'status'=>'s'])}}">{{$bayaran->bayaran->noresitnew}}<i class="fa fa-download float-end mt-2" aria-hidden="true"></i></a>
                                                        @elseif($bayaran->bayaran->statusbayaran=='2')
                                                        @can('access-admin')
                                                            <button data-toggle="modal" data-target="#pengesahanPembaharuan" data-id="{{$bayaran->bayaran->id}}" class="btn btn-success btn-sm">Pengesahan</button>
                                                        @endcan
                                                        @elseif($bayaran->bayaran->statusbayaran=='4')
                                                        <a href="https://toyyibpay.com/{{$bayaran->bayaran->billCode}}" class="btn btn-success btn-sm">Pembayaran FPX</a>
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
                                                <td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="pengesahanPembaharuan" tabindex="-1"  role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 900px!important" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengesahan Pembaharuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <iframe style="align-content: center" src="" width="100%" height="350px" frameborder="0" id="iframeBukti"></iframe>
                        <br>
                        @can('access-systemadmin')<button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#kemaskiniAttachment">
                            Kemaskini Lampiran
                          </button>@endcan

                    </div>
                    <div class="col-md-12">
                        <div class="card card-bordered" >
                          <div class="card-body">

                            <input type="hidden" name="" id="idBayaranPengesahan" class="form-control" value="">
                            <h6>Maklumat Pembayaran</h6>
                            <hr>
                            <span id="rekodPembayaran"></span>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-secondary float-left" data-toggle="modal" data-target="#semakFpxModal" id="semakFpxBtnRoot">Semak FPX</button>
                <button type="button" id="btnSahkan" class="btn btn-primary">Sahkan</button>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->

<!-- Modal -->
@can('access-systemadmin')
<div class="modal fade  slide-right" id="kemaskiniAttachment" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kemaskini Lampiran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="form-group{{ $errors->has('dokumen') ? ' has-error' : '' }} form-group-default ">
                    {!! Form::label('dokumen', 'Dokumen') !!}
                    {!! Form::file('dokumen', ['required' => 'required']) !!}
                    <p class="help-pgock">Sila muatnaik resit pembayaran untuk mengemaskini resit pembayaran yang telah dihantar</p>
                    <small class="text-danger">{{ $errors->first('dokumen') }}</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" id="btnUploadResit"  class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endcan
<div class="modal fade slide-right" id="semakFpxModal" tabindex="-1"  role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row mt-5">
                    <div class="col-md-12 form-group form-group-default{{ $errors->has('kodFpx') ? ' has-error' : '' }}">
                        {!! Form::label('kodFpx', 'BILL CODE', ['class' => 'required-label']) !!}
                        {!! Form::text('kodFpx', null, [
                            'class' => 'form-control',
                            'required' => 'required',
                            'placeholder' => 'Masukkan Bill Code',
                            'id'=>'kodFpx'
                        ]) !!}
                        <small class="text-danger">{{ $errors->first('kodFpx') }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" id="semakFpxBtn" class="btn btn-success float-left">Semak FPX</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function isEmpty(obj) {
        return Object.keys(obj).length === 0 && obj.constructor === Object;
    }
    $('#semakFpxBtn').click(function (e) {
        e.preventDefault();
        var idBayaran = $(this).attr('data-id');
        if($('#kodFpx').val()!=''){
            $.ajax({
                type: "post",
                url: "{{route('profil.semakPembayaranFpx')}}",
                data: {
                    kodFpx:$('#kodFpx').val(),
                    _token:"{{csrf_token()}}"
                },
                dataType: "json",
                success: function (response) {
                    if(!isEmpty(response) && response[0].billpaymentStatus=="1"){
                        $('#pengesahanPembaharuan').modal('hide');
                        $('#semakFpxModal').modal('hide');
                        swal("Rekod pembayaran telah dijumpai\nNama: "+response[0].billTo+"\nJumlah Pembayaran: RM "+response[0].billpaymentAmount+"\nTarikh/Masa Pembayaran: "+response[0].billPaymentDate,{
                            icon:'success',
                            buttons: {
                                cancel: {
                                    text: "Batal",
                                    value: null,
                                    visible: true,
                                    className: "",
                                    closeModal: true,
                                },
                                ok: {
                                    text: "Sahkan Pembayaran",
                                    value: true,
                                    visible: true,
                                    className: "",
                                    closeModal: true,
                                }
                            }
                        }).then((value)=>{
                            if(value){
                                 $.ajax({
                                    type: "post",
                                    url: "{{route('profil.sahkanPembayaranfpx')}}",
                                    data: {
                                        id: idBayaran,
                                        kodFpx: $('#kodFpx').val(),
                                        billpaymentInvoiceNo: response[0].billpaymentInvoiceNo,
                                        _token:"{{csrf_token()}}"
                                    },
                                    dataType: "json",
                                    success: function (response) {
                                        swal("Rekod pembayaran telah berjaya disahkan",{
                                            icon:'success',
                                            buttons: {
                                                cancel: {
                                                    text: "OK",
                                                    value: null,
                                                    visible: true,
                                                    className: "",
                                                    closeModal: true,
                                                }
                                            }
                                        }).then((value)=>{
                                            location.reload();
                                        })
                                    }
                                });
                                alert(idBayaran);
                            }
                        })
                    }else{
                        swal("Rekod pembayaran tidak dijumpai/masih belum dibayar. Sila semak Bill Code yang dimasukkan",{
                            icon:'error',
                            buttons: {
                                cancel: {
                                    text: "OK",
                                    value: null,
                                    visible: true,
                                    className: "",
                                    closeModal: true,
                                }
                            }
                        });
                    }
                }
            });
        }
    });

    $('#btnUploadResit').click(function (e) {
        e.preventDefault();
        var formData = new FormData();
        var fileInput = $('#dokumen')[0].files[0];

        formData.append('dokumen', fileInput);
        formData.append('id', $('#idBayaranPengesahan').val());
        formData.append('_token', '{{ csrf_token() }}');
        $.ajax({
            url: '{{route("profil.kemaskiniDokumen")}}', // replace with your Laravel route
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#iframeBukti').attr('src', '{{ asset('/') }}'+response.buktibayaran);
                swal({
                  title: "Berjaya",
                  text: "Maklumat pembayaran telah berjaya dikemaskini",
                  icon: "success",
                });
                $('#kemaskiniAttachment').modal('hide');
            },
            error: function (error) {
                $.each(error.responseJSON.errors, function (indexInArray, valueOfElement) {
                    $('#'+indexInArray).closest('.form-group').addClass('has-error');
                    $('#'+indexInArray).closest('.form-group').find('.text-danger').text(valueOfElement[0]);
                });
                console.error();
            }
        });
    });

    $('#btnSahkan').click(function (e) {
        e.preventDefault();
        swal("Adakah anda pasti untuk mengesahkan maklumat pembayaran ini?",{
            dangerMode: false,
            icon:'warning',
            buttons: {
                cancel: {
                    text: "Batal",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "Ya, Sahkan",
                    value: true,
                    visible: true,
                    className: "",
                    closeModal: true
                }
            }
        }).then((value)=>{
            if(value){
                $.ajax({
                    type: "post",
                    url: "{{route('profil.sahkanPembayaran')}}",
                    data: {
                        id:$('#idBayaranPengesahan').val(),
                        _token:"{{csrf_token()}}"
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#pengesahanPembaharuan').modal('hide');
                        swal("Rekod pembayaran telah berjaya disahkan",{
                            icon:'success',
                            buttons: {
                                cancel: {
                                    text: "OK",
                                    value: null,
                                    visible: true,
                                    className: "",
                                    closeModal: true,
                                }
                            }
                        }).then((value)=>{
                            location.reload();
                        })
                    }
                });
            }
        });
    });

    $('#pengesahanPembaharuan').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            $('#idBayaranPengesahan').val(id);
            $('#semakFpxBtn').attr('data-id',id);
            $.ajax({
                type: "post",
                url: "{{route('profil.loadPengesahan')}}",
                data: {
                    id:id,
                    _token:"{{csrf_token()}}"
                },
                dataType: "json",
                success: function (response) {
                    $('#iframeBukti').attr('src', '{{ asset('/') }}'+response.bayaran.buktibayaran);
                    $('#rekodPembayaran').empty();
                    $.each(response.bayaran.bayaran_details, function (indexInArray, value) {
                        var tajuk = '';
                        if (value.jenis=="yuran") {
                            tajuk = 'Yuran Tahun '+value.tahun;
                        } else {
                            tajuk = 'Sumbangan';
                        }
                        $('#rekodPembayaran').append('<div class="row"><div class="col-md-6">'+tajuk+'</div><div class="col-md-6"><strong>RM '+value.amaun+'</strong></div></div>');
                    });
                    $('#rekodPembayaran').append('<div class="row"><div class="col-md-12"><hr></div></div>');
                    $('#rekodPembayaran').append('<div class="row"><div class="col-md-6"><strong>JUMLAH</strong></div><div class="col-md-6"><strong>RM '+response.bayaran.jumlahbayaran+'</strong></div></div>');

                }
            });
    });

    $('.statusRadio').change(function(e) {
        e.preventDefault();
        if ($(this).val() == '1') {
            $('#divPasangan').show();
            $('#divAnak').show();
        } else if ($(this).val() == '2' || $(this).val() == '3') {
            $('#divPasangan').hide();
            $('#divAnak').show();
        } else if ($(this).val() == '4') {
            $('#divPasangan').hide();
            $('#divAnak').hide();
        }
    });

    loadTanggungan();
    checkTanggungan();
    checkAllKpAge();

    function checkAllKpAge() {
        $.each($('.nokp'), function(indexInArray, nokp) {
            if ($(nokp).val() != '') {
                var dob = $(nokp).val().substring(0, 6);

                var year = dob.substring(0, 2);
                var month = dob.substring(2, 4);
                var day = dob.substring(4, 6);
                if (year > 40) {
                    year = '19' + year;
                } else {
                    year = '20' + year;
                }
                dob = day + "-" + month + "-" + year;
                var age = calculateAge(dob);
                $(nokp).closest('.row').find('.umur').val(age);
            }
        });
    }

    $(document).on("keyup", ".nokp", function(e) {

        var s = $(this).val();
        if (s.length == 6) {
            $(this).val(s + "-");
        }

        if (s.length == 9) {
            $(this).val(s + "-");
        }
    });

    function loadTanggungan() {
        $.ajax({
            type: "post",
            url: "{{ route('tanggungan.loadTanggunganAjax') }}",
            data: {
                _token: '{{ csrf_token() }}',
                id: {{ $keahlian->id }},
            },
            dataType: "json",
            success: function(response) {
                $.each(response.tanggungan, function(indexInArray, tanggungan) {
                    if (tanggungan.nokp != null && tanggungan.nokp.length > 8) {
                        var dob = tanggungan.nokp.substring(0, 6);
                        var year = dob.substring(0, 2);
                        var month = dob.substring(2, 4);
                        var day = dob.substring(4, 6);
                        if (year > 40) {
                            year = '19' + year;
                        } else {
                            year = '20' + year;
                        }
                        dob = day + "-" + month + "-" + year;
                        var age = calculateAge(dob);

                    } else {
                        var age = tanggungan.umur;
                    }

                    $('#tanggunganDiv').append(
                        '<div class="row">' +
                        '<input type="hidden" name="idTanggungan[]" id="idTanggungan[]" class="form-control" value="'+tanggungan.id+'">' +
                        '<div class="col-md-4 form-group form-group-default">' +
                        '<label for="namaTanggungan[]" class="required-label namatanggung">Nama Tanggungan</label>' +
                        '<input class="form-control" required="required" placeholder="NAMA PENUH" name="namaTanggungan[]" type="text" value="'+tanggungan.nama+'" id="namaTanggungan[]">' +
                        '<small class="text-danger"></small>' +
                        '</div>' +
                        '<div class="col-md-4 form-group form-group-default">' +
                        '<label for="noKpTanggungan[]" class="required-label">No K/P, Mykid, Surat Beranak</label>' +
                        '<input class="form-control nokp" required="required" placeholder="cth: 840909-10-4543" name="noKpTanggungan[]" type="text" value="'+tanggungan.nokp+'" id="noKpTanggungan[]">' +
                        '<small class="text-danger"></small>' +
                        '</div>' +
                        '<div class="col-md-3 form-group form-group-default">' +
                        '<label for="umurTanggungan[]" class="required-label">Umur</label>' +
                        '<input class="form-control umurTanggungan umur" required="required" placeholder="Umur" name="umurTanggungan[]" type="number" value="'+age+'" id="umurTanggungan[]">' +
                        '<small class="text-danger"></small>' +
                        '</div>' +
                        '<div class="col-md-1 form-group form-group-default">' +
                        '<label style="color:white">a</label>' +
                        '<button type="button" class="btn btn-danger btn-removeTanggungan" data-id="'+tanggungan.id+'"><i class="fa fa-trash" aria-hidden="true" ></i></button>' +
                        '</div>' +
                        '</div>'
                    );
                });
                checkTanggungan();
            }
        });
    }

    function createDateFromFormat(dateString, format) {
        var dateParts = dateString.split("-");
        var day, month, year;

        if (format === "dd-mm-yyyy") {
            day = parseInt(dateParts[0], 10);
            month = parseInt(dateParts[1], 10) - 1; // Months are zero-based (0-11)
            year = parseInt(dateParts[2], 10);
        }

        return new Date(year, month, day);
    }

    function checkTanggungan() {
        if ($('.namatanggung').length > 0) {
            $('#tanggunganDiv').find('.norecord').remove();
        } else {
            $('#tanggunganDiv').empty();
            $('#tanggunganDiv').append(
                '<div class="row norecord"><div class="col-md-12 text-center"><h4 class="text-muted">Tiada rekod</h4></div></div>'
                );
        }
    }

    function calculateAge(dateOfBirth) {
        var today = new Date();
        var birthDate = createDateFromFormat(dateOfBirth, "dd-mm-yyyy");
        console.log(birthDate);

        var yearsDiff = today.getFullYear() - birthDate.getFullYear();
        var monthsDiff = today.getMonth() - birthDate.getMonth();
        var daysDiff = today.getDate() - birthDate.getDate();

        // Check if the birth date month and day are ahead of today's month and day
        if (monthsDiff < 0 || (monthsDiff === 0 && daysDiff < 0)) {
            yearsDiff--;
        }

        return yearsDiff;
    }

    $('#tambahTanggungan').click(function(e) {
        e.preventDefault();
        $('#tanggunganDiv').append(
            '<div class="row">' +
            '<input type="hidden" name="idTanggungan[]" id="idTanggungan[]"  class="form-control" value="">' +
            '<div class="col-md-4 form-group form-group-default">' +
            '<label for="namaTanggungan[]" class="required-label namatanggung">Nama Tanggungan</label>' +
            '<input class="form-control" required="required" placeholder="NAMA PENUH" name="namaTanggungan[]" type="text" value="" id="namaTanggungan[]">' +
            '<small class="text-danger"></small>' +
            '</div>' +
            '<div class="col-md-4 form-group form-group-default">' +
            '<label for="noKpTanggungan[]" class="required-label">No K/P, Mykid, Surat Beranak</label>' +
            '<input class="form-control nokp" required="required" placeholder="cth: 840909-10-4543" name="noKpTanggungan[]" type="text" value="" id="noKpTanggungan[]">' +
            '<small class="text-danger"></small>' +
            '</div>' +
            '<div class="col-md-3 form-group form-group-default">' +
            '<label for="umurTanggungan[]" class="required-label">Umur</label>' +
            '<input class="form-control umurTanggungan umur" required="required" placeholder="Umur" name="umurTanggungan[]" type="number" value="" id="umurTanggungan[]">' +
            '<small class="text-danger"></small>' +
            '</div>' +
            '<div class="col-md-1 form-group form-group-default">' +
            '<label style="color:white">a</label>' +
            '<button type="button" class="btn btn-danger btn-removeTanggungan" data-id=""><i class="fa fa-trash" aria-hidden="true" ></i></button>' +
            '</div>' +
            '</div>'
        );
        checkTanggungan();
    });

    $(document).on("click", ".btn-removeTanggungan", function(e) {
        var tanggugnanId = $(this).attr('data-id');
        var element = $(this);

        swal({
            title: "Andakah anda pasti?",
            text: "Tindakan anda akan mengeluarkan tanggungan ini daripada senarai tanggungan anda",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Batal",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "Ya, saya pasti!",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }
            }
        }).then((value) => {
            // alert(value);
            if (tanggugnanId != '') {

                if (value == true) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('tanggungan.deleteTanggunganAjax') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: tanggugnanId,
                        },
                        dataType: "json",
                        success: function(response) {
                            swal("Berjaya!",
                                "Tanggungan telah dikeluarkan dari senarai tanggungan anda.",
                                "success").then(() => {
                                $(element).closest('.row').remove();
                            });
                        }
                    });
                }
                checkTanggungan();
            } else {
                $(element).closest('.row').remove();
                checkTanggungan();
            }
        });
    });

    $('#formDaftar').validate({
        rules: {
            namapasangan: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            nokppasangan: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            tlahirpasangan: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            umurpasangan: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            pekerjaanpasangan: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            notelpasangan_hp: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            }
        },
        invalidHandler: function(form, validator) {
            if (validator.errorList.length) {
                var firstErrorElement = validator.errorList[0].element;
                $('html, body').animate({
                    scrollTop: $(firstErrorElement).offset().top - 200
                }, 500);
            }
        }
    });

    $(document).on("change", ".nokp ", function(e) {
        var dob = $(this).val().substring(0, 6);

        var year = dob.substring(0, 2);
        var month = dob.substring(2, 4);
        var day = dob.substring(4, 6);
        if (year > 40) {
            year = '19' + year;
        } else {
            year = '20' + year;
        }
        dob = day + "-" + month + "-" + year;
        var age = calculateAge(dob);
        $(this).closest('.row').find('.umur').val(age);
    });

    $('.btnPembayaran').click(function (e) {
        e.preventDefault();
        var type = $(this).attr('data-type');
        var err=0;
        $.each($('.umurTanggungan'), function (indexInArray, valueOfElement) {
            var umur = $(valueOfElement).val();
            if(umur>25){
                $(valueOfElement).removeClass('valid');
                $(valueOfElement).addClass('error');
                $(valueOfElement).next().text('Umur tanggungan tidak boleh melebihi 25 tahun');
                err++;
                el = $(valueOfElement).closest('.form-group');
            }else{
                $(valueOfElement).closest('.form-group').find('.umurTanggungan').removeClass('error');
                $(valueOfElement).closest('.form-group').find('.umurTanggungan').next().text('');
            }

        });
        if(err>0){
            $('html, body').animate({
            scrollTop: $(el).offset().top - 200
            }, 500);
            return false;
        }else{

            swal({
                title: "Andakah anda pasti?",
                text: "Saya dengan ini mengesahkan bahawa maklumat yang diberikan adalah benar dan sah.",
                icon: "warning",
                buttons: {cancel: {
                    text: "Batal",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "Ya, saya pasti!",
                    value: true,
                    visible: true,
                    className: "btn-danger",
                    closeModal: true
                }}
            }).then((value)=>{
                // alert(value);
                if(value==true){
                    $('#requestType').val(type);
                    $('#formDaftar').submit();

                }
            });
        }
    });

</script>
@endsection
