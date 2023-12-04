<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bayaran;
use App\Models\Keahlian;
use DataTables;
use Crypt;
use Auth;
use \Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
class PermohonanController extends Controller
{
    function index() {
        $bayaran = Bayaran::with('keahlian')->where('jenisPermohonan', '2')->where('statusBayaran',2)->get();
        $keahlian = Keahlian::where('statusahli', '0')->get();
        return view('permohonan.index',compact('keahlian','bayaran'));
    }

    function ajaxloadpermohonan(Request $request) {
        $data = Bayaran::with('keahlian')->where('jenisPermohonan', '2')->where('statusBayaran',2)->get();
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
                if (Gate::allows('access-systemadmin') || Auth::user()->id == 1091) {
                    $btn .= '<button type="button" data-id="'.$row->id.'" class="btn btn-sm btn-danger btn-del">Padam</button>';
                }
                return $btn;
            })
            ->rawColumns(['tindakan'])
            ->make(true);
    }

    function checkPermohonan() {
        $bayaranCount = Bayaran::where('jenisPermohonan', '1')->where('statusBayaran',2)->count();
        $keahlianCount = Bayaran::where('jenisPermohonan', '2')->where('statusBayaran',2)->count();
        $data['bayaran']=$bayaranCount;
        $data['permohonan']=$keahlianCount;
        return response()->json($data, 200);
    }
}
