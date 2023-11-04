@extends('layouts.app')

@section('head')
<style>
    .select2-container,.select2-selection{
       width: 100% !important;
    }

    .modal-open .select2-container {
        z-index: 1040; /* Should be less than the z-index of Bootstrap modal (which is usually 1050) */
    }

    .dropdown-item{
        cursor: pointer;
    }
    
    .table{
        width: 100%!important;
    }
</style>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Ketetapan</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#daftardanbaharu">Pendaftaran dan Pembaharuan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pengguna">Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tajaan">Tajaan</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="daftardanbaharu">
                            <h4>Pendaftaran/Pembaharuan</h4>
                            <div class="form-check form-check-inline switch switch-lg">
                                <input type="checkbox" id="configPendaftaran" {{$config->where('type','pendaftaran')->first()->value==1?'checked':''}}>
                                <label for="configPendaftaran">Status Pembaharuan dan Pendaftaran</label>
                            </div>
                            <h4>Tahun Pendaftaran/Pembaharuan</h4>
                            Ketetapan Tahun Sesi : <span class='text-success'><strong>{{$config->where('type','tahunsemasa')->first()->value}}</strong></span>&nbsp;<i class="fa fa-edit" id="editTahunSemasaBtn" style="cursor: pointer;" data-toggle="modal" data-target="#updateTahunSemasa"></i>
                        </div>
                        <div class="tab-pane fade" id="pengguna">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group{{ $errors->has('jenisPengguna') ? ' has-error' : '' }} form-group-default ">
                                                {!! Form::label('jenisPengguna', 'Jenis Pengguna') !!}
                                                {!! Form::select('jenisPengguna',$jenisPengguna, null, ['id' => 'jenisPengguna', 'class' => 'form-control', 'required' => 'required', 'multiple']) !!}
                                                <small class="text-danger">{{ $errors->first('jenisPengguna') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table" width="100%" id="tablePengguna">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Nama
                                                </th>
                                                <th>
                                                    No. Telefon
                                                </th>
                                                <th>
                                                    Email
                                                </th>
                                                <th>
                                                    Jenis Pengguna
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
                        <div class="tab-pane" id="tajaan">
                            <h4>Tajaan</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card" style="border-left: 4px solid green" >
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('tahun') ? ' has-error' : '' }} form-group-default ">
                                                        {!! Form::label('tahun', 'Tahun Tajaan') !!}
                                                        {!! Form::select('tahun',$tahunTajaan, null, ['id' => 'tahun', 'class' => 'form-control', 'required' => 'required']) !!}
                                                        <small class="text-danger">{{ $errors->first('tahun') }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group{{ $errors->has('kategoriPengguna') ? ' has-error' : '' }} form-group-default ">
                                                        {!! Form::label('kategoriPengguna', 'Kategori') !!}
                                                        {!! Form::select('kategoriPengguna',$jenisPenggunaTajaan, null, ['id' => 'kategoriPengguna', 'class' => 'form-control', 'required' => 'required']) !!}
                                                        <small class="text-danger">{{ $errors->first('kategoriPengguna') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card" style="border-left: 4px solid green" >
                                        <div class="card-body">
                                            <table class="table" id="tblTajaan">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>No K/P</th>
                                                        <th>Alamat</th>
                                                        <th>Kategori</th>
                                                        <th>Tahun</th>
                                                        <th>Tindakan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="updateTahunSemasa" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Kemaskini Tahun Semasa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('tahunSesi') ? ' has-error' : '' }} form-group-default ">
                                {!! Form::label('tahunSesi', 'Tahun Sesi') !!}
                                {!! Form::text('tahunSesi', $config->where('type','tahunsemasa')->first()->value, ['class' => 'form-control', 'required' => 'required','disabled']) !!}
                                <small class="text-danger">{{ $errors->first('tahunSesi') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-danger btn-block" id="btnDownTahun">-</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-success btn-block" id="btnUpTahun">+</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Kemaskini</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="mdl-tajaan" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Rekod Tajaan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <input type="hidden" name="tajaanUserId" id="tajaanUserId" class="form-control" value="">

                        @foreach ($tahunTajaan as $key=>$ttaja)
                        @if ($key!='')
                            <div class="col-md-4 divChkTahun" id="div{{$ttaja}}">
                                <div class="form-group">
                                    <div class="checkbox{{ $errors->has('checkbox[]') ? ' has-error' : '' }} form-group-default ">
                                        <label for="checkbox[]">
                                            {!! Form::checkbox('checkbox[]', $ttaja, null, ['id' => 'checkbox_'.$ttaja,'class'=>'chkboxTahun']) !!} {{$ttaja}}
                                        </label>
                                    </div>
                                    <small class="text-danger">{{ $errors->first('checkbox[]') }}</small>
                                </div>
                            </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnSimpanTajaan" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#jenisPengguna').select2({
            placeholder: "Pilih Jenis Pengguna",
            allowClear: true
        });

        var tblPengguna = $('#tablePengguna').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "method":"POST",
                "url": "{{ route('ketetapan.ajaxLoadPengguna') }}",
                "dataType": "json",
                "data":function(d) {
                    d.jenisPengguna = $('#jenisPengguna').val();
                    d._token = "{{csrf_token()}}";
                }
            },
            "columns": [
              { "data": "nama" },
              { "data": "notel" },
              { "data": "email" },
              { "data": "jenisPengguna" },
              { "data": "tindakan" }
            ]
        });

        $('#jenisPengguna').change(function (e) {
            e.preventDefault();
            tblPengguna.ajax.reload();
        });

        $('#btnDownTahun').click(function (e) {
            e.preventDefault();
            var sesi = $('#tahunSesi').val();
            var tahun1 = sesi.split('/')[0];
            var tahun2 = sesi.split('/')[1];
            tahun1 = parseInt(tahun1) - 1;
            tahun2 = parseInt(tahun2) - 1;
            $('#tahunSesi').val(tahun1 + '/' + tahun2);
        });

        $('#btnUpTahun').click(function (e) {
            e.preventDefault();
            var sesi = $('#tahunSesi').val();
            var tahun1 = sesi.split('/')[0];
            var tahun2 = sesi.split('/')[1];
            tahun1 = parseInt(tahun1) + 1;
            tahun2 = parseInt(tahun2) + 1;
            $('#tahunSesi').val(tahun1 + '/' + tahun2);

        });

        $('#configPendaftaran').change(function (e) {
            e.preventDefault();
            if ($('#configPendaftaran').prop('checked')) {
                var status = 1;
            } else {
                var status = 0;
            }

            $.ajax({
                type: "post",
                url: "{{route('ketetapan.updateStatusPembaharuan')}}",
                data: {
                    status: status,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function (response) {

                }
            });
        });

        var tblTajaan = $('#tblTajaan').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "method":"POST",
                "url": "{{ route('ketetapan.ajaxLoadTajaan') }}",
                "dataType": "json",
                "data":function(d) {
                    d.tahun = $('#tahun').val();
                    d.kategoriPengguna = $('#kategoriPengguna').val();
                    d._token = "{{csrf_token()}}";
                }
            },
            "columns": [
              { "data": "nama" },
              { "data": "nokp" },
              { "data": "alamat" },
              { "data": "kategori" },
              { "data": "tahun" },
              { "data": "tindakan" }
            ]
        });

        $('#tahun').change(function (e) {
            e.preventDefault();
            tblTajaan.ajax.reload();
        });

        $('#kategoriPengguna').change(function (e) {
            e.preventDefault();
            tblTajaan.ajax.reload();
        });
        $(document).on("click",".tajaBtn",function (e) {
            $.each($('.divChkTahun'), function (indexInArray, elem) {
                    $(elem).removeClass('d-none');
                    $(elem).find('.chkboxTahun').prop('disabled', false);
                    $(elem).find('.chkboxTahun').prop('checked', false);
            });
            $('#tajaanUserId').val($(this).data('id'));
            var id = $(this).data('id');
            $.ajax({
                type: "post",
                url: "{{route('ketetapan.ajaxLoadRekodTajaan')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id:id
                },
                dataType: "json",
                success: function (response) {
                    $.each(response, function (indexInArray, valueOfElement) {
                        $('#div'+valueOfElement).addClass('d-none');
                        $('#checkbox_'+valueOfElement).prop('disabled', true);
                    });
                }
            });
            $('#mdl-tajaan').modal('show');
        });

        $('#btnSimpanTajaan').click(function (e) {
            e.preventDefault();
            var id = $('#tajaanUserId').val();
            var checkedValues = $(".chkboxTahun:checked").map(function() {
                return $(this).val();
            }).get().join(",");
            $.ajax({
                type: "post",
                url: "{{route('ketetapan.ajaxSimpanTajaan')}}",
                data: {
                    _token: '{{ csrf_token() }}',
                    id:id,
                    tahun:checkedValues
                },
                dataType: "json",
                success: function (response) {
                    tblTajaan.ajax.reload();
                    $('#mdl-tajaan').modal('hide');
                }
            });
        });
    </script>
@endsection
