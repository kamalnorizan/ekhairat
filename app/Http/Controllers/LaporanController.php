<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bayaran;
use App\Models\Alamat;
use App\Models\BayaranDetail;
use Carbon\Carbon;
use DataTables;
class LaporanController extends Controller
{
    function index() {
        $alamat=Alamat::pluck('keterangan','id');
        $alamat->prepend('Pilih Alamat','');
        return view('laporan.index',compact('alamat'));
    }

    function ajaxLoadLaporan(Request $request){

        $tarikh = explode(' - ',$request->tarikh);
        $tarikhMula = Carbon::parse($tarikh[0])->format('Y-m-d');
        $tarikhAkhir = Carbon::parse($tarikh[1])->format('Y-m-d');
        $bayaran = Bayaran::select('*')
                ->with('bayaranDetails','keahlian')
                ->whereBetween('created_at',[$tarikhMula,$tarikhAkhir]);
        if($request->has('jenis') && $request->jenis != ''){
            $bayaran->where('jenisPermohonan',$request->jenis);
        }
        if($request->has('statusPembayaran') && $request->statusPembayaran != ''){
            $status = explode(',',$request->statusPembayaran);
            $bayaran->whereIn('statusbayaran',$status);
        }

        if($request->has('taman') && $request->taman != ''){
            $alamat = $request->taman;
            $bayaran->whereHas('keahlian',function($q) use ($alamat){
                $q->where('ltalamat_id',$alamat);
            });
        }

        $rekodPembaharuan = clone $bayaran;
        $rekodDaftar = clone $bayaran;
        $rekodPembaharuan = $rekodPembaharuan->where('jenisPermohonan','1')->count();
        $rekodDaftar = $rekodDaftar->where('jenisPermohonan','2')->count();

        return DataTables::eloquent($bayaran)
        ->addColumn('nama', function($bayar){
            return $bayar->keahlian->nama;
        })
        ->addColumn('nokp', function($bayar){
            return $bayar->keahlian->nokp;
        })
        ->addColumn('jenis', function($bayar){
            return $bayar->jenisPermohonan == '1' ? 'Pembaharuan' : 'Daftar Baru';
        })
        ->addColumn('tarikh', function($bayar){
            return Carbon::parse($bayar->created_at)->format('d-m-Y');
        })
        ->addColumn('sesi', function($bayar){
            $sesi = '';
            foreach ($bayar->bayaranDetails->where('jenis','yuran') as $key => $value) {
                $sesi.='<span class="badge badge-success">'.$value->tahun.'</span> ';
            }
            return $sesi;
        })
        ->addColumn('cara', function($bayar){
            return $bayar->carabayaran;
        })
        ->addColumn('status', function($bayar){
            $status = '';
            switch ($bayar->statusbayaran) {
                case '0':
                    $status = 'Belum Dibayar';
                    break;
                case '1':
                    $status = 'Telah Dibayar';
                    break;
                case '2':
                    $status = 'Menunggu Pengesahan';
                    break;
                case '3':
                    $status = 'Batal Pembayaran FPX';
                    break;
                case '4':
                    $status = 'Menunggu Pembayaran FPX';
                    break;
            }
            return $status;
        })
        ->rawColumns(['sesi','status'])
        ->with([
            'rekodPembaharuan' => $rekodPembaharuan,
            'rekodDaftar' => $rekodDaftar
        ])
        ->make(true);
    }
}
