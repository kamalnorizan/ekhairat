@extends('layouts.app')

@section('head')
<style>
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

    .container {
        position: relative;
    }

    .container img.cop {
        position: absolute;
        top: 730px;
        left: 450px;
        z-index: 9999;
    }

    .container .copTarikh {
        color: red;
        position: absolute;
        top: 785px;
        left: 480px;
        z-index: 9999;
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

        /* .card {
            position: relative;
        } */

        .card img.cop {
            position: absolute;
            top: 620px;
            left: 350px;
            z-index: 9999;
            max-width: 120px!important;
        }

    }


</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">RESIT PEMBAYARAN</a></li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Terima kasih kerana telah bersama kami.</strong> Sila cetak resit pembayaran anda.
                <button type="button" class="btn btn-lg btn-info pt-0" onclick="printDiv('printable-content')"><i class="fa fa-print"></i></button>
                <button type="button" class="btn btn-lg btn-info pt-0" ><i class="fa fa-download"></i></button>
            </div>
            @include('resit.index')
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

</script>
@endsection

