<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Config;
use App\Models\User;
use App\Models\StatusPengguna;
use App\Models\TahunTajaan;
use App\Models\Keahlian;
use App\Models\Bayaran;
use App\Models\BayaranDetail;
use DataTables;
use Carbon\Carbon;
use Crypt;
use Auth;
class KetetapanController extends Controller
{
    function index() {
        $config = Config::all();
        $jenisPengguna = StatusPengguna::pluck('ketpengguna','kodstatuspengguna');
        $jenisPenggunaTajaan = StatusPengguna::where('kodstatuspengguna','!=','21')->pluck('ketpengguna','kodstatuspengguna');
        $tahunTajaan = TahunTajaan::pluck('tahun','tahun');
        $tahunTajaan->prepend('Semua','');
        $jenisPenggunaTajaan->prepend('Semua','');
        return view('ketetapan.index',compact('config','jenisPengguna','tahunTajaan','jenisPenggunaTajaan'));
    }

    function updateStatusPembaharuan(Request $request) {
        $config = Config::where('type','pendaftaran')->first()->update(['value'=>$request->status]);
        $data = [
            'status' => 'success'
        ];
        return response()->json($data);
    }

    function ajaxLoadPengguna(Request $request) {
        $users = User::with('statusPg','keahlian')->select('id','name','email','nokp','kodstatuspengguna','kodpengguna');

        if ($request->has('jenisPengguna')) {
            $users->whereIn('kodstatuspengguna', $request->jenisPengguna);
        }

        return Datatables::of($users)
        ->addColumn('nama', function (User $user) {
            return $user->name;
        })
        ->addColumn('notel', function (User $user) {
            return $user->keahlian ? $user->keahlian->notel_hp : '-';
        })
        ->addColumn('email', function (User $user) {
            return $user->email;
        })
        ->addColumn('jenisPengguna', function (User $user) {
            $statusPengguna =  $user->statusPg;
            $badgeUser = '<span class="badge badge-success">'.strtoupper($statusPengguna->ketpengguna).'</span>';
            return $badgeUser;
        })
        ->addColumn('tindakan', function (User $user) {
            $buttons = '<div class="btn-group">';
            $buttons .= '<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Tindakan</button>';
            $buttons .= '<div class="dropdown-menu">';
            $buttons .= '<a class="dropdown-item lantikBtn" data-id="'.$user->id.'">Lantikan</a>';
            $buttons .= '<a class="dropdown-item tajaBtn" data-id="'.$user->keahlian->id.'">Tajaan</a>';
            $buttons .= '<a class="dropdown-item updateBtn" href="'.route('profil.index',['u'=>Crypt::encrypt($user->id)]).'" data-id="'.$user->id.'">Kemaskini</a>';
            $buttons .= '<a class="dropdown-item resetPwdBtn" data-id="'.$user->id.'">Reset Kata Laluan</a>';
            $buttons .= '<a class="dropdown-item text-danger hapusBtn" data-id="'.$user->id.'">Hapus</a>';
            $buttons .= '</div>';
            $buttons .= '</div>';
            return $buttons;
        })
        ->rawColumns(['tindakan','jenisPengguna'])
        ->make(true);
    }

    function ajaxLoadTajaan(Request $request) {
        $senaraiBayaran = Bayaran::where('carabayaran','TAJAAN');

        if($request->kategoriPengguna!='') {
            $senaraiBayaran = $senaraiBayaran->whereHas('keahlian',function($q) use ($request){
                $q->where('kodStatusPengguna',$request->kategoriPengguna);
            });
        }else{
            $senaraiBayaran = $senaraiBayaran->whereHas('keahlian',function($q) use ($request){
                $q->where('kodStatusPengguna','!=','21');
            });
        }

        if($request->tahun!='') {
            $senaraiBayaran = $senaraiBayaran->whereHas('bayaranDetails',function($q) use ($request){
                $q->where('tahun',$request->tahun);
            });
        }


        return Datatables::of($senaraiBayaran)
        ->addColumn('nama', function (Bayaran $bayaran) {
            return $bayaran->keahlian->nama;
        })
        ->addColumn('nokp', function (Bayaran $bayaran) {
            return $bayaran->keahlian->nokp;
        })
        ->addColumn('alamat', function (Bayaran $bayaran) {
            return $bayaran->keahlian->alamat;
        })
        ->addColumn('kategori', function (Bayaran $bayaran) {
            $statusPengguna =  $bayaran->keahlian->statusPengguna;
            $badgeUser = '<span class="badge badge-success">'.strtoupper($statusPengguna->ketpengguna).'</span>';
            return $badgeUser;
        })
        ->addColumn('tahun', function (Bayaran $bayaran) {
            return $bayaran->bayaranDetails->first()->tahun;
        })
        ->addColumn('tindakan', function (Bayaran $bayaran) {
            $statusPengguna =  $bayaran->kategoriPengguna;
            $badgeUser = '<span class="badge badge-success">'.strtoupper($statusPengguna->ketpengguna).'</span>';
            return '';
        })
        ->rawColumns(['tindakan','kategori'])
        ->make(true);
    }

    function ajaxLoadRekodTajaan(Request $request) {
        $keahlian = Keahlian::find($request->id);
        $senaraiBayaran = $keahlian->bayaranDetailsPaid;
        $data = [];
        foreach ($senaraiBayaran as $key => $bayar) {
            array_push($data,$bayar->tahun);
        }
        return response()->json($data, 200);
    }

    function ajaxSimpanTajaan(Request $request) {
        $tahunTajaan = explode(',',$request->tahun);
        $keahlian = Keahlian::find($request->id);
        $nobil = substr(Bayaran::where('nobil','like','BIL'.date('Y').'%')->orderBy('nobil','desc')->first()->nobil,-4);
        foreach ($tahunTajaan as $key => $tahun) {
            $nobil++;
            $bayaran = new Bayaran;
            $bayaran->kodpengguna = $keahlian->kodpengguna;
            $bayaran->nokp = $keahlian->nokp;
            $bayaran->nobil = 'BIL'.date('Y').$nobil;
            $bayaran->jenisPermohonan = '1';
            $bayaran->statusbayaran = '1';
            $bayaran->kelulusanbayaran_oleh = Auth::user()->id;
            $bayaran->kelulusanbayaran_pada = Carbon::now()->format('Y-m-d H:i:s');
            $bayaran->jumlahbayaran = '0';
            $bayaran->carabayaran = 'TAJAAN';
            $bayaran->kategoriTajaan = $keahlian->kodstatuspengguna;
            $bayaran->save();

            $bayaranDetail = new BayaranDetail;
            $bayaranDetail->bayaran_id = $bayaran->id;
            $bayaranDetail->noBil = $bayaran->nobil;
            $bayaranDetail->tahun = $tahun;
            $bayaranDetail->amaun = '0';
            $bayaranDetail->jenis = 'yuran';
            $bayaranDetail->save();
        }

        return response()->json(['status'=>'success'], 200);
    }
}
