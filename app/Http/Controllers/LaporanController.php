<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bayaran;
use App\Models\Alamat;
use App\Models\BayaranDetail;
class LaporanController extends Controller
{
    function index() {
        $alamat=Alamat::pluck('keterangan','id');
        $alamat->prepend('Pilih Alamat','');
        return view('laporan.index',compact('alamat'));
    }

    function ajaxLoadLaporan(Request $request){

    }
}
