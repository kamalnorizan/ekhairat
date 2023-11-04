<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keahlian;
use App\Models\Tanggungan;

class TanggunganController extends Controller
{
    function loadTanggunganAjax(Request $request) {
        $ahli = Keahlian::with('tangungan')->find($request->id);

        $tanggungan = $ahli->tangungan;

        $data['tanggungan'] = $tanggungan;
        return response()->json($data, 200);
    }

    function deleteTanggunganAjax(Request $request) {
        $tanggungan = Tanggungan::find($request->id)->delete();
        return response()->json(['status'=>'success'], 200);
    }
}
