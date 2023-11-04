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

</style>

@endsection

@section('header')
<section id="page-title" class="page-title-center">

    <div class="container clearfix">
        @if ($type=='p')
            <h1>Pembaharuan Keahlian</h1>
        @else
            <h1>Kemaskini Maklumat Keahlian</h1>
        @endif

        <span>Terima kasih kerana telah bersama kami.</span>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Utama</a></li>
            @if ($type=='p')
                <li class="breadcrumb-item"><a href="#">Pembaharuan Keahlian</a></li>
            @else
                <li class="breadcrumb-item"><a href="#">Kemaskini Maklumat Keahlian</a></li>
            @endif

        </ol>
    </div>
</section>
@endsection
@section('content')
<div class="content-wrap">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="fancy-title title-bottom-border">
                            <h4 class="text-white">Panduan</h4>
                        </div>
                        Ruangan bertanda <b><span style="color:red">*</span></b> wajib diisi.
                        <hr>
                        Pastikan anda membuat bayaran selepas mendaftar di web ini kepada pegawai supaya permohonan anda diluluskan.
                        <hr>
                        Pastikan anda mendaftar di kariah surau yang betul.
                        <hr>
                        <img style="background:white;" src="{{ asset('images/banklogo.png') }}" width="219" height="65"><br>
                        Online Transfer<br>
                        Sumbangan Badan Khairat Kematian<br>
                        <strong>SURAU AL-HIDAYAH</strong><br>
                        Kuwait Finance House<br>
                        Bandar Saujana Putra.<br>
                        <strong>(No Akaun : 017141001508)</strong><br>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12 d-sm-none mt-3"></div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="fancy-title title-bottom-border">
                                    @if ($type=='p')
                                        <h4>Borang Pendaftaran/Pembaharuan</h4>
                                    @else
                                        <h4>Borang Kemaskini Maklumat Keahlian</h4>
                                    @endif

                                </div>

                                {!! Form::open(['method' => 'POST', 'route' => ['keahlian.front.pembaharuanStore',Crypt::encrypt($keahlian->id)], 'class' => '','id'=>'formDaftar']) !!}

                                @include('frontend.keahlian._formKeahlian')
                                {!! Form::close() !!}
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
    @include('frontend.keahlian._scriptKeahlian')
    $('#btnPembayaran').click(function (e) {
        e.preventDefault();
        // var form = $('#formPembayaran');
        var el;
        if($('#formDaftar').valid()){
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
                        $('#formDaftar').submit();

                    }
                });
            }
        }
    });

</script>

@endsection
