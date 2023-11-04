<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bayaran;
class PembaharuanController extends Controller
{
    function index() {
        $bayaran = Bayaran::with('keahlian')->where('jenisPermohonan', '1')->where('statusBayaran',2)->get();
        return view('pembaharuan.index',compact('bayaran'));
    }

    function cash($encid) {
        $id = Crypt::decrypt($encid);
        $bayaran = Keahlian::with('bayaran')->find($id);
        return view('pembaharuan.cash');
    }
}
