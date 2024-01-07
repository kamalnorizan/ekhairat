@extends('layouts.app')

@section('head')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">SENARAI AHLI</a></li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary bg-success">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('status', 'Status') !!}
                            {!! Form::select('status',[''=>'Pilih Status Keahlian','Aktif'=>'Aktif','Tidak Aktif'=>'Tidak Aktif'], '', ['id' => 'status', 'class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('status') }}</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('jenis') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('jenis', 'Jenis Keahlian') !!}
                            {!! Form::select('jenis',$kategoriKeahlian, null, ['id' => 'jenis', 'class' => 'form-control', 'required' => 'required']) !!}
                            <small class="text-danger">{{ $errors->first('jenis') }}</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group{{ $errors->has('jalan') ? ' has-error' : '' }} form-group-default ">
                            {!! Form::label('jalan', 'Alamat') !!}
                            {!! Form::select('jalan',$jalan, null, ['id' => 'jalan', 'class' => 'form-control', 'required' => 'required','multiple']) !!}
                            <small class="text-danger">{{ $errors->first('jalan') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-body">
                <table class="table" id="tableAhli">
                    <thead>
                        <tr>
                            <th>
                                Nama
                            </th>
                            <th>
                                Status Ahli
                            </th>
                            <th>
                                No. Kad Pengenalan
                            </th>
                            <th>
                                Alamat
                            </th>
                            <th>
                                Tarikh Aktif
                            </th>
                            <th>
                                Tindakan
                            </th>
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
<script>
    $('#status').select2({
        placeholder: 'Sila Pilih Status',
        allowClear: true
    });
    $('#jalan').select2({
        placeholder: 'Pilih Alamat',
        allowClear: true
    });
    $('#jenis').select2({
        placeholder: 'Pilih Jenis Keahlian',
        allowClear: true
    });

    var tableAhli = $('#tableAhli').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "ajax":{
            "method": "POST",
            "url": "{{ route('keahlianadm.ajaxLoadAhli') }}",
            "dataType": "json",
            "data":function(d){
                d._token="{{csrf_token()}}";
                d.status=$('#status').val();
                d.keahlian=$('#jenis').val();
                d.alamat=$('#jalan').val();
            }
        },
        "columns": [
          { "data": "nama" },
          { "data": "statusAhli" },
          { "data": "nokp" },
          { "data": "alamat" },
          { "data": "tarikhaktif" },
          { "data": "tindakan", orderable:false, searchable:false }
        ]
    });

    $('#jalan, #status, #jenis').change(function (e) {
        e.preventDefault();
        tableAhli.ajax.reload();
    });
</script>
@endsection
