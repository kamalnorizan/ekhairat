@extends('layouts.app')

@section('head')
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Daftar Ahli Baru</a></li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header bg-primary text-white">
                    Borang Pendaftaran Ahli Baru
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 d-sm-none mt-3"></div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="fancy-title title-bottom-border">

                                        <h4>Borang Pendaftaran</h4>

                                    </div>

                                    {!! Form::open(['method' => 'POST', 'route' => 'permohonan.storeadm', 'class' => '', 'id' => 'formDaftar']) !!}

                                    <input type="hidden" name="type" id="type" class="form-control"
                                        value="{{ $type }}">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="highlight-me">Maklumat Ketua Keluarga</h4>
                                        </div>
                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                            {!! Form::label('nama', 'Nama Penuh', ['class' => 'required-label']) !!}
                                            {!! Form::text('nama', null, [
                                                'class' => 'form-control',
                                                'required' => 'required',
                                                'placeholder' => 'NAMA PENUH',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('nama') }}</small>
                                        </div>
                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
                                            {!! Form::label('kodstatuspengguna', 'Jenis Keahlian') !!}
                                            {!! Form::select('kodstatuspengguna', $statusKeahlian, 21, [
                                                'id' => 'kodstatuspengguna',
                                                'class' => 'form-control',
                                                'required' => 'required',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('kodstatuspengguna') }}</small>
                                        </div>
                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('nokp') ? ' has-error' : '' }}">
                                            {!! Form::label('nokp', 'No Kad Pengenalan', ['class' => 'required-label']) !!}
                                            {!! Form::text('nokp', null, [
                                                'class' => 'form-control nokp',
                                                'required' => 'required',
                                                'placeholder' => 'cth: 840909-10-4543',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('nokp') }}</small>
                                        </div>

                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('tlahir') ? ' has-error' : '' }}">
                                            {!! Form::label('tlahir', 'Tarikh Lahir') !!}
                                            {!! Form::date('tlahir', null, [
                                                'class' => 'form-control',
                                                'placeholder' => 'TARIKH LAHIR',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('tlahir') }}</small>
                                        </div>
                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('umur') ? ' has-error' : '' }}">
                                            {!! Form::label('umur', 'Umur') !!}
                                            {!! Form::text('umur', null, ['class' => 'form-control umur', 'placeholder' => 'UMUR']) !!}
                                            <small class="text-danger">{{ $errors->first('umur') }}</small>
                                        </div>
                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('notel_r') ? ' has-error' : '' }}">
                                            {!! Form::label('notel_r', 'No Phone(R)') !!}
                                            {!! Form::text('notel_r', null, [
                                                'class' => 'form-control',
                                                'placeholder' => '0X-XXXXXXXX',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('notel_r') }}</small>
                                        </div>
                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('notel_hp') ? ' has-error' : '' }}">
                                            {!! Form::label('notel_hp', 'No Phone(HP)', ['class' => 'required-label']) !!}
                                            {!! Form::text('notel_hp', null, [
                                                'class' => 'form-control',
                                                'placeholder' => '0X-XXXXXXXX',
                                                'required' => 'required',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('notel_hp') }}</small>
                                        </div>
                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('notel_p') ? ' has-error' : '' }}">
                                            {!! Form::label('notel_p', 'No Phone(P)', ['class' => '']) !!}
                                            {!! Form::text('notel_p', null, [
                                                'class' => 'form-control',
                                                'placeholder' => '0X-XXXXXXXX',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('notel_p') }}</small>
                                        </div>
                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('pekerjaan') ? ' has-error' : '' }}">
                                            {!! Form::label('pekerjaan', 'Pekerjaan') !!}
                                            {!! Form::text('pekerjaan', null, [
                                                'class' => 'form-control',
                                                'placeholder' => 'PEKERJAAN',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('pekerjaan') }}</small>
                                        </div>
                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            {!! Form::label('email', 'Email') !!}
                                            {!! Form::email('email', null, [
                                                'class' => 'form-control',
                                                'placeholder' => 'cth: example@gmail.com',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('email') }}</small>
                                        </div>
                                        <div
                                            class="col-md-8 form-group-default form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
                                            {!! Form::label('alamat', 'Alamat', ['class' => 'required-label']) !!}
                                            {!! Form::text('alamat', null, [
                                                'class' => 'form-control',
                                                'placeholder' => 'ALAMAT',
                                                'required' => 'required',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                        </div>
                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('ltalamat_id') ? ' has-error' : '' }}">
                                            {!! Form::label('ltalamat_id', 'Kawasan Alamat') !!}
                                            {!! Form::select('ltalamat_id', $lt_alamat, null, [
                                                'id' => 'ltalamat_id',
                                                'class' => 'form-control',
                                                'required' => 'required',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('ltalamat_id') }}</small>
                                        </div>
                                        <div
                                            class="col-md-12 form-group{{ $errors->has('status') ? ' has-error' : '' }} form-group-default ">
                                            {!! Form::label('status', 'Status') !!}
                                            {!! Form::select(
                                                'status',
                                                [
                                                    '1' => 'Berkahwin',
                                                    '2' => 'Janda',
                                                    '3' => 'Duda',
                                                    '4' => 'Bujang',
                                                ],
                                                null,
                                                ['id' => 'status', 'class' => 'form-control statusRadio', 'required' => 'required'],
                                            ) !!}
                                            <small class="text-danger">{{ $errors->first('status') }}</small>
                                        </div>
                                    </div>
                                    <div class="row" id="divPasangan">
                                        <div class="col-md-12">
                                            <hr class="mt-1 mb-1">
                                            <h4 class="highlight-me">Maklumat Pasangan</h4>
                                        </div>
                                        <div
                                            class="col-md-12 form-group-default form-group{{ $errors->has('namapasangan') ? ' has-error' : '' }}">
                                            {!! Form::label('namapasangan', 'Nama Penuh') !!}
                                            {!! Form::text('namapasangan', null, [
                                                'class' => 'form-control',
                                                'placeholder' => 'NAMA PENUH PASANGAN',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('namapasangan') }}</small>
                                        </div>
                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('nokppasangan') ? ' has-error' : '' }}">
                                            {!! Form::label('nokppasangan', 'No Kad Pengenalan') !!}
                                            {!! Form::text('nokppasangan', null, [
                                                'class' => 'form-control nokp',
                                                'required' => 'required',
                                                'placeholder' => 'cth: 840909-10-4543',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('nokppasangan') }}</small>
                                        </div>
                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('tlahirpasangan') ? ' has-error' : '' }}">
                                            {!! Form::label('tlahirpasangan', 'Tarikh Lahir') !!}
                                            {!! Form::date('tlahirpasangan', null, [
                                                'class' => 'form-control',
                                                'placeholder' => 'TARIKH LAHIR PASANGAN',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('tlahirpasangan') }}</small>
                                        </div>
                                        <div
                                            class="col-md-4 form-group-default form-group{{ $errors->has('umurpasangan') ? ' has-error' : '' }}">
                                            {!! Form::label('umurpasangan', 'Umur') !!}
                                            {!! Form::text('umurpasangan', null, [
                                                'class' => 'form-control umur',
                                                'placeholder' => 'UMUR PASANGAN',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('umurpasangan') }}</small>
                                        </div>

                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('pekerjaanpasangan') ? ' has-error' : '' }}">
                                            {!! Form::label('pekerjaanpasangan', 'Pekerjaan') !!}
                                            {!! Form::text('pekerjaanpasangan', null, [
                                                'class' => 'form-control',
                                                'placeholder' => 'PEKERJAAN PASANGAN',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('pekerjaanpasangan') }}</small>
                                        </div>
                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('notelpasangan_hp') ? ' has-error' : '' }}">
                                            {!! Form::label('notelpasangan_hp', 'No Telefon Pasangan') !!}
                                            {!! Form::text('notelpasangan_hp', null, [
                                                'class' => 'form-control',
                                                'placeholder' => '0X-XXXXXXXX',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('notelpasangan_hp') }}</small>
                                        </div>
                                    </div>
                                    <div class="row" id="divAnak">
                                        <div class="col-md-12 mt-3">
                                            <hr>
                                            <h4 class="highlight-me">Maklumat anak-anak yang berumur 1 tahun sehingga 23
                                                tahun yang masih dalam tanggungan
                                            </h4>
                                            <div class="col-md-12" id="tanggunganDiv">
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <button type="button" class="btn btn-primary" id="tambahTanggungan"> <i
                                                        class="fa fa-plus" aria-hidden="true"></i> Tambah
                                                    Tanggungan</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="divWaris">
                                        <div class="col-md-12 mt-3">
                                            <hr>
                                            <h4 class="highlight-me">Waris Terdekat (Jika berlaku kecemasan & rujukan)
                                            </h4>
                                        </div>
                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('namawaris') ? ' has-error' : '' }}">
                                            {!! Form::label('namawaris', 'Nama Penuh', ['class' => 'required-label']) !!}
                                            {!! Form::text('namawaris', null, [
                                                'class' => 'form-control',
                                                'placeholder' => 'NAMA PENUH WARIS',
                                                'required',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('namawaris') }}</small>
                                        </div>
                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('hubungan') ? ' has-error' : '' }}">
                                            {!! Form::label('hubunganwaris', 'Hubungan') !!}
                                            {!! Form::select(
                                                'hubunganwaris',
                                                [
                                                    'Ayah Kandung' => 'AYAH',
                                                    'Ibu Kandung' => 'IBU',
                                                    'Mertua' => 'MERTUA',
                                                    'Anak Kandung' => 'ANAK',
                                                    'Menantu' => 'MENANTU',
                                                    'Anak Tiri' => 'ANAK TIRI',
                                                    'Adik Beradik' => 'ADIK BERADIK',
                                                    'Ipar' => 'IPAR',
                                                    'Saudara' => 'SAUDARA',
                                                ],
                                                null,
                                                ['id' => 'hubunganwaris', 'class' => 'form-control', 'required' => 'required'],
                                            ) !!}
                                            <small class="text-danger">{{ $errors->first('hubunganwaris') }}</small>
                                        </div>
                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('notelwaris_1') ? ' has-error' : '' }}">
                                            {!! Form::label('notelwaris_1', 'No Telefon 1', ['class' => 'required-label']) !!}
                                            {!! Form::text('notelwaris_1', null, [
                                                'class' => 'form-control',
                                                'placeholder' => '01X-XXXXXXX',
                                                'required',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('notelwaris_1') }}</small>
                                        </div>
                                        <div
                                            class="col-md-6 form-group-default form-group{{ $errors->has('notelwaris_2') ? ' has-error' : '' }}">
                                            {!! Form::label('notelwaris_2', 'No Telefon 2') !!}
                                            {!! Form::text('notelwaris_2', null, [
                                                'class' => 'form-control',
                                                'placeholder' => '01X-XXXXXXX',
                                            ]) !!}
                                            <small class="text-danger">{{ $errors->first('notelwaris_2') }}</small>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center><button class="btn btn-primary" type="button" id="btnPembayaran">Daftar
                                                    Keahlian</button></center>
                                        </div>
                                    </div>

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
        $('.statusRadio').change(function(e) {
            e.preventDefault();
            if ($(this).val() == '1') {
                $('#divPasangan').show();
                $('#divAnak').show();
            } else if ($(this).val() == '2' || $(this).val() == '3') {
                $('#divPasangan').hide();
                $('#divAnak').show();
            } else if ($(this).val() == '4') {
                $('#divPasangan').hide();
                $('#divAnak').hide();
            }
        });

        checkAllKpAge();

        function checkAllKpAge() {
            $.each($('.nokp'), function(indexInArray, nokp) {
                if ($(nokp).val() != '') {
                    var dob = $(nokp).val().substring(0, 6);

                    var year = dob.substring(0, 2);
                    var month = dob.substring(2, 4);
                    var day = dob.substring(4, 6);
                    if (year > 40) {
                        year = '19' + year;
                    } else {
                        year = '20' + year;
                    }
                    dob = day + "-" + month + "-" + year;
                    var age = calculateAge(dob);
                    $(nokp).closest('.row').find('.umur').val(age);
                }
            });
        }

        $(document).on("keyup", ".nokp", function(e) {

            var s = $(this).val();
            if (s.length == 6) {
                $(this).val(s + "-");
            }

            if (s.length == 9) {
                $(this).val(s + "-");
            }
        });


        function createDateFromFormat(dateString, format) {
            var dateParts = dateString.split("-");
            var day, month, year;

            if (format === "dd-mm-yyyy") {
                day = parseInt(dateParts[0], 10);
                month = parseInt(dateParts[1], 10) - 1; // Months are zero-based (0-11)
                year = parseInt(dateParts[2], 10);
            }

            return new Date(year, month, day);
        }

        function checkTanggungan() {
            if ($('.namatanggung').length > 0) {
                $('#tanggunganDiv').find('.norecord').remove();
            } else {
                $('#tanggunganDiv').empty();
                $('#tanggunganDiv').append(
                    '<div class="row norecord"><div class="col-md-12 text-center"><h4 class="text-muted">Tiada rekod</h4></div></div>'
                );
            }
        }

        function calculateAge(dateOfBirth) {
            var today = new Date();
            var birthDate = createDateFromFormat(dateOfBirth, "dd-mm-yyyy");
            console.log(birthDate);

            var yearsDiff = today.getFullYear() - birthDate.getFullYear();
            var monthsDiff = today.getMonth() - birthDate.getMonth();
            var daysDiff = today.getDate() - birthDate.getDate();

            // Check if the birth date month and day are ahead of today's month and day
            if (monthsDiff < 0 || (monthsDiff === 0 && daysDiff < 0)) {
                yearsDiff--;
            }

            return yearsDiff;
        }

        $('#tambahTanggungan').click(function(e) {
            e.preventDefault();
            $('#tanggunganDiv').append(
                '<div class="row">' +
                '<input type="hidden" name="idTanggungan[]" id="idTanggungan[]"  class="form-control" value="">' +
                '<div class="col-md-4 form-group-default form-group">' +
                '<label for="namaTanggungan[]" class="required-label namatanggung">Nama Tanggungan</label>' +
                '<input class="form-control" required="required" placeholder="NAMA PENUH" name="namaTanggungan[]" type="text" value="" id="namaTanggungan[]">' +
                '<small class="text-danger"></small>' +
                '</div>' +
                '<div class="col-md-4 form-group-default form-group">' +
                '<label for="noKpTanggungan[]" class="required-label">No K/P, Mykid, Surat Beranak</label>' +
                '<input class="form-control nokp" required="required" placeholder="cth: 840909-10-4543" name="noKpTanggungan[]" type="text" value="" id="noKpTanggungan[]">' +
                '<small class="text-danger"></small>' +
                '</div>' +
                '<div class="col-md-3 form-group-default form-group">' +
                '<label for="umurTanggungan[]" class="required-label">Umur</label>' +
                '<input class="form-control umurTanggungan umur" required="required" placeholder="Umur" name="umurTanggungan[]" type="number" value="" id="umurTanggungan[]">' +
                '<small class="text-danger"></small>' +
                '</div>' +
                '<div class="col-md-1 form-group-default form-group">' +
                '<label style="color:white">a</label>' +
                '<button type="button" class="btn btn-danger btn-removeTanggungan" data-id=""><i class="fa fa-trash" aria-hidden="true" ></i></button>' +
                '</div>' +
                '</div>'
            );
            checkTanggungan();
        });

        $(document).on("click", ".btn-removeTanggungan", function(e) {
            var tanggugnanId = $(this).attr('data-id');
            var element = $(this);

            swal({
                title: "Andakah anda pasti?",
                text: "Tindakan anda akan mengeluarkan tanggungan ini daripada senarai tanggungan anda",
                icon: "warning",
                buttons: {
                    cancel: {
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
                    }
                }
            }).then((value) => {
                // alert(value);
                if (tanggugnanId != '') {

                    if (value == true) {
                        $.ajax({
                            type: "post",
                            url: "{{ route('tanggungan.deleteTanggunganAjax') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: tanggugnanId,
                            },
                            dataType: "json",
                            success: function(response) {
                                swal("Berjaya!",
                                    "Tanggungan telah dikeluarkan dari senarai tanggungan anda.",
                                    "success").then(() => {
                                    $(element).closest('.row').remove();
                                });
                            }
                        });
                    }
                    checkTanggungan();
                } else {
                    $(element).closest('.row').remove();
                    checkTanggungan();
                }
            });
        });

        $('#formDaftar').validate({
            rules: {
                namapasangan: {
                    required: {
                        depends: function(element) {
                            return $(".statusRadio").val() === "1";
                        }
                    }
                },
                nokppasangan: {
                    required: {
                        depends: function(element) {
                            return $(".statusRadio").val() === "1";
                        }
                    }
                },
                tlahirpasangan: {
                    required: {
                        depends: function(element) {
                            return $(".statusRadio").val() === "1";
                        }
                    }
                },
                umurpasangan: {
                    required: {
                        depends: function(element) {
                            return $(".statusRadio").val() === "1";
                        }
                    }
                },
                pekerjaanpasangan: {
                    required: {
                        depends: function(element) {
                            return $(".statusRadio").val() === "1";
                        }
                    }
                },
                notelpasangan_hp: {
                    required: {
                        depends: function(element) {
                            return $(".statusRadio").val() === "1";
                        }
                    }
                }
            },
            invalidHandler: function(form, validator) {
                if (validator.errorList.length) {
                    var firstErrorElement = validator.errorList[0].element;
                    console.log(firstErrorElement);
                    $('html, body').animate({
                        scrollTop: $(firstErrorElement).offset().top - 200
                    }, 500);
                }
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.closest(".form-group-default").find(".text-danger"));
            },
        });

        $(document).on("change", ".nokp ", function(e) {
            var dob = $(this).val().substring(0, 6);

            var year = dob.substring(0, 2);
            var month = dob.substring(2, 4);
            var day = dob.substring(4, 6);
            if (year > 40) {
                year = '19' + year;
            } else {
                year = '20' + year;
            }
            dob = day + "-" + month + "-" + year;
            var age = calculateAge(dob);
            $(this).closest('.row').find('.umur').val(age);
        });

        $('#btnPembayaran').click(function(e) {
            e.preventDefault();
            // var form = $('#formPembayaran');
            var el;
            if ($('#formDaftar').valid()) {
                var err = 0;
                $.each($('.umurTanggungan'), function(indexInArray, valueOfElement) {
                    var umur = $(valueOfElement).val();
                    if (umur > 23) {
                        $(valueOfElement).removeClass('valid');
                        $(valueOfElement).addClass('error');
                        $(valueOfElement).next().text('Umur tanggungan tidak boleh melebihi 23 tahun');
                        err++;
                        el = $(valueOfElement).closest('.form-group-default form-group');
                    } else {
                        $(valueOfElement).closest('.form-group-default form-group').find('.umurTanggungan')
                            .removeClass('error');
                        $(valueOfElement).closest('.form-group-default form-group').find('.umurTanggungan')
                            .next().text('');
                    }

                });
                if (err > 0) {
                    $('html, body').animate({
                        scrollTop: $(el).offset().top - 200
                    }, 500);
                    return false;
                } else {

                    swal({
                        title: "Andakah anda pasti?",
                        text: "Saya dengan ini mengesahkan bahawa maklumat yang diberikan adalah benar dan sah.",
                        icon: "warning",
                        buttons: {
                            cancel: {
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
                            }
                        }
                    }).then((value) => {
                        // alert(value);
                        if (value == true) {
                            $('#formDaftar').submit();

                        }
                    });
                }
            }
        });
    </script>
@endsection
