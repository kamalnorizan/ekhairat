<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bayaran;
use App\Models\Keahlian;
class PermohonanController extends Controller
{
    function index() {
        $bayaran = Bayaran::with('keahlian')->where('jenisPermohonan', '2')->where('statusBayaran',2)->get();
        $keahlian = Keahlian::where('statusahli', '0')->get();
        return view('permohonan.index',compact('keahlian','bayaran'));
    }

    function checkPermohonan() {
        $bayaranCount = Bayaran::where('jenisPermohonan', '1')->where('statusBayaran',2)->count();
        $keahlianCount = Bayaran::where('jenisPermohonan', '2')->where('statusBayaran',2)->count();
        $data['bayaran']=$bayaranCount;
        $data['permohonan']=$keahlianCount;
        return response()->json($data, 200);
    }
}
