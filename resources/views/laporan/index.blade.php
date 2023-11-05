@extends('layouts.app')

@section('head')
<style>
    #date{
        min-height: 35px!important;
        padding: 2px 9px!important;
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
                            {!! Form::select('jenis',[''=>'Sila Pilih', '1'=>'Pembaharuan','2'=>'Permohonan'], null, ['id' => 'jenis', 'class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('jenis') }}</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group{{ $errors->has('statusPembayaran') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('statusPembayaran', 'Status Pembayaran') !!}
                            {!! Form::select('statusPembayaran',[''=>'Sila Pilih', '1'=>'Telah Bayar','2'=>'Menunggu Pembayaran'], null, ['id' => 'statusPembayaran', 'class' => 'form-control', 'required' => 'required']) !!}
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
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Laporan Pembayaran
            </div>
            <div class="card-body">
                content
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
</script>
@endsection

