@extends('layouts.app')

@section('head')
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="#">Senarai Permohonan</a></li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-default">
            <div class="card-header">
                Senarai Permohonan
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

                        @forelse($bayaran as $bayar)
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
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" align="center">
                                <span class="text-muted">Tiada permohonan baharu setakat ini</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    @if ($bayaran->count()>0)
        $('#mytable').DataTable({
            "order": [[ 0, "asc" ]]
        });
    @endif
</script>
@endsection

