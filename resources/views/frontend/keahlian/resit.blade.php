@extends('layouts.appFront')

@section('head')
<style>

    .toggle-header, .toggle-content {

        font-size: 18px;
        line-height: 24px;
        font-weight: 400;
    }

    .toggle-active > .toggle-header{
        color: #fd680e;
    }

    .row.clearfix.btnFix{
        --bs-gutter-x: 0rem!important;
    }

    .button.button-full.button-left{
        background-color: #1ABC9C;
    }

    .button.button-full.button-right{
        background-color: #f9a622;
    }

    .button.button-full.button-left:hover{
        background-color: #2b2b2b;
    }

    .button.button-full.button-right:hover{
        background-color: #2b2b2b;
    }


    #blink {
        font-size: 20px;
        font-weight: bold;
        font-family: sans-serif;
        color: #1c87c9;
        transition: 0.4s;
    }
    .required-label::before {
        content: "*";
        color: red;
    }

    label.error{
        color: red;
        display: block!important;
    }

    table.detailTbl {
        border-collapse: collapse;
        width: 100%;
    }

    table.detailTbl>thead>tr>th, table.detailTbl>tbody>tr>td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    .detailTbl>th {
        background-color: #f2f2f2;
    }

    table.detailTbl>tbody>tr:nth-child(even) {
        background-color: #c1f8e7;
    }

    #txtResit{
        font-size: 18pt;
    }

    #pageBody{
        padding: 50px!important;
    }

    .bottomBorder{
        border-bottom: 3px solid #62bf3d!important;
    }

    @media print {
        @page {
            size: A5;
            margin: 0;
        }

        #txtResit{
            font-size: 14pt!important;
        }

        #pageBody{
            padding-top: 30px!important;
            padding-bottom: 30px!important;
            padding-left: 50px!important;
            padding-right: 50px!important;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 10pt;
        }

        table.detailTbl>tbody>tr:nth-child(even) {
            background-color: #c1f8e7;
        }

        .footer-logo{
            max-width: 120px!important;
        }

        .card{
            border: none!important;
            box-shadow: none!important;
        }

        hr{
            border-top: 1px solid #000!important;
        }

        .bottomBorder{
            border-bottom: 1px solid #62bf3d!important;
        }

        .card {
            position: relative;
        }

        .card img.cop {
            position: absolute;
            top: 620px;
            left: 350px;
            z-index: 9999;
            max-width: 120px!important;
        }

        .card .copTarikh {
            color: red;
            position: absolute;
            top: 670px;
            left: 370px;
            z-index: 9999;
        }
    }
    .container {
        position: relative;
    }

    .container img.cop {
        position: absolute;
        top: 730px;
        left: 650px;
        z-index: 9999;
    }

    .container .copTarikh {
        color: red;
        position: absolute;
        top: 785px;
        left: 676px;
        z-index: 9999;
    }

</style>

@endsection

@section('header')
<section id="page-title" class="page-title-center">

    <div class="container clearfix">
        @if ($bayaran->statusbayaran=='1')
            <h1 class="text-success">Resit Pembayaran</h1>
            <span>Terima kasih kerana telah bersama kami.</span>
        @else
            <h1 class="text-danger">Pembayaran Gagal</h1>
            <span>Sila laksanakan pembayaran anda sekali lagi.</span>
        @endif

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Utama</a></li>
            <li class="breadcrumb-item"><a href="#">Pembaharuan Keahlian</a></li>
            <li class="breadcrumb-item"><a href="#">Resit</a></li>
        </ol>
    </div>
</section>
@endsection
@section('content')
<div class="content-wrap">
    <div class="container">
        @if ($bayaran->statusbayaran=='1')
        <div class="row mt-3">
            <div class="col-md-8 offset-md-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Terima kasih kerana telah bersama kami.</strong> Sila cetak resit pembayaran anda.
                    <button type="button" class="btn btn-lg pt-0" onclick="printDiv('printable-content')"><i class="fa fa-print"></i></button>
                    <button type="button" class="btn btn-lg pt-0" ><i class="fa fa-download"></i></button>
                </div>
                @include('resit.index')
            </div>
        </div>
        @elseif ($bayaran->statusbayaran=='4')
            <center><i class="fa fa-times-circle fa-5x text-danger" style="font-size: 120pt"></i></center>
            <div class="row">

                <div class="col-md-12 text-center">
                    <h1 class="text-danger mb-0">Pembayaran Gagal</h1>
                    <span>Sila laksanakan pembayaran anda sekali lagi.</span>
                    <br>
                    <a href="{{env('TOYYIBPAYURL')}}/{{$bayaran->billCode}}" class="btn btn-lg btn-success mt-2">Proses Pembayaran</a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
@section('script')

@endsection
