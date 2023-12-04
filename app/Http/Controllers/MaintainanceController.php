<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bayaran;
class MaintainanceController extends Controller
{
    function index() {
        $bayaran = Bayaran::where('nobil','like','BIL20230001')->where('id','>',10714)->get();
        foreach ($bayaran as $key => $bayar) {
            $bayar->nobil = 'BIL2023100'.($key+1);
            $bayar->save();
        }

        echo "done";
    }
}
