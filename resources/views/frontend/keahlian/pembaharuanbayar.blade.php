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
        <h1>Proses Pembayaran Keahlian</h1>

        <span>Terima kasih kerana telah bersama kami.</span>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('index')}}">Utama</a></li>
            <li class="breadcrumb-item"><a href="#">Pembaharuan Keahlian</a></li>
            <li class="breadcrumb-item"><a href="#">Proses Pembayaran Keahlian</a></li>
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
                                    <h4>Borang Pembayaran</h4>
                                </div>

                                <div class="row">
                                    <div class="heading-block center">
                                        <h4 class="highlight-me">Maklumat Ketua Keluarga</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <strong>NAMA PENUH : </strong>
                                        {{$keahlian->nama}}
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-6 mt-3">
                                            <strong>NO KAD PENGENALAN : </strong>
                                            {{$keahlian->nokp}}
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <strong>TARIKH LAHIR : </strong>
                                            {{\Carbon\Carbon::parse($keahlian->tlahir)->format('d-m-Y')}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <strong>UMUR : </strong>
                                            {{\Carbon\Carbon::parse($keahlian->tlahir)->diffInYears(\Carbon\Carbon::now())}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mt-3">
                                            <strong>NO. TEL.(R) : </strong>{{$keahlian->notel_r ?? 'N/A'}}
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <strong>NO. TEL.(HP) : </strong>{{$keahlian->notel_hp ?? 'N/A'}}
                                        </div>
                                        <div class="col-md-4 mt-3">
                                            <strong>NO. TEL.(P) : </strong>{{$keahlian->notel_p ?? 'N/A'}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <strong>PEKERJAAN : </strong>{{$keahlian->pekerjaan ?? 'N/A'}}
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <strong>EMAIL : </strong>{{$keahlian->user->email ?? 'N/A'}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <strong>ALAMAT : </strong>{{$keahlian->alamat ?? 'N/A'}}
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <strong>KAWASAN ALAMAT : </strong>{{$keahlian->kumpulanAlamat->keterangan ?? 'N/A'}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mt-3">
                                            <strong>STATUS PERKAHWINAN : </strong>
                                            @if ($keahlian->status=='1')
                                                BERKAHWIN
                                            @elseif($keahlian->status=='2')
                                                JANDA
                                            @elseif($keahlian->status=='3')
                                                DUDA
                                            @else
                                                BUJANG
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if ($keahlian->status=='1')
                                    <hr>
                                    <div class="row mb-3" id="divPasangan">
                                        <div class="heading-block center">
                                            <h4 class="highlight-me">Maklumat Pasangan</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <strong>NAMA PENUH PASANGAN : </strong>{{$keahlian->namapasangan ?? 'N/A'}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <strong>NO KAD PENGENALAN : </strong>{{$keahlian->nokppasangan ?? 'N/A'}}
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <strong>TARIKH LAHIR : </strong>{{\Carbon\Carbon::parse($keahlian->tlahirpasangan)->format('d-m-Y')}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mt-3">
                                                <strong>UMUR : </strong>{{$keahlian->umurpasangan ?? 'N/A'}}
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <strong>PEKERJAAN : </strong>{{$keahlian->pekerjaanpasangan ?? 'N/A'}}
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <strong>NO TEL. : </strong>{{$keahlian->notelpasangan_hp ?? 'N/A'}}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($keahlian->tangungan->count()>0)
                                <div class="row" id="divAnak">
                                    <hr>
                                    <div class="heading-block center">
                                        <h4 class="highlight-me">Maklumat anak-anak yang berumur 1 tahun sehingga 23 tahun yang masih dalam tanggungan</h4>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            @foreach ($keahlian->tangungan as $key=>$tanggungan)
                                            <div class="col-md-4 mt-3">
                                                <div class="card ">
                                                    <small>
                                                    <div class="card-header text-white bg-warning">
                                                        TANGGUNGAN {{$key+1}}
                                                    </div>
                                                    <div class="card-body">
                                                        <strong>NAMA : </strong><br>
                                                        {{$tanggungan->nama}}
                                                        <br> <br>
                                                        <strong>NO KAD PENGENALAN : </strong><br>
                                                        {{$tanggungan->nokp}}
                                                        <br> <br>
                                                        <strong>UMUR : </strong><br>
                                                        {{$tanggungan->umur}} TAHUN
                                                    </div>
                                                    </small>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="row mt-3" id="divWaris">
                                    <hr>
                                    <div class="heading-block center">
                                        <h4 class="highlight-me">Waris Terdekat (Jika berlaku kecemasan & rujukan)</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>NAMA PENUH : </strong>{{$keahlian->namawaris ?? 'N/A'}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <strong>HUBUNGAN : </strong>{{strtoupper($keahlian->hubunganwaris) ?? 'N/A'}}
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <strong>NO. TELEFON 1: </strong>{{$keahlian->notelwaris_1 ?? 'N/A'}}
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <strong>NO. TELEFON 2: </strong>{{$keahlian->notelwaris_2 ?? 'N/A'}}
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <strong>AQAD: </strong>Nama-nama di atas adalah dibawah tanggungan saya, MAKA dengan ini saya bersetuju menjadi ahli khairat kematian dengan bayaran berikut serta bersetuju lebihan sumbangan dimasukkan kedalam akaun dana BKKSAH, Bandar Saujana Putra.
                                </div>
                                <form id="formBayaran">
                                    <div class="row mt-3" id="divPembayaran">
                                        <div class="col-md-6">
                                            <div class="form-group{{ $errors->has('caraPembayaran') ? ' has-error' : '' }}">
                                                {!! Form::label('caraPembayaran', 'CARA PEMBAYARAN') !!}
                                                {!! Form::select('caraPembayaran',['1'=>'BANK TRANSFER','2'=>'FPX'], null, ['id' => 'caraPembayaran', 'class' => 'form-control', 'required' => 'required']) !!}
                                                <small class="text-danger">{{ $errors->first('caraPembayaran') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {!! Form::label('tahunPembayaran', 'Tahun Pembayaran') !!}
                                                <div class="checkbox{{ $errors->has('checkbox_id') ? ' has-error' : '' }}">
                                                    @forelse ($yearsToRenew as $key=>$year)
                                                    <label for="checkbox_id">
                                                        {!! Form::checkbox('checkboxTahun[]', $year, null, ['id' => 'checkboxTahun_'.$year, 'class'=>'checkboxTahun', sizeOf($yearsToRenew) > 1 && $key==1 ? 'disabled' : '','data-key'=>$key]) !!} Tahun {{$year}} 
                                                    </label>&nbsp;&nbsp;&nbsp;
                                                    @empty
                                                        Tiada Keperluan Untuk Pembaharuan
                                                    @endforelse
                                                </div>
                                                <small class="text-danger">{{ $errors->first('checkbox_id') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group{{ $errors->has('derma') ? ' has-error' : '' }}">
                                                {!! Form::label('derma', 'Derma BKKSAH (RM)') !!}
                                                {!! Form::number('derma', 0, ['class' => 'form-control', 'required' => 'required','id'=>'derma']) !!}
                                                <small class="text-danger">{{ $errors->first('derma') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }}">
                                                {!! Form::label('jumlah', 'JUMLAH PEMBAYARAN (RM)') !!}
                                                {!! Form::number('jumlah', 0, ['class' => 'form-control', 'required' => 'required','readonly','id'=>'jumlah']) !!}
                                                <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="divBuktiPembayaran">
                                            <div class="form-group{{ $errors->has('buktiSumbangan') ? ' has-error' : '' }}">
                                                {!! Form::label('buktiSumbangan', 'Bukti Pembayaran') !!}
                                                {!! Form::file('buktiSumbangan', ['id'=>'buktiSumbangan']) !!}
                                                <p class="help-bootock"><i>Valid file type: .jpg, .png, .pdf. <br>File size max: 1 MB<i></p>
                                                <small class="text-danger">{{ $errors->first('buktiSumbangan') }}</small>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 text-center">
                                            <button class="btn btn-primary" type="button" id="btnPembayaran">Proses Pembayaran</button>
                                        </div>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script>
    $('#caraPembayaran').change(function (e) {
        e.preventDefault();
        if($(this).val()==1){
            $('#divBuktiPembayaran').show();
            $('#buktiSumbangan').attr('required',true);
        }else{
            $('#divBuktiPembayaran').hide();
            $('#buktiSumbangan').attr('required',false);
        }
    });

    $.validator.addMethod("requireOneCheckbox", function(value, element, params) {
        return $(params).filter(":checked").length > 0;
    }, "Sila pilih tahun sumbangan.");

    $('#formBayaran').validate({
        rules: {
            buktiSumbangan: {
                required: {
                    depends: function(element) {
                        return $('#caraPembayaran').val() == '1';
                    },
                },
                extension: "jpg|jpeg|png|pdf",
                maxsize: 1048576
            },
            @foreach ($yearsToRenew as $year)
            'checkboxTahun[]': {
                requireOneCheckbox: ".checkboxTahun"
            },
            @endforeach
        },
        messages: {
            buktiSumbangan: {
                extension: "Sila muatnaik fail jenis JPG, JPEG, PNG, PDF",
                maxsize: "Saiz fail melibihi had yang ditetapkan. Saiz maksima: 1MB"
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("type") === "checkbox") {
                error.insertAfter(element.closest(".form-group").find('.text-danger'));
            } else {
                error.insertAfter(element);
            }
        },
    });

    $('#btnPembayaran').click(function (e) {
        e.preventDefault();
        if($('#formBayaran').valid()){
            $('body').waitMe({});
            var formData = new FormData($('#formBayaran')[0]);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('nokp', '{{ $keahlian->nokp }}');
            formData.append('type', '{{ $type }}');
            $.ajax({
                type: "post",
                url: "{{route('keahlian.front.pembayaran')}}",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (response) {

                    if(response.status=='success' && $('#caraPembayaran').val()=='1'){
                        $('body').waitMe("hide");
                        swal({
                            title: "Berjaya!",
                            text: 'Rekod pembayaran anda akan disemak dan disahkan oleh pihak kami. Anda akan dimaklumkan melalui emel sekiranya pembayaran anda telah disahkan.',
                            icon: "success",
                            button: "Tutup"
                        }).then((value) => {
                            window.location.href = "{{route('keahlian.front.perincian',['encid'=>Crypt::encrypt($keahlian->id)])}}";
                        });
                    }else{
                         window.location.href = "{{env('TOYYIBPAYURL')}}/"+response.fpx.BillCode;
                    }
                },
                error: function(xhr, status, error) {

                    $.each(xhr.responseJSON.errors, function (indexInArray, valueOfElement) {
                        $('#formBayaran').find('#'+indexInArray).closest('.form-group').addClass('has-error');
                        $('#formBayaran').find('#'+indexInArray).closest('.form-group').find('.text-danger').text(valueOfElement[0]);
                        console.log(valueOfElement[0]);
                    });
                    $('body').waitMe("hide");
                    console.log('Ajax request failed. Error:', error);
                }
            });
        }
    });

    $('.checkboxTahun').change(function (e) {
        var selectedYear = $(this).val();
        var selectedKey = $(this).attr('data-key');
        if($(this).is(':checked')){
            if (selectedKey==0) {
                selectedNextYear = parseInt(selectedYear)+parseInt(1);
                $('#checkboxTahun_'+selectedNextYear).prop('disabled', false);
            }
        }else{
            if (selectedKey==0) {
                selectedNextYear = parseInt(selectedYear)+parseInt(1);
                $('#checkboxTahun_'+selectedNextYear).prop("checked", false);
                $('#checkboxTahun_'+selectedNextYear).prop('disabled', true);

            }
        }
        calculateTotal();
    });

    $('#derma').keyup(function (e) {
        e.preventDefault();
        calculateTotal();
    });

    function calculateTotal() {
        var total = 0;
        $('.checkboxTahun').each(function () {
            if($(this).is(':checked')){
                total += parseInt(50);
            }
        });
        var derma = parseInt(0);
        if($('#derma').val()!=''){
           derma = parseInt($('#derma').val());
        }
        var jumlah = total + derma;
        $('#jumlah').val(jumlah);
    }
</script>

@endsection
