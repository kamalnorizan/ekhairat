@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap4.min.css">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
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
        dom: 'Bfrtip',
        "buttons": [{
               "extend": 'copy',
               "text": '<i class="fa fa-files-o" style="color: green;"></i>',
               "titleAttr": 'Copy',
               "action": newexportaction
            },
            {
               "extend": 'excel',
               "text": '<i class="fa fa-file-excel-o" style="color: green;"></i>',
               "titleAttr": 'Excel',
               "action": newexportaction
            },
            {
               "extend": 'csv',
               "text": '<i class="fa fa-file-text-o" style="color: green;"></i>',
               "titleAttr": 'CSV',
               "action": newexportaction
            },
            {
               "extend": 'pdf',
               "text": '<i class="fa fa-file-pdf-o" style="color: green;"></i>',
               "titleAttr": 'PDF',
               "action": newexportaction
            },
            {
               "extend": 'print',
               "text": '<i class="fa fa-print" style="color: green;"></i>',
               "titleAttr": 'Print',
               "action": newexportaction
            }],
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

    function newexportaction(e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
    // Requery the server with the new one-time export settings
    dt.ajax.reload();
};

    $('#jalan, #status, #jenis').change(function (e) {
        e.preventDefault();
        tableAhli.ajax.reload();
    });
</script>
@endsection
