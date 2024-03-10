@extends('layouts.app')

@section('head')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Senarai Penerima</a></li>
@endsection

@section('actions')
<div class="float-right">
    <button class="btn btn-primary" id="btnRekod" data-toggle="modal" data-target="#tambahRekod"> <i class="fa fa-plus" ></i> Tambah Rekod</button>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Senarai Penerima
            </div>
            <div class="card-body">
                <table class="table table-hover" id="tablePenerima">
                    <thead>
                        <tr>
                            <th>
                                Nama
                            </th>
                            <th>
                                No K/P
                            </th>
                            <th>
                                Tarikh Meninggal
                            </th>
                            <th>
                                Kubur
                            </th>
                            <th>
                                Status Keahlian
                            </th>
                            <th>
                                Manfaat
                            </th>
                            <th>
                                Tabung
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($senaraiPenerima as $penerima)
                        <tr>
                            <td>
                                {{ $penerima->nama != '' ? $penerima->nama : 'N/A' }}
                            </td>
                            <td align="center">
                                {{ $penerima->nokpmeninggal != '' ? $penerima->nokpmeninggal : 'N/A' }}
                            </td>
                            <td data-order="{{\Carbon\Carbon::parse($penerima->tarikhmeninggal)->getTimestamp()}}">
                                {{\Carbon\Carbon::parse($penerima->tarikhmeninggal)->format('d-m-Y')}}
                            </td>
                            <td>
                                {{ $penerima->kubur != '' ? $penerima->kubur : 'N/A' }}
                            </td>
                            <td align="center">
                                @if ($penerima->status == '1')
                                    <span class="badge badge-pill badge-success">Ahli</span> <br>
                                    <small>{{$penerima->hubungan != '' ? $penerima->hubungan : 'N/A'}}</small>
                                @else
                                    <span class="badge badge-pill badge-warning">Bukan Ahli</span>
                                @endif
                            </td>
                            <td align="right">
                                {{$penerima->manfaat != '' ? number_format($penerima->manfaat,2) : '-'}}
                            </td>
                            <td align="right">
                                {{$penerima->tabung != '' ? number_format($penerima->tabung,2) : '-'}}

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{!! Form::open(['method' => 'POST', 'route' => 'penerima.store', 'id'=>'formPenerima']) !!}
<!-- Modal -->
<div class="modal fade slide-right " id="tambahRekod" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog " role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Rekod</h5>
            </div>

            <div class="modal-body">
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('nokp') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('nokp', 'No Kad Pengenalan Arwah') !!}
                            {!! Form::text('nokp', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('nokp') }}</small>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('tarikhmeninggal') ? ' has-error' : '' }} form-group-default ">
                                {!! Form::label('tarikhmeninggal', 'Tarikh Meninggal') !!}
                                {!! Form::date('tarikhmeninggal', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                <small class="text-danger">{{ $errors->first('tarikhmeninggal') }}</small>
                            </div>
                        </div>
                        <button id="btnSemak" type="button" class="btn btn-block btn-primary" >Semak</button>
                    </div>
                </div>
                <div  id="borangKematian"  class="row d-none mt-3">
                    <input type="hidden" name="nokpketua" id="nokpketua" class="form-control" value="">
                    <input type="hidden" name="kodpengguna" id="kodpengguna" class="form-control" value="">
                    <input type="hidden" name="hubungan" id="hubungan" class="form-control" value="">

                    <div class="col-md-12">
                        <span id="keahlian"></span>&nbsp;&nbsp;<span id="jenis"></span>
                        <div class="form-group{{ $errors->has('nama') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('nama', 'Nama') !!}
                            {!! Form::text('nama', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('nama') }}</small>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('kubur') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('kubur', 'Tanah Perkuburan') !!}
                            {!! Form::text('kubur', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('kubur') }}</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('manfaat') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('manfaat', 'Manfaat') !!}
                            {!! Form::number('manfaat', 0, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('manfaat') }}</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('tabung') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('tabung', 'Tabung') !!}
                            {!! Form::number('tabung', 0, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('tabung') }}</small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group{{ $errors->has('ulasan') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('ulasan', 'Ulasan') !!}
                            {!! Form::textarea('ulasan', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('ulasan') }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" id="btnSimpan" class="btn btn-primary">Simpan</button>
            </div>

        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection

@section('script')
<script>
    $('#tablePenerima').DataTable({
        "responsive": true,
        "order": [[ 0, "asc" ]]
    });

    $("#nokp").keyup(function(){
		var s= $("#nokp").val();
		if(s.length == 6){
			$("#nokp").val(s+"-");
		}

		if(s.length == 9){
			$("#nokp").val(s+"-");
		}
	});

    $('#btnSimpan').click(function (e) {
        e.preventDefault();

    });

    $('#tambahRekod').on('show.bs.modal', function (event) {
        $('#formPenerima')[0].reset();
        $('#nokpketua').val('');
        $('#kodpengguna').val('');
        $('#hubungan').val('');
        $('#keahlian').empty();
        $('#jenis').empty();
    });


    $('#btnSemak').click(function (e) {
        $('#nokp').closest('.form-group').removeClass('has-error');
        $('#nokp').closest('.form-group').find('.text-danger').text('');
        $('#tarikhmeninggal').closest('.form-group').removeClass('has-error');
        $('#tarikhmeninggal').closest('.form-group').find('.text-danger').text('');
        var nokp=$('#nokp').val();
        if($('#nokp').val() == '' ){
            $('#nokp').closest('.form-group').addClass('has-error');
            $('#nokp').closest('.form-group').find('.text-danger').text('Sila masukkan No Kad Pengenalan');
            return false;
        }else if($('#tarikhmeninggal').val() == '' ){
            $('#tarikhmeninggal').closest('.form-group').addClass('has-error');
            $('#tarikhmeninggal').closest('.form-group').find('.text-danger').text('Sila masukkan Tarikh Meninggal');
            return false;
        }else{
            $('#nokp').closest('.form-group').removeClass('has-error');
            $('#nokp').closest('.form-group').find('.text-danger').text('');
            $.ajax({
                type: "post",
                url: "{{route('penerima.semak')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                    nokp: $('#nokp').val(),
                    tarikhMeninggal : $('#tarikhmeninggal').val()
                },
                dataType: "json",
                success: function (response) {
                    $('#nokpketua').val('');
                    $('#nama').val('');
                    $('#kodpengguna').val('');
                    $('#hubungan').val('');
                    $('#keahlian').empty();
                    $('#jenis').empty();
                    $('#borangKematian').removeClass('d-none');
                    if (response.status=='success' ) {
                        if(response.status_aktif == 'true'){
                            if (response.type=='ketua') {
                                $('#nokpketua').val(response.keahlian.nokp);
                                $('#nama').val(response.keahlian.nama);
                                $('#kodpengguna').val(response.keahlian.kodpengguna);
                                $('#hubungan').val('Ketua Keluarga');
                                $('#keahlian').html('<span class="badge badge-success">Ahli</span>');
                                $('#jenis').html('<span class="badge badge-info">Ketua Keluarga</span>');
                            } else if(response.type=='pasangan') {
                                $('#nokpketua').val(response.keahlian.nokp);
                                $('#nama').val(response.keahlian.namapasangan);
                                $('#kodpengguna').val(response.keahlian.kodpengguna);
                                $('#hubungan').val('Pasangan');
                                $('#keahlian').html('<span class="badge badge-success">Ahli</span>');
                                $('#jenis').html('<span class="badge badge-info">Pasangan</span>');
                            } else if(response.type=='tanggungan') {
                                $('#nokpketua').val(response.tanggungan.ketua.nokp);
                                $('#nama').val(response.tanggungan.nama);
                                $('#kodpengguna').val(response.tanggungan.ketua.kodpengguna);
                                $('#hubungan').val('Tanggungan');
                                $('#keahlian').html('<span class="badge badge-success">Ahli</span>');
                                $('#jenis').html('<span class="badge badge-info">Tanggungan</span>');
                            }
                        }else{

                            $('#nokpketua').val('');
                            $('#kodpengguna').val('');
                            $('#hubungan').val('');
                            $('#keahlian').html('<span class="badge badge-warning text-black">Bukan Ahli</span>');
                            $('#jenis').empty();
                            $('#nokp').val(nokp);
                            if (response.type=='ketua') {
                                $('#nama').val(response.keahlian.nama);
                            } else if(response.type=='pasangan') {
                                $('#nama').val(response.keahlian.namapasangan);
                            } else if(response.type=='tanggungan') {
                                $('#nama').val(response.tanggungan.nama);
                            }
                        }
                    }else{

                        $('#nokpketua').val('');
                        $('#kodpengguna').val('');
                        $('#hubungan').val('');

                        $('#keahlian').html('<span class="badge badge-warning text-black">Bukan Ahli</span>');
                        $('#jenis').empty();
                        $('#nokp').val(nokp);
                    }
                }
            });
        }
    });


    $('#btnSimpan').click(function (e) {
        e.preventDefault();
        var nokp=$('#nokp').val();
        var nama=$('#nama').val();
        var kodpengguna=$('#kodpengguna').val();
        var hubungan=$('#hubungan').val();
        var manfaat=$('#manfaat').val();
        var tabung=$('#tabung').val();
        var ulasan=$('#ulasan').val();
        var jenis=$('#jenis').text();
        var keahlian=$('#keahlian').text();
        var nokpketua=$('#nokpketua').val();
        var tarikhmeninggal=$('#tarikhmeninggal').val();
        var kubur=$('#kubur').val();

        if($('#formPenerima').valid()){
            $('#formPenerima').submit();
        }
    });

</script>
@endsection

