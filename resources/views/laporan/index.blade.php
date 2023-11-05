@extends('layouts.app')

@section('head')
<style>
    #date{
        min-height: 35px!important;
        padding: 2px 9px!important;
    }

    .select2-container .select2-selection .select2-selection__rendered .select2-selection__clear {
        right: 0px;
    }
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Laporan Pembayaran</a></li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card bg-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('date', 'Tarikh') !!}
                            {!! Form::text('date', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('date') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('jenis', 'Jenis Permohonan') !!}
                            {!! Form::select('jenis',[''=>'Sila Pilih', '1'=>'Pembaharuan','2'=>'Daftar Baru'], null, ['id' => 'jenis', 'class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('jenis') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has('statusPembayaran') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('statusPembayaran', 'Status Pembayaran') !!}
                            {!! Form::select('statusPembayaran',[''=>'Sila Pilih', '1'=>'Telah Bayar','0,3,4'=>'Menunggu Pembayaran','2'=>'Menunggu Pengesahan'], null, ['id' => 'statusPembayaran', 'class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('statusPembayaran') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has('taman') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('taman', 'Taman') !!}
                            {!! Form::select('taman',$alamat, null, ['id' => 'taman', 'class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('taman') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card cardDiv" data-type="ahliBiasa" style="border-bottom: 10px solid #19AD79">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <i class="fa fa-users fa-5x text-success font-large-2 float-left"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 id="rekodBayaran"><i class="fa fa-spinner fa-spin"></i></h3>
                            <span>REKOD BAYARAN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card cardDiv" data-type="ahliBiasa" style="border-bottom: 10px solid #19AD79">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <i class="fa fa-user-circle fa-5x text-success font-large-2 float-left"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 id="rekodPembaharuan"><i class="fa fa-spinner fa-spin"></i></h3>
                            <span>PEMBAHARUAN</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card cardDiv" data-type="ahliBiasa" style="border-bottom: 10px solid #19AD79">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <i class="fa fa-user-plus fa-5x text-success font-large-2 float-left"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 id="rekodDaftar"><i class="fa fa-spinner fa-spin"></i></h3>
                            <span>DAFTAR BARU</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Laporan Pembayaran
            </div>
            <div class="card-body">
                <table class="table" id="tblBayaran">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>NO/KP</th>
                            <th>Jenis</th>
                            <th>Tarikh Pembayaran</th>
                            <th>Sesi</th>
                            <th>Cara Pembayaran</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>

    $('#jenis').select2({
        placeholder: 'Sila Pilih',
        allowClear: true
    });
    $('#statusPembayaran').select2({
        placeholder: 'Sila Pilih',
        allowClear: true
    });
    $('#taman').select2({
        placeholder: 'Sila Pilih',
        allowClear: true
    });
    $('#date').daterangepicker({
        autoclose: true,
        alwaysShowCalendars: true,
        format: 'yyyy-mm-dd',
        opens: 'right',
        showCustomRangeLabel: true,
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month'),
        locale: {
            format: 'DD-MM-YYYY',
        },
        ranges: {
           'Hari Ini': [moment(), moment()],
           'Semalam': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           '7 Hari Lepas': [moment().subtract(6, 'days'), moment()],
           '30 Hari Lepas': [moment().subtract(29, 'days'), moment()],
           'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
           'Bulan Lepas': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });

    var tblBayaran = $('#tblBayaran').DataTable({
        "processing": true,
        "serverSide": true,
        "bFilter": false,
        "ajax":{
          "url": "{{ route('laporan.ajaxLoadLaporan') }}",
          "dataType": "json",
          "data":function (d){
            d.tarikh = $('#date').val();
            d.jenis = $('#jenis').val();
            d.statusPembayaran = $('#statusPembayaran').val();
            d.taman = $('#taman').val();
          }
        },
        drawCallback:function(settings){
            $('#rekodBayaran').text(settings.json.recordsFiltered);
            $('#rekodPembaharuan').text(settings.json.rekodPembaharuan);
            $('#rekodDaftar').text(settings.json.rekodDaftar);
        },
        "columns": [
          { "data": "nama" },
          { "data": "nokp" },
          { "data": "jenis" },
          { "data": "tarikh" },
          { "data": "sesi" },
          { "data": "cara" },
          { "data": "status" },
        ]
    });

    $('#jenis').change(function (e) {
        e.preventDefault();
        tblBayaran.ajax.reload();
    });
    $('#taman').change(function (e) {
        e.preventDefault();
        tblBayaran.ajax.reload();
    });
    $('#statusPembayaran').change(function (e) {
        e.preventDefault();
        tblBayaran.ajax.reload();
    });
</script>
@endsection

