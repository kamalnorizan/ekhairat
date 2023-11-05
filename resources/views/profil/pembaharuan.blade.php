@extends('layouts.app')

@section('head')
<style>
    .checktahun{
        cursor: pointer!important;
    }
</style>
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Pembaharuan</a></li>
@endsection

@section('actions')
<div class="float-right">

</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>AQAD: </strong>Nama-nama di atas adalah dibawah tanggungan saya, MAKA dengan ini saya bersetuju menjadi ahli khairat kematian dengan bayaran berikut serta bersetuju lebihan sumbangan dimasukkan kedalam akaun dana BKKSAH, Bandar Saujana Putra.
                </div>
                <form id="formBayaran">
                    <div class="row mt-3" id="divPembayaran">
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label for="caraPembayaran" class="fade">CARA PEMBAYARAN</label>
                                <select id="caraPembayaran" class="form-control" required="required" name="caraPembayaran" aria-invalid="false">
                                    <option value="1">BANK TRANSFER</option>
                                    <option value="2">FPX</option>
                                    @can('access-admin')
                                    <option value="3">TUNAI</option>
                                    @endcan
                                </select>
                                <small class="text-danger"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default ">
                                @php
                                    $key=0;
                                @endphp
                                {!! Form::label('tahunPembayaran', 'Tahun Pembayaran') !!}
                                <div class="checkbox{{ $errors->has('checkbox_id') ? ' has-error' : '' }} ">
                                    @forelse ($yearsToRenew as $year)
                                    <div class="form-check form-check-inline complete">
                                        <input type="checkbox" name="checkboxTahun[]" value="{{$year}}" data-key="{{$key}}" {{ $key==1 ? 'disabled' : '' }} class="checkboxTahun checktahun" id="checkboxTahun_{{$year}}">
                                        <label for="checkboxTahun_{{$year}}" class="checktahun">
                                            Tahun {{$year}}
                                        </label>
                                      </div>
                                      @php
                                          $key++;
                                      @endphp
                                    @empty
                                        Tiada Keperluan Untuk Pembaharuan
                                    @endforelse
                                </div>
                                <small class="text-danger">{{ $errors->first('checkbox_id') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('derma') ? ' has-error' : '' }} form-group-default">
                                {!! Form::label('derma', 'Derma BKKSAH (RM)') !!}
                                {!! Form::number('derma', 0, ['class' => 'form-control', 'required' => 'required','id'=>'derma']) !!}
                                <small class="text-danger">{{ $errors->first('derma') }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('jumlah') ? ' has-error' : '' }} form-group-default">
                                {!! Form::label('jumlah', 'JUMLAH PEMBAYARAN (RM)') !!}
                                {!! Form::number('jumlah', 0, ['class' => 'form-control', 'required' => 'required','readonly','id'=>'jumlah']) !!}
                                <small class="text-danger">{{ $errors->first('jumlah') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" id="divBuktiPembayaran">
                            <div class="form-group{{ $errors->has('buktiSumbangan') ? ' has-error' : '' }} form-group-default">
                                {!! Form::label('buktiSumbangan', 'Bukti Pembayaran') !!}
                                {!! Form::file('buktiSumbangan', ['id'=>'buktiSumbangan']) !!}
                                <p class="help-bootock"><i>Valid file type: .jpg, .png, .pdf. <br>File size max: 1 MB</i></p>
                                <small class="text-danger">{{ $errors->first('buktiSumbangan') }}</small>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            @can('access-admin')
                            <div class="form-check complete">
                                <input name="pengesahanSemak" type="checkbox" id="pengesahanSemak">
                                <label for="pengesahanSemak">
                                    Saya dengan ini mengesahkan bahawa pembayaran ini telah disemak
                                </label>
                                <br><small class="text-danger"></small>
                            </div>
                            @endcan
                            <button class="btn btn-primary btn-lg" type="button" id="btnPembayaran">Proses Pembayaran</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $('#caraPembayaran').change(function (e) {
        e.preventDefault();
        if($(this).val()!=2){
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
        @can('access-admin')
        if($('#pengesahanSemak').is(':checked')){
            $('#formBayaran').find('#pengesahanSemak').closest('.form-check').removeClass('text-danger');
            $('#formBayaran').find('#pengesahanSemak').closest('.form-check').find('.text-danger').text('');

        }else{
            $('#formBayaran').find('#pengesahanSemak').closest('.form-check').addClass('text-danger');
            $('#formBayaran').find('#pengesahanSemak').closest('.form-check').find('.text-danger').text('Sila tandakan kotak pengesahan');
            return false;
        }
        @endcan
        e.preventDefault();
        if($('#formBayaran').valid()){
            $('body').waitMe({});
            var formData = new FormData($('#formBayaran')[0]);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('nokp', '{{ $keahlian->nokp }}');
            $.ajax({
                type: "post",
                url: "{{route('profil.pembayaran')}}",
                data: formData,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function (response) {

                    if(response.status=='success' && $('#caraPembayaran').val()=='1'){
                        $('body').waitMe("hide");
                        @can('access-admin')
                        if($('#pengesahanSemak').is(':checked')){
                            swal({
                                title: "Berjaya!",
                                text: 'Rekod pembayaran telah berjaya direkodkan.',
                                icon: "success",
                                button: "Tutup"
                            }).then((value) => {
                                window.location.href = "{{route('profil.index',['u'=>Crypt::encrypt($keahlian->id)])}}";
                            });
                        }else{
                        @endcan
                            swal({
                                title: "Berjaya!",
                                text: 'Rekod pembayaran anda akan disemak dan disahkan oleh pihak kami. Anda akan dimaklumkan melalui emel sekiranya pembayaran anda telah disahkan.',
                                icon: "success",
                                button: "Tutup"
                            }).then((value) => {
                                window.location.href = "{{route('profil.index',['u'=>Crypt::encrypt($keahlian->id)])}}";
                            });
                        @can('access-admin')
                        }
                        @endcan
                    }else if(response.status=='success' && $('#caraPembayaran').val()=='3'){
                        $('body').waitMe("hide");
                        swal({
                            title: "Berjaya!",
                            text: 'Rekod pembayaran telah berjaya direkodkan.',
                            icon: "success",
                            button: "Tutup"
                        }).then((value) => {
                            window.location.href = "{{route('profil.index',['u'=>Crypt::encrypt($keahlian->id)])}}";
                        });
                    }
                    else{
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
        e.preventDefault();
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

