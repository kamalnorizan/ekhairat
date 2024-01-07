<?php

namespace App\Http\Controllers;

use Auth;
use Crypt;
use DataTables;
use \Carbon\Carbon;
use App\Models\Alamat;
use App\Models\Bayaran;
use App\Models\Keahlian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Tanggungan;
use App\Models\StatusPengguna;
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

    function create(){
        $type = 'n';
        $lt_alamat=Alamat::pluck('keterangan','id');
        $lt_alamat->prepend('Sila Pilih', '');
        $type = 'n';
        $statusKeahlian = StatusPengguna::pluck('ketpengguna','kodstatuspengguna');
        return view('permohonan.create', compact('type','lt_alamat','statusKeahlian'));
    }

    function storeadm(Request $request) {
        $keahlian = new Keahlian;
        $keahlian->nama = $request->nama;
        $keahlian->tlahir = $request->tlahir;
        $keahlian->nokp = $request->nokp;
        $keahlian->notel_r = $request->notel_r;
        $keahlian->notel_hp = $request->notel_hp;
        $keahlian->notel_p = $request->notel_p;
        $keahlian->alamat = $request->alamat;
        $keahlian->kodstatuspengguna = $request->kodstatuspengguna;
        $keahlian->ltalamat_id = $request->ltalamat_id;
        $keahlian->pekerjaan = $request->pekerjaan;
        $keahlian->status = $request->status;
        if($request->status=='1'){
            $keahlian->namapasangan = $request->namapasangan;
            $keahlian->nokppasangan = $request->nokppasangan;
            $keahlian->umurpasangan = $request->umurpasangan;
            $keahlian->tlahirpasangan = $request->tlahirpasangan;
            $keahlian->notelpasangan_hp = $request->notelpasangan_hp;
            $keahlian->pekerjaanpasangan = $request->pekerjaanpasangan;
        }else{
            $keahlian->namapasangan = null;
            $keahlian->nokppasangan = null;
            $keahlian->umurpasangan = null;
            $keahlian->tlahirpasangan = null;
            $keahlian->notelpasangan_hp = null;
            $keahlian->pekerjaanpasangan = null;
        }
        $keahlian->namawaris = $request->namawaris;
        $keahlian->hubunganwaris = $request->hubunganwaris;
        $keahlian->notelwaris_1 = $request->notelwaris_1;
        $keahlian->notelwaris_2 = $request->notelwaris_2;
        $keahlian->save();
        $keahlian->kodpengguna = 'BKK'.str_pad($keahlian->id, 5, '0', STR_PAD_LEFT);
        $keahlian->save();

        $user = new User;
        $user->name = $request->nama;
        $user->nokp = $request->nokp;
        $user->kodpengguna = $keahlian->kodpengguna;
        $user->kodstatuspengguna = $request->kodstatuspengguna;
        $user->kemas='0';
        $user->email=$request->email;
        $user->save();

        if($request->has('namaTanggungan')){

            foreach ($request->namaTanggungan as $key => $namaTanggungan) {
                $tanggungan = new Tanggungan();
                $tanggungan->kodpengguna = $keahlian->kodpengguna;
                $tanggungan->nama = $request->namaTanggungan[$key];
                $tanggungan->nokp = $request->noKpTanggungan[$key];
                $tanggungan->umur = $request->umurTanggungan[$key];
                $tarikhLahir = explode('-',$request->noKpTanggungan[$key]);
                $year = substr($tarikhLahir[0],0,2);
                $month = substr($tarikhLahir[0],2,2);
                $day = substr($tarikhLahir[0],4,2);
                if($year>20){
                    $year = '19'.$year;
                }
                $tarikh = $year.'-'.$month.'-'.$day;
                $tanggungan->tlahir = Carbon::parse($tarikh)->format('Y-m-d');
                $tanggungan->nokpketua = $keahlian->nokp;
                $tanggungan->save();
            }
        }


        return redirect()->route('profil.pembaharuan', ['encid' => Crypt::encrypt($keahlian->id),'type'=>'n']);
    }
}
