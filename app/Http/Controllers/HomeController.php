<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\StatusPengguna;
use App\Models\Keahlian;
use App\Models\TanggunganBC;
use App\Models\Tanggungan;
use App\Models\Alamat;
use App\Models\Bayaran;
use App\Models\Penerima;
use App\Models\BayaranDetail;
use Hash;
use Str;
use Auth;
use Carbon\Carbon;
use League\Csv\Reader;
use League\Csv\Statement;
use League\Csv\Writer;
use Illuminate\Support\Facades\Artisan;
class HomeController extends Controller
{

    public function index()
    {
        $ahli = StatusPengguna::where('kodstatuspengguna','21')->withCount('ahli')->first();
        $ajk = StatusPengguna::whereNotIn('kodstatuspengguna',['21','20'])->withCount('ahli')->get();
        $asnaf = StatusPengguna::where('kodstatuspengguna','20')->withCount('ahli')->first();
        $keseluruhan = StatusPengguna::withCount('ahli')->get();

        $totalActive = BayaranDetail::selectRaw('tahun, count(*) as jumlah')->where('jenis','yuran')->whereHas('bayaran',function($q){
            $q->where('statusbayaran','1');
        })->where('tahun','>=',date('Y'))->groupBy('tahun')->get();

        $ahlibaru = Bayaran::where('jenisPermohonan',2)->whereYear('kelulusanbayaran_pada','2023')->whereMonth('kelulusanbayaran_pada','>=',8)->count(); ;

        $countKeseluruhan = 0;
        foreach ($keseluruhan as $key => $seluruh) {
            $countKeseluruhan = $countKeseluruhan+$seluruh->ahli_count;
        }
        $countJawatan = 0;
        foreach ($ajk as $key => $jawatan) {
            $countJawatan = $countJawatan+$jawatan->ahli_count;
        }

        $alamat = Alamat::with('ahli')->withCount('ahli')->get();
        // dd($alamat);
        return view('dashboard.index',compact('ahli','ajk','asnaf','keseluruhan','countKeseluruhan','countJawatan','alamat','totalActive','ahlibaru'));
    }

    function checkuser() {
        $file = public_path('ic anak.csv');
        $data = array_map('str_getcsv', file($file));
        foreach ($data as $key => $value) {
            $keahlian = Keahlian::where('nokp', $value[2])->first();
            if(strlen($value[4])>=12){
                $nokp = substr($value[4],0,6);
                $birthdateYear = (int)substr($value[4],0,2) < 23 ? '20'.substr($value[4],0,2) : '19'.substr($value[4],0,2);
                $birthdateMonth = substr($value[4],2,2);
                $birthdateDay = substr($value[4],4,2);

                try {
                    $birthdate = $birthdateYear.'-'.$birthdateMonth.'-'.$birthdateDay;
                    $umur = Carbon::parse($birthdate)->age;
                } catch (\Throwable $th) {
                    $birthdate='';
                    $umur='';
                }

            }else{
                $birthdate='';
                $umur='';
            }
            if ($keahlian) {
                # code...

                Tanggungan::create(
                    [
                        'kodpengguna'=>$value[1],
                        'nama'=>$value[3],
                        'nokp'=>$value[4],
                        'umur'=>$umur,
                        'tlahir'=>$birthdate,
                        'nokpketua'=>$value[2]
                    ]
                );
            }else{
                TanggunganBC::create(
                    [
                        'kodpengguna'=>$value[1],
                        'nama'=>$value[3],
                        'nokp'=>$value[4],
                        'umur'=>$umur,
                        'tlahir'=>$birthdate,
                        'nokpketua'=>$value[2]
                    ]
                );
            }
        }
    }

    function updatePinAjax(Request $request) {
        $user = Auth::user();
        $user->pinSidebar = $request->pin;
        $user->save();
    }

    function generateBayaran(){
        // u642695168_khairat_table_tblbayaran.csv
        $filePath = public_path('u642695168_khairat_table_tblbayaran.csv');
        if (!file_exists($filePath)) {
            return response()->json(['error' => 'CSV file not found.'], 404);
        }

        // Read the CSV file
        $csvData = array_map('str_getcsv', file($filePath));


        $csvDataWithKeys = [];
        $headerRow = array_shift($csvData);

        // Use the first column as the array key/index
        foreach ($csvData as $row) {
            $csvDataWithKeys[] = array_combine($headerRow, $row);
        }

        $ic = '';
        $skipKey=0;
        foreach($csvDataWithKeys as $key=>$data){
            if($key!=$skipKey){
                try{
                    if($data['jumlahbayaran']!='*' && $data['jumlahbayaran']!='0'){
                        if($data['jumlahbayaran'] - $data['derma'] > $data['bayaran']){
                            $rekodBayaran = Bayaran::where('nobil','like','BIL'.($data['tahun']).'%')->orderBy('nobil','desc')->first();
                            if($rekodBayaran){
                                $bilNo = substr($rekodBayaran->nobil,7,4)+1;
                                $bil = 'BIL'.$data['tahun'].str_repeat('0',4-strlen($bilNo)).$bilNo;

                            }else{
                                $bil = 'BIL'.$data['tahun'].'0001';
                            }
                            $bayaran = new Bayaran;
                            $bayaran->id = $data['idbayaran'];
                            $bayaran->kodpengguna = $data['kodpengguna'];
                            $bayaran->nokp = $data['nokp'];
                            $bayaran->jenisPermohonan = 1;
                            $bayaran->statusbayaran = $data['statusbayaran'];
                            $bayaran->noBil =$bil;
                            $kelulusan = null;
                            if($data['kelulusanbayaran_oleh']!=""){
                                if($data['kelulusanbayaran_oleh']=='BKK01105'){
                                    $kelulusan = '1106';
                                }else if($data['kelulusanbayaran_oleh']=='BKK01098'){
                                    $kelulusan = '1099';
                                }else if($data['kelulusanbayaran_oleh']=='BKK01092'){
                                    $kelulusan = '1093';
                                }else{
                                    $kelulusan = null;
                                }
                            }
                            $bayaran->kelulusanbayaran_oleh  = $kelulusan;
                            $bayaran->jumlahbayaran  = $data['jumlahbayaran'];
                            if($data['masakemaskini']!=""){
                                $bayaran->kelulusanbayaran_pada  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                $bayaran->created_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                $bayaran->updated_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');

                            }

                            if($data['buktibayaran']!=""){
                                $bayaran->buktibayaran  = $data['buktibayaran'];
                            }

                            if($data['noresit']!=""){
                                $bayaran->noresit  = $data['noresit'];
                            }


                            if($data['carabayaran']!=""){
                                $bayaran->carabayaran  = $data['carabayaran'];
                            }

                            $bayaran->save();;

                            $bayaranDetail = new BayaranDetail;
                            $bayaranDetail->bayaran_id=$bayaran->id;
                            $bayaranDetail->noBil = $bayaran->noBil;
                            $bayaranDetail->amaun = '50.00';
                            $bayaranDetail->jenis = 'yuran';
                            $bayaranDetail->tahun = $data['tahun'];
                            if($data['masakemaskini']!=""){
                                $bayaranDetail->created_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                $bayaranDetail->updated_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                            }
                            $bayaranDetail->save();

                            $bayaranDetail = new BayaranDetail;
                            $bayaranDetail->bayaran_id=$bayaran->id;
                            $bayaranDetail->noBil = $bayaran->noBil;
                            $bayaranDetail->amaun = '50.00';
                            $bayaranDetail->jenis = 'yuran';
                            $bayaranDetail->tahun = $csvDataWithKeys[$key+1]['tahun'];
                            if($data['masakemaskini']!=""){
                                $bayaranDetail->created_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                $bayaranDetail->updated_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                            }
                            $bayaranDetail->save();

                            $skipKey = $key+1;

                            if($data['derma']>0){
                                $bayaranDetail = new BayaranDetail;
                                $bayaranDetail->bayaran_id=$bayaran->id;
                                $bayaranDetail->noBil = $bayaran->noBil;
                                $bayaranDetail->amaun = '50.00';
                                $bayaranDetail->jenis = 'derma';
                                $bayaranDetail->tahun = $data['tahun'];
                                if($data['masakemaskini']!=""){
                                    $bayaranDetail->created_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                    $bayaranDetail->updated_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                }
                                $bayaranDetail->save();
                            }

                        }else{
                            $rekodBayaran = Bayaran::where('nobil','like','BIL'.($data['tahun']).'%')->orderBy('nobil','desc')->first();
                            if($rekodBayaran){
                                $bilNo = substr($rekodBayaran->nobil,7,4)+1;
                                $bil = 'BIL'.$data['tahun'].str_repeat('0',4-strlen($bilNo)).$bilNo;

                            }else{
                                $bil = 'BIL'.$data['tahun'].'0001';
                            }
                            $bayaran = new Bayaran;
                            $bayaran->id = $data['idbayaran'];
                            $bayaran->kodpengguna = $data['kodpengguna'];
                            $bayaran->nokp = $data['nokp'];
                            $bayaran->jenisPermohonan = 1;
                            $bayaran->statusbayaran = $data['statusbayaran'];
                            $bayaran->noBil =$bil;
                            $kelulusan = null;
                            if($data['kelulusanbayaran_oleh']!=""){
                                if($data['kelulusanbayaran_oleh']=='BKK01105'){
                                    $kelulusan = '1106';
                                }else if($data['kelulusanbayaran_oleh']=='BKK01098'){
                                    $kelulusan = '1099';
                                }else if($data['kelulusanbayaran_oleh']=='BKK01092'){
                                    $kelulusan = '1093';
                                }else{
                                    $kelulusan = null;
                                }
                            }
                            $bayaran->kelulusanbayaran_oleh  = $kelulusan;
                            $bayaran->jumlahbayaran  = $data['jumlahbayaran'];
                            if($data['masakemaskini']!=""){
                                $bayaran->kelulusanbayaran_pada  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                $bayaran->created_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                $bayaran->updated_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');

                            }

                            if($data['buktibayaran']!=""){
                                $bayaran->buktibayaran  = $data['buktibayaran'];
                            }

                            if($data['noresit']!=""){
                                $bayaran->noresit  = $data['noresit'];
                            }


                            if($data['carabayaran']!=""){
                                $bayaran->carabayaran  = $data['carabayaran'];
                            }

                            $bayaran->save();;

                            $bayaranDetail = new BayaranDetail;
                            $bayaranDetail->bayaran_id=$bayaran->id;
                            $bayaranDetail->noBil = $bayaran->noBil;
                            $bayaranDetail->amaun = '50.00';
                            $bayaranDetail->jenis = 'yuran';
                            $bayaranDetail->tahun = $data['tahun'];
                            if($data['masakemaskini']!=""){
                                $bayaranDetail->created_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                $bayaranDetail->updated_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                            }
                            $bayaranDetail->save();

                            if($data['derma']>0){
                                $bayaranDetail = new BayaranDetail;
                                $bayaranDetail->bayaran_id=$bayaran->id;
                                $bayaranDetail->noBil = $bayaran->noBil;
                                $bayaranDetail->amaun = '50.00';
                                $bayaranDetail->jenis = 'derma';
                                $bayaranDetail->tahun = $data['tahun'];
                                if($data['masakemaskini']!=""){
                                    $bayaranDetail->created_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                    $bayaranDetail->updated_at  = Carbon::createFromFormat('d/m/Y H:i', $data['masakemaskini'])->format('Y-m-d H:i:s');
                                }
                                $bayaranDetail->save();
                            }
                        }
                    }
                }catch(Throwable $e){
                    dump($e);
                }
            }

        }

        // return response()->json(['data' => $csvDataWithKeys], 200);


    }

    function generateTarikhLahir(){

    }


}
