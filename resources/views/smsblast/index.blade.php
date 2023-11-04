@extends('layouts.app')

@section('head')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">SMS Blast</a></li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card card-default">
            <div class="card-header">
                Penerima
            </div>
            <div class="card-body">
                {!! Form::open(['method' => 'POST', 'route' => 'sms.send']) !!}
                    <input type="hidden" name="mesej" id="mesej">
                    <div class="form-group{{ $errors->has('penerima') ? ' has-error' : '' }} form-group-default ">
                        {!! Form::label('penerima', 'Penerima') !!}
                        {!! Form::select('penerima',[''=>'--Sila Pilih Penerima--','1'=>'Kesemua Ahli','2'=>'Tiada Rekod Pembayaran 2024','3'=>'No Telefon'], null, ['id' => 'penerima', 'class' => 'form-control', 'required' => 'required']) !!}

                        <small class="text-danger">{{ $errors->first('penerima') }}</small>
                    </div>
                    <div class="form-group{{ $errors->has('customTel') ? ' has-error' : '' }} d-none" id="customTelDiv">
                        {!! Form::label('customTel', 'Senarai No Tel') !!}
                        {!! Form::text('customTel', null, ['class' => 'form-control']) !!}
                        <small class="text-help">Masukkan no telefon dibahagikan melalui tanda ;</small>
                        <small class="text-danger">{{ $errors->first('customTel') }}</small>
                    </div>
                    {{-- <div class="form-group{{ $errors->has('mesej') ? ' has-error' : '' }} form-group-default ">
                        {!! Form::label('mesej', 'Mesej') !!}
                        {!! Form::textarea('mesej', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('mesej') }}</small>
                    </div> --}}
                    <div class="form-group{{ $errors->has('tempmesej') ? ' has-error' : '' }} form-group-default ">
                        {!! Form::label('tempmesej', 'tempMesej') !!}
                        {!! Form::select('tempmesej',$templates, null, ['id' => 'tempmesej', 'class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('mesej') }}</small>
                    </div>

                    <div class="well p-4" id="smsWell">
                        <span class="text-success">RM0 Badan Khairat Kematian (BKKSAHBSP) </span><span id="mesejTxt"></span>
                    </div>
                    Jumlah Karekter: <span id="jumlahChar">39</span><br>
                    Jumlah SMS: <span id="jumlahSMS">1</span><br>
                    Jumlah Penerima: <span id="jumlahPenerima">0</span><br>
                    <span class="d-none text-danger" id="msgSms"></span><br>
                    <button class="btn btn-primary float-right" type="sumbit" id="btnSMS">Hantar SMS</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card card-default">
            <div class="card-header">
                Rekod SMS Blast
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover" id="tblSMS">
                    <thead>
                        <tr>
                            <th>Tarikh</th>
                            <th>Mesej</th>
                            <th>Jumlah Penerima</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($smsBlasts as $smsBlast)
                        <tr>
                            <td>
                                {{\Carbon\Carbon::parse($smsBlast->created_at)->format('d-m-Y')}}
                            </td>
                            <td>{{$smsBlast->msg}}</td>
                            <td>{{$smsBlast->smsblastDetails->count()}}</td>
                            <td>

                            </td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#customTel').keyup(function (e) {
        if($('#penerima').val()=='3'){
            var text = $(this).val();
            var numbers = text.split(";");
            var total = numbers.length;
            $('#jumlahPenerima').text(total);
        }
    });

    $('#tempmesej').change(function (e) {
        var val = $(this).val();
        $.ajax({
            type: "post",
            url: "{{route('sms.getTemplate')}}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": val
            },
            dataType: "json",
            success: function (response) {
                if (!$.isEmptyObject(response)) {
                    var text = response.msg;
                    var charCount = $('#mesejTxt').text().length+39;
                    var lineCount = (text.match(/\n/g) || []).length;
                    var leng = charCount+lineCount;
                    var totalSMS = leng/161;
                    $('#mesej').val(text);
                    text = text.replace(/\n/g, "<br>");
                    $('#mesejTxt').html(text);
                    $('#jumlahChar').text(leng);
                    $('#jumlahSMS').text(parseInt(Math.floor(totalSMS))+parseInt(1));
                }else{
                    $('#jumlahChar').text(39);
                    $('#mesej').val('');
                    $('#mesejTxt').html('');
                    $('#jumlahSMS').text(1);
                }

            }
        });

    });

    $('#penerima').change(function (e) {
        e.preventDefault();
        if ($(this).val() == 3) {
            $('#customTelDiv').removeClass('d-none');
            $('#customTel').attr('required',true);
            $('#msgSms').addClass('d-none');
        } else {
            $('#msgSms').addClass('d-none');
            $('#customTelDiv').addClass('d-none');
            $('#customTel').val('').keyup();
            $('#customTel').attr('required',false);
            $.ajax({
                type: "post",
                url: "{{route('sms.penerima')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                    penerima: $(this).val()
                },
                dataType: "json",
                success: function (response) {

                    $('#jumlahPenerima').text(response.jumlah);
                    if(response.msg!='cukup'){
                        // $('#btnSMS').attr('disabled',true);
                        $('#msgSms').removeClass('d-none');
                        $('#msgSms').html('<i>'+response.msg+'</i>');
                    }else{
                        // $('#btnSMS').attr('disabled',false);
                        $('#msgSms').addClass('d-none');
                    }


                }
            });
        }


    });
</script>
@endsection
