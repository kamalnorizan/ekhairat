<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bayaran;
use Carbon\Carbon;
use Crypt;
use DataTables;
use Illuminate\Support\Facades\Gate;
class PembaharuanController extends Controller
{
    function index() {
        $bayaran = Bayaran::with('keahlian')->where('jenisPermohonan', '1')->where('statusBayaran',2)->get();
        return view('pembaharuan.index',compact('bayaran'));
    }

    function ajaxloadpembaharuan(Request $request) {
        $data = Bayaran::with('keahlian')->where('jenisPermohonan', '1')->where('statusBayaran',2)->get();
        return Datatables::of($data)
            ->addColumn('nama', function(Bayaran $row){
                $nama = $row->keahlian->nama;
                return strtoupper($nama);
            })
            ->addColumn('nokp', function(Bayaran $row){
                $nokp = $row->keahlian->nokp;
                return $nokp;
            })
            ->addColumn('umur', function(Bayaran $row){
                $umur = Carbon::parse($row->keahlian->tlahir)->diff(Carbon::now())->y;
                return $umur;
            })
            ->addColumn('tarikhlahir', function(Bayaran $row){
                $tarikhlahir = Carbon::parse($row->keahlian->tlahir)->format('d-m-Y');

                return $tarikhlahir;
            })
            ->addColumn('alamat', function(Bayaran $row){
                $alamat = $row->keahlian->alamat;
                return strtoupper($alamat);
            })
            ->addColumn('tindakan', function(Bayaran $row){
                $btn = '<a href="'.route('profil.index', Crypt::encrypt($row->keahlian->id)).'" class="btn btn-sm btn-primary">Perincian</a>';
                if (Gate::allows('access-systemadmin')) {
                    $btn .= '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-danger btn-del">Padam</button>';
                }
                return $btn;
            })
            ->rawColumns(['tindakan'])
            ->make(true);
    }

    function cash($encid) {
        $id = Crypt::decrypt($encid);
        $bayaran = Keahlian::with('bayaran')->find($id);
        return view('pembaharuan.cash');
    }
}
