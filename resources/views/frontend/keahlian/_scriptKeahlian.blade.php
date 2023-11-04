
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

    loadTanggungan();
    checkTanggungan();
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

    function loadTanggungan() {
        $.ajax({
            type: "post",
            url: "{{ route('tanggungan.loadTanggunganAjax') }}",
            data: {
                _token: '{{ csrf_token() }}',
                id: {{ $keahlian->id }},
            },
            dataType: "json",
            success: function(response) {
                $.each(response.tanggungan, function(indexInArray, tanggungan) {
                    if (tanggungan.nokp != null && tanggungan.nokp.length > 8) {
                        var dob = tanggungan.nokp.substring(0, 6);
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

                    } else {
                        var age = tanggungan.umur;
                    }

                    $('#tanggunganDiv').append(
                        '<div class="row">' +
                        '<input type="hidden" name="idTanggungan[]" id="idTanggungan[]" class="form-control" value="'+tanggungan.id+'">' +
                        '<div class="col-md-4 form-group">' +
                        '<label for="namaTanggungan[]" class="required-label namatanggung">Nama Tanggungan</label>' +
                        '<input class="form-control" required="required" placeholder="NAMA PENUH" name="namaTanggungan[]" type="text" value="'+tanggungan.nama+'" id="namaTanggungan[]">' +
                        '<small class="text-danger"></small>' +
                        '</div>' +
                        '<div class="col-md-4 form-group">' +
                        '<label for="noKpTanggungan[]" class="required-label">No K/P, Mykid, Surat Beranak</label>' +
                        '<input class="form-control nokp" required="required" placeholder="cth: 840909-10-4543" name="noKpTanggungan[]" type="text" value="'+tanggungan.nokp+'" id="noKpTanggungan[]">' +
                        '<small class="text-danger"></small>' +
                        '</div>' +
                        '<div class="col-md-3 form-group">' +
                        '<label for="umurTanggungan[]" class="required-label">Umur</label>' +
                        '<input class="form-control umurTanggungan umur" required="required" placeholder="Umur" name="umurTanggungan[]" type="number" value="'+age+'" id="umurTanggungan[]">' +
                        '<small class="text-danger"></small>' +
                        '</div>' +
                        '<div class="col-md-1 form-group">' +
                        '<label style="color:white">a</label>' +
                        '<button type="button" class="btn btn-danger btn-removeTanggungan" data-id="'+tanggungan.id+'"><i class="fa fa-trash" aria-hidden="true" ></i></button>' +
                        '</div>' +
                        '</div>'
                    );
                });
                checkTanggungan();
            }
        });
    }

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
            '<div class="col-md-4 form-group">' +
            '<label for="namaTanggungan[]" class="required-label namatanggung">Nama Tanggungan</label>' +
            '<input class="form-control" required="required" placeholder="NAMA PENUH" name="namaTanggungan[]" type="text" value="" id="namaTanggungan[]">' +
            '<small class="text-danger"></small>' +
            '</div>' +
            '<div class="col-md-4 form-group">' +
            '<label for="noKpTanggungan[]" class="required-label">No K/P, Mykid, Surat Beranak</label>' +
            '<input class="form-control nokp" required="required" placeholder="cth: 840909-10-4543" name="noKpTanggungan[]" type="text" value="" id="noKpTanggungan[]">' +
            '<small class="text-danger"></small>' +
            '</div>' +
            '<div class="col-md-3 form-group">' +
            '<label for="umurTanggungan[]" class="required-label">Umur</label>' +
            '<input class="form-control umurTanggungan umur" required="required" placeholder="Umur" name="umurTanggungan[]" type="number" value="" id="umurTanggungan[]">' +
            '<small class="text-danger"></small>' +
            '</div>' +
            '<div class="col-md-1 form-group">' +
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
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            nokppasangan: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            tlahirpasangan: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            umurpasangan: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            pekerjaanpasangan: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            },
            notelpasangan_hp: {
                required: {
                    depends: function(element) {
                        return $("input[name='status']:checked").val() === "1";
                    }
                }
            }
        },
        invalidHandler: function(form, validator) {
            if (validator.errorList.length) {
                var firstErrorElement = validator.errorList[0].element;
                $('html, body').animate({
                    scrollTop: $(firstErrorElement).offset().top - 200
                }, 500);
            }
        }
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
