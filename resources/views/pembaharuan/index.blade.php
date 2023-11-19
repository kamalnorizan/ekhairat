@extends('layouts.app')

@section('head')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Senarai Pembaharuan</a></li>
@endsection

@section('actions')
<div class="float-right">
    @if (Auth::user()->kodstatuspengguna == '02')
        <button class="btn btn-primary">Rekod Pembayaran Cash</button>
    @endif
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Senarai Pembaharuan
            </div>
            <div class="card-body">
                <table class="table table-hover" id="mytable">
                    <thead>
                        <tr>
                            <th>
                                Nama
                            </th>
                            <th>
                                No K/P
                            </th>
                            <th>
                                Umur
                            </th>
                            <th>
                                Tarikh lahir
                            </th>
                            <th>
                                Alamat
                            </th>
                            <th>
                                Tindakan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse ($bayaran as $bayar)
                        <tr>
                            <td>
                                {{ $bayar->keahlian->nama }}
                            </td>
                            <td>
                                {{ $bayar->keahlian->nokp }}
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($bayar->keahlian->tlahir)->age}} tahun
                            </td>
                            <td>
                                {{\Carbon\Carbon::parse($bayar->keahlian->tlahir)->format('d-m-Y')}}
                            </td>
                            <td>
                                {{ $bayar->keahlian->alamat }}
                            </td>
                            <td>

                                <a href="{{ route('profil.index', Crypt::encrypt($bayar->keahlian->id)) }}" class="btn btn-sm btn-primary">Perincian</a>
                                @can('access-systemadmin')
                                <button type="button" data-id="{{$bayar->id}}" class="btn btn-sm btn-danger btn-del">Padam</button>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" align="center">
                                <span class="text-muted">Tiada permohonan baharu setakat ini</span>
                            </td>
                        </tr>
                        @endforelse --}}
                    </tbody>
                </table>
                {{-- {{Auth::user()->kodstatuspengguna}} --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    var table = $('#mytable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "method": 'POST', // Type of response and matches what we said in the route
                "url": "{{ route('pembaharuan.ajaxloadpembaharuan') }}",
                "dataType": "json",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columns": [{
                    "data": "nama"
                },
                {
                    "data": "nokp"
                },
                {
                    "data": "umur"
                },
                {
                    "data": "tarikhlahir"
                },
                {
                    "data": "alamat"
                },
                {
                    "data": "tindakan"
                }
            ]
        });

    $(document).on("click", ".btn-del", function(e) {
        e.preventDefault();
        var id = $(this).data('id');
       swal({
           title: "Adakah anda pasti?",
           text: "Tindakan anda akan memadam rekod pembayaran/permohonan dari pengguna!",
           icon: "warning",
           buttons: {cancel: {
               text: "Batal",
               value: null,
               visible: true,
               className: "",
               closeModal: true,
           },
           confirm: {
               text: "Ya, saya pasti.",
               value: true,
               visible: true,
               className: "btn-danger",
               closeModal: true
           }}
       }).then((value)=>{
           if(value==true){
               $.ajax({
                   type: "post",
                   url: "{{route('pembaharuan.delete')}}",
                   data: {
                       _token: '{{csrf_token()}}',
                       id: id
                   },
                   dataType: "json",
                   success: function (response) {
                       swal("Berjaya!", "Rekod pembayaran/permohonan telah berjaya dipadam.", "success").then(()=>{
                            window.location.reload();
                       });
                   }
               });
           }
       });
    });
</script>
@endsection

