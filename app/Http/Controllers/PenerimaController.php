<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penerima;
use App\Models\Keahlian;
use App\Models\Tanggungan;
use Auth;
use \Carbon\Carbon;
class PenerimaController extends Controller
{
    function index() {
        $senaraiPenerima = Penerima::all();
        // dd($senaraiPenerima->last());
        return view('penerima.index', compact('senaraiPenerima'));
    }

    function semak(Request $request) {
        $request->validate([
            'nokp'=>'required'
        ]);

        $keahlian = Keahlian::where('nokp',$request->nokp)->first();

        if($keahlian){
            $data['status']='success';
            $data['type']='ketua';
            $data['keahlian']=$keahlian;

        }else{
            $keahlian = Keahlian::where('nokppasangan',$request->nokp)->first();
            if($keahlian){
                $data['status']='success';
                $data['type']='pasangan';
                $data['keahlian']=$keahlian;
            }else{
                $tanggungan = Tanggungan::with('ketua')->where('nokp',$request->nokp)->first();
                if($tanggungan){
                    $data['status']='success';
                    $data['type']='tanggungan';
                    $data['keahlian']=$tanggungan->ketua;
                    $data['tanggungan']=$tanggungan;
                    $keahlian = $tanggungan->ketua;
                }else{
                    $data['status']='fail';
                }
            }
        }
        $status_aktif = 'false';
        $bayaranDetails = null;
        if($data['status']=='success'){
            $bayaranDetails = $keahlian->bayaranDetailsPaid->where('jenis','yuran')->where('tahun',Carbon::parse($request->tarikhMeninggal)->format('Y'))->first();
        }
        if($bayaranDetails){
            $status_aktif = 'true';
        }
        $data['status_aktif'] = $status_aktif;
        return response()->json($data, 200);
    }


    function store(Request $request) {
        if($request->nokpketua!=''){
            $penerima = new Penerima;
            $penerima->nama = $request->nama;
            $penerima->nokpketua = $request->nokpketua;
            $penerima->nokpmeninggal = $request->nokp;
            $penerima->kodpengguna = $request->kodpengguna;
            $penerima->tarikhmeninggal = Carbon::parse($request->tarikhmeninggal)->format('l d M Y');
            $penerima->kemaskini_oleh = Auth::user()->id;
            $penerima->hubungan = $request->hubungan;
            $penerima->manfaat = $request->manfaat;
            $penerima->tabung = $request->tabung;
            $penerima->kubur = $request->kubur;
            $penerima->ulasan = $request->ulasan;
            $penerima->status = '1';
        }else{
            $penerima = new Penerima;
            $penerima->nama = $request->nama;
            $penerima->nokpmeninggal = $request->nokp;
            $penerima->kodpengguna = $request->kodpengguna;$penerima->tarikhmeninggal = Carbon::parse($request->tarikhmeninggal)->format('l d M Y');
            $penerima->kemaskini_oleh = Auth::user()->id;
            $penerima->manfaat = $request->manfaat;
            $penerima->tabung = $request->tabung;
            $penerima->kubur = $request->kubur;
            $penerima->ulasan = $request->ulasan;
            $penerima->status = '0';
        }
        $penerima->save();

        flash('Maklumat telah berjaya direkodkan')->success()->important();

        return redirect()->back();
    }
}
