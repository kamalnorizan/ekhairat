<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keahlian;
use App\Models\Tahun;
use App\Models\Config;
use App\Models\User;
use App\Models\BayaranDetail;
use App\Models\Bayaran;
use App\Models\Alamat;
use App\Models\Tanggungan;
use App\Models\StatusPengguna;
use App\Models\Smsblast;
use App\Models\SmsblastGroup;
use App\Models\SmsblastDetail;
use Carbon\Carbon;
use Crypt;
use DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

use App\Jobs\SendSMS;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
class KeahlianController extends Controller
{
    function index() {
        // $keahlian = Keahlian::with('bayaran','bayaranDetails')->get();
        $kategoriKeahlian = StatusPengguna::pluck('ketpengguna','kodstatuspengguna');
        $kategoriKeahlian->prepend ('Sila Pilih','');
        $jalan = Alamat::pluck('keterangan','id');
        return view('backend.keahlian.index', compact('kategoriKeahlian','jalan'));
    }


    function ajaxLoadAhli(Request $request){
        $keahlian = Keahlian::with('bayaranDetails','bayaranDetailsPaid')->select('nama','statusahli','nokp','alamat','id');

        if ($request->has('status')) {
            if($request->status == 'Aktif'){
                $keahlian->whereHas('bayaranDetailsPaid',function($q){
                    $q->where('jenis','yuran')->where('tahun',date('Y'));
                });
            }else{
                $keahlian->whereDoesntHave('bayaranDetailsPaid',function($q){
                    $q->where('jenis','yuran')->whereIn('tahun',[date('Y'), date('Y')+1]);
                });
            }
        }

        if ($request->has('keahlian')) {
            if($request->keahlian != null){
                $keahlian->where('kodstatuspengguna',$request->keahlian);
            }
        }

        if ($request->has('alamat')) {
            $keahlian->whereIn('ltalamat_id',$request->alamat);
        }

        return DataTables::of($keahlian)
        ->addColumn('nama', function (Keahlian $keahlian) {
            return strtoupper($keahlian->nama);
        })
        ->addColumn('statusAhli', function (Keahlian $keahlian) {
            return $keahlian->bayaranDetailsPaid->where('jenis','yuran')->where('tahun',date('Y'))->count() == 1 ? '<span class="badge badge-success">AKTIF</span>'
             : '<span class="badge badge-danger">TIDAK AKTIF</span>';
        })
        ->addColumn('nokp', function (Keahlian $keahlian) {
            return $keahlian->nokp;
        })
        ->addColumn('alamat', function (Keahlian $keahlian) {
            return $keahlian->alamat;
        })
        ->addColumn('tarikhaktif', function (Keahlian $keahlian) {
            return $keahlian->bayaranDetailsPaid->where('jenis','yuran')->last()!=null ? '31-12-'.$keahlian->bayaranDetailsPaid->where('jenis','yuran')->last()->tahun : '-';
        })
        ->addColumn('tindakan', function (Keahlian $keahlian) {
            $btn = '<a href="'.route('profil.index',['u'=>Crypt::encrypt($keahlian->id)]).'" class="btn btn-sm btn-primary">Perincian</a>';
            return $btn;
        })
        ->filterColumn('nokp', function ($query, $keyword) {
            // Custom filter logic for the 'created_date' column
            $query->where('nokp', 'LIKE', '%'.$keyword.'%');
        })
        ->filterColumn('nama', function ($query, $keyword) {
            // Custom filter logic for the 'created_date' column
            $query->where('nama', 'LIKE', '%'.$keyword.'%');
        })
        ->filterColumn('alamat', function ($query, $keyword) {
            // Custom filter logic for the 'created_date' column
            $query->where('alamat', 'LIKE', '%'.$keyword.'%');
        })
        ->rawColumns(['statusAhli','tindakan'])
        ->make(true);
    }

    function frontIndex() {
        $lt_alamat=Alamat::pluck('keterangan','id');
        $lt_alamat->prepend('Sila Pilih', '');
        $type = 'n';
        return view('frontend.keahlian.index',compact('lt_alamat','type'));
    }

    function perincian($encid) {
        try {
            $id = Crypt::decrypt($encid);
        } catch (\Throwable $th) {
            abort(404, 'Resource not found');
        }

        $keahlian = Keahlian::with('bayaranDetails')->find($id);
        if(!$keahlian) {
            abort(404, 'Resource not found');
        }
        $tahun = Tahun::all();
        $databayaran = collect();
        foreach($keahlian->bayaran as $bayaran) {
            foreach ($bayaran->bayaranDetails->where('jenis','yuran') as $key => $bayaranDetail) {
               $databayaran[]= [
                   'id' => $bayaranDetail->id,
                   'tahun' => $bayaranDetail->tahun,
                   'status' => $bayaran->statusbayaran,
                   'lampiran' => $bayaran->buktibayaran,
                   'carabayaran' => $bayaran->carabayaran,
                   'jumlah' => $bayaranDetail->amaun,
                   'noresit' => $bayaran->noresit,
                   'noresitnew' => $bayaran->noresitnew,
               ];
            }
        }

        $databayaran=$databayaran->sortBy('tahun');
        $configpendaftaran=Config::where('type','pendaftaran')->first();
        $configtahunsemasa=Config::whereType('tahunsemasa')->first();

        $semakBayaranFpx = $keahlian->bayaran->where('statusbayaran',0)->where('carabayaran','FPX');
        if($semakBayaranFpx->count()>0){
            foreach($semakBayaranFpx as $semakBayaranFpxSingle){
                $some_data = array(
                    'billCode' => $semakBayaranFpxSingle->billCode
                );

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/getBillTransactions');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

                $result = curl_exec($curl);
                $info = curl_getinfo($curl);
                curl_close($curl);
                $data = json_decode($result);
                if($data[0]->billpaymentStatus=='1'){
                    // dd('true');
                    $noResit = Bayaran::with('keahlian')->where('noresitnew', 'like', '%'.date('Y').'%')->orderBy('noresitnew', 'desc')->first();
                    $resitNew = substr($noResit->noresitnew,5,4) + 1;
                    $resitNew = 'R'.date('Y').str_pad($resitNew, 4, '0', STR_PAD_LEFT);
                    $semakBayaranFpxSingle->statusbayaran = '1';
                    $semakBayaranFpxSingle->carabayaran = 'FPX';
                    $semakBayaranFpxSingle->refnumber = $data[0]->billpaymentInvoiceNo;
                    $semakBayaranFpxSingle->noresitnew = $resitNew;
                    $semakBayaranFpxSingle->save();
                }else{
                    $semakBayaranFpxSingle->statusbayaran = '4';
                    $semakBayaranFpxSingle->save();
                }
            }
        }
        return view('frontend.keahlian.perincian', compact('keahlian','databayaran','tahun','configpendaftaran','configtahunsemasa'));
    }

    function kemaskini($encid) {
        try {
            $id = Crypt::decrypt($encid);
        } catch (\Throwable $th) {
            abort(404, 'Resource not found');
        }

        return redirect()->route('keahlian.front.pembaharuan', ['encid' => $encid, 'type' => 'k']);
    }

    function pembaharuan($encid,$type='p') {
        try {
            $id = Crypt::decrypt($encid);
        } catch (\Throwable $th) {
            abort(404, 'Resource not found');
        }

        $keahlian = Keahlian::with('bayaranDetails')->find($id);

        $lt_alamat=Alamat::pluck('keterangan','id');
        $lt_alamat->prepend('Sila Pilih', '');
        return view('frontend.keahlian.pembaharuan', compact('keahlian','lt_alamat','type'));
    }

    function pembaharuanStore($encid, Request $request) {
        try {
            $id = Crypt::decrypt($encid);
        } catch (\Throwable $th) {
            abort(404, 'Resource not found');
        }

        $keahlian = Keahlian::with('bayaranDetails')->find($id);
        $keahlian->nama = $request->nama;
        $keahlian->tlahir = $request->tlahir;
        $keahlian->notel_r = $request->notel_r;
        $keahlian->notel_hp = $request->notel_hp;
        $keahlian->notel_p = $request->notel_p;
        $keahlian->alamat = $request->alamat;
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

        $user = $keahlian->user;
        $user->email = $request->email;
        $user->save();

        if($request->has('namaTanggungan')){

            foreach ($request->namaTanggungan as $key => $namaTanggungan) {
                if($request->idTanggungan[$key]==''){
                    $tanggungan = new Tanggungan();
                }else{
                    $tanggungan = Tanggungan::find($request->idTanggungan[$key]);
                }
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
                try {
                    $tarikhLahir = Carbon::parse($tarikh)->format('Y-m-d');
                } catch (\Throwable $th) {
                    $tarikhLahir = Carbon::now()->subYears($request->umurTanggungan[$key])->format('Y-m-d');
                }
                $tanggungan->tlahir = $tarikhLahir;
                $tanggungan->nokpketua = $keahlian->nokp;
                $tanggungan->save();
            }
        }

        if($request->type=='p'){

            return redirect()->route('keahlian.front.pembaharuanbayaran', ['encid' => Crypt::encrypt($keahlian->id)]);
        }else{
            flash('Maklumat keahlian anda telah berjaya dikemaskini')->success()->important();
            return redirect()->route('keahlian.front.perincian', ['encid' => Crypt::encrypt($keahlian->id)]);
        }
    }

    function permohonanStore(Request $request){
        $keahlian = new Keahlian;
        $keahlian->nama = $request->nama;
        $keahlian->tlahir = $request->tlahir;
        $keahlian->nokp = $request->nokp;
        $keahlian->notel_r = $request->notel_r;
        $keahlian->notel_hp = $request->notel_hp;
        $keahlian->notel_p = $request->notel_p;
        $keahlian->alamat = $request->alamat;
        $keahlian->kodstatuspengguna = '21';
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
        $user->kodstatuspengguna = '21';
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

        return redirect()->route('keahlian.front.pembaharuanbayaran', ['encid' => Crypt::encrypt($keahlian->id),'type'=>'m']);
    }

    function pembaharuanbayaran($encid, $type="p") {
        try {
            $id = Crypt::decrypt($encid);
        } catch (\Throwable $th) {
            abort(404, 'Resource not found');
        }
        $keahlian = Keahlian::with('bayaranDetailsPaid')->find($id);
        $tahunpembaharuan = Config::where('type','tahunsemasa')->first();
        $yearsToRenew = explode('/',$tahunpembaharuan->value);

        foreach($yearsToRenew as $key=>$year){
            if($keahlian->bayaranDetailsPaid->where('jenis','yuran')->where('tahun',$year)->first()){
                unset($yearsToRenew[$key]);
            }
        }

        return view('frontend.keahlian.pembaharuanbayar', compact('keahlian','yearsToRenew','type'));
    }

    function permohonan() {
        $lt_alamat=Alamat::pluck('keterangan','id');
        $lt_alamat->prepend('Sila Pilih', '');
        return view('frontend.keahlian.permohonan', compact('lt_alamat'));
    }

    function pembayaran(Request $request){
        $validator=Validator::make($request->all(), [
            'nokp' => 'required',
            'jumlah' => 'required|integer',
            'caraPembayaran' => 'required',
            'checkboxTahun' => 'required|array|min:1',
            'buktiSumbangan' => 'required_if:caraPembayaran,1|mimes:jpeg,png,jpg,pdf|max:1024'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $tahun = $request->checkboxTahun;
        $checkbayaran = Bayaran::where('nokp',$request->nokp)->where('statusbayaran',0)->whereHas('bayaranDetails', function($q) use ($tahun) {
            $q->whereIn('tahun',$tahun);
        })->first();

        if($checkbayaran){
             $checkbayaran->forceDelete();
        }

        $keahlian = Keahlian::where('nokp',$request->nokp)->first();
        $rekodBayaran = Bayaran::where('nobil','like','BIL'.date('Y').'%')->orderBy('nobil','desc')->first();
        if($rekodBayaran){
            $bilNo = substr($rekodBayaran->nobil,7,4)+1;
            $bil = 'BIL'.date('Y').str_repeat('0',4-strlen($bilNo)).$bilNo;
        }else{
            $bil = 'BIL'.date('Y').'0001';
        }
        $bayaran = new Bayaran;
        $bayaran->nokp = $request->nokp;
        $bayaran->nobil = $bil;
        $bayaran->jumlahbayaran = $request->jumlah;
        $bayaran->kodpengguna = $keahlian->kodpengguna;
        if($request->has('type') && $request->type == 'm'){
            $bayaran->jenisPermohonan ='2';
        }

        if($request->caraPembayaran=='1'){
            $bayaran->carabayaran = 'ONLINE';
            $bayaran->statusbayaran = '2';
            $file = $request->file('buktiSumbangan');
            $fileName = Str::random(40).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/'.$request->nokp.'/'), $fileName);
            $bayaran->buktibayaran = 'uploads/'.$request->nokp.'/'.$fileName;
        }
        if($request->caraPembayaran=='2'){
            $bayaran->carabayaran = 'FPX';
            $bayaran->statusbayaran = '0';
        }
        $bayaran->save();
        if($request->has('checkboxTahun')){
            foreach ($request->checkboxTahun as $key => $value) {
                $bayaranDetail = new BayaranDetail;
                $bayaranDetail->nobil = $bil;
                $bayaranDetail->jenis = 'yuran';
                $bayaranDetail->tahun = $value;
                $bayaranDetail->bayaran_id = $bayaran->id;
                $bayaranDetail->amaun = 50.00;
                $bayaranDetail->save();
            }
        }

        if($request->derma>0){
            $bayaranDetail = new BayaranDetail;
            $bayaranDetail->nobil = $bil;
            $bayaranDetail->jenis = 'derma';
            $bayaranDetail->tahun = $request->checkboxTahun[0];
            $bayaranDetail->bayaran_id = $bayaran->id;
            $bayaranDetail->amaun = $request->derma;
            $bayaranDetail->save();
        }
        if($request->caraPembayaran=='2'){
            $tajuk='';
            foreach ($bayaran->bayaranDetails->where('jenis','yuran') as $key => $value) {
                $tajuk=$tajuk.$value->jenis.' '.$value->tahun.' ';
                $bayaran->bayaranDetails->where('jenis','yuran')->count() < $key+1 ? $tajuk=$tajuk.'dan ' : '';
            }
            if($keahlian->user->email!=''){
                $email = $keahlian->user->email;
            }else{
                $email = 'bbksahbsp@gmail.com';
            }

            $some_data = array(
                'userSecretKey'=>env('TOYYIBPAYCODE'),
                'categoryCode'=>env('TOYYIBPAYCATEGORY'),
                'billName'=>'Yuran Keahlian eKhairat',
                'billDescription'=>'Bill Yuran Keahlian eKhairat '.$tajuk,
                'billPriceSetting'=>1,
                'billPayorInfo'=>1,
                'billAmount'=>($bayaran->jumlahbayaran*100)+100,
                'billReturnUrl'=>'https://ekhairatsahbsp.com/resitUpdate',
                'billCallbackUrl'=>'https://ekhairatsahbsp.com/statuspembayaran',
                'billExternalReferenceNo' => $bayaran->nobil,
                'billTo'=>$keahlian->nama,
                'billEmail'=> $email,
                'billPhone'=>$keahlian->notel_hp ?? '',
                'billPaymentChannel'=>'0',
                'billContentEmail'=>'Terima kasih kerana telah bersama eKhairat!',
                'billChargeToCustomer'=>1
            );



            $curl = curl_init();
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_URL, env('TOYYIBPAYURL').'/index.php/api/createBill');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
            $result = curl_exec($curl);
            // dd($result);
            $info = curl_getinfo($curl);
            curl_close($curl);
            $obj = json_decode($result);

            $data['fpx']=$obj[0];
            $bayaran->billCode = $obj[0]->BillCode;
            $bayaran->save();
        }

        $data['status'] = 'success';
        return response()->json($data, 200);
    }

    function resitUpdate(Request $request) {
        $bayaran = Bayaran::with('keahlian')->where('nobil',$request->order_id)->first();
        $noresitLatest = Bayaran::where('noresitnew','LIKE','R'.date('Y').'%')->orderByDesc('noresitnew')->first();
        if(!$noresitLatest){
            $noresit = 'R'.date('Y').'0001';
        }else{
            $noresit = substr($noresitLatest->noresitnew,5,4)+1;
            $noresit = 'R'.date('Y').str_repeat('0',4-strlen($noresit)).$noresit;
        }

        if($request->status_id=='1'){
            $phoneNumber = $bayaran->keahlian->notel_hp;
            if ($phoneNumber!=null && $phoneNumber!='') {
                $phoneNumber= str_replace(' ', '', $phoneNumber);
                $phoneNumber= str_replace('-', '', $phoneNumber);
                if(substr($phoneNumber, 0, 1) == '0'){
                    $phoneNumber = '6'.$phoneNumber;
                }
                if($this->isStringAllNumbers($phoneNumber)){
                    $mesej = 'Terima kasih atas pembayaran anda sebanyak RM '.$bayaran->jumlahbayaran.'. No resit anda adalah '.$noresit.'. Sila cetak resit anda di sistem ekhairat';
                    $smsBlast = new Smsblast;
                    $smsBlast->msg = $mesej;
                    $smsBlast->dateToBlast = date('Y-m-d');
                    $smsBlast->status = 'pending';
                    $smsBlast->msgCode = Str::random(14);
                    $smsBlast->save();

                    $customRreferenceId = Str::random(6);
                    $smsblastGroup = new SmsblastGroup;
                    $smsblastGroup->smsblast_id = $smsBlast->id;
                    $smsblastGroup->customRreferenceId = $customRreferenceId;
                    $smsblastGroup->status = 'pending';
                    $smsblastGroup->save();

                    $smsblastDetail = new SmsblastDetail;
                    $smsblastDetail->smsblast_id = $smsBlast->id;
                    $smsblastDetail->smsblast_group_id = $smsblastGroup->id;
                    $phoneNumber= str_replace(' ', '', $phoneNumber);
                    $phoneNumber= str_replace('-', '', $phoneNumber);
                    if(substr($phoneNumber, 0, 1) == '0'){
                        $phoneNumber = '6'.$phoneNumber;
                    }
                    $smsblastDetail->phoneNumber = $phoneNumber;
                    $smsblastDetail->status = 'pending';
                    $smsblastDetail->save();

                    dispatch(new SendSMS($smsBlast->smsBlastGroups->first()->id));
                }
            }
            $bayaran->statusbayaran = '1';
            $bayaran->noresitnew = $noresit;
            $bayaran->refnumber = $request->transaction_id;
            $bayaran->keahlian->statusahli = 1;
            $bayaran->save();
            return redirect()->route('keahlian.front.resit', ['encnoresit' => Crypt::encrypt($bayaran->id),'status'=>'s']);
        }else{
            $bayaran->statusbayaran = '4';
            $bayaran->save();
            return redirect()->route('keahlian.front.resit', ['encnoresit' => Crypt::encrypt($bayaran->id),'status'=>'s']);
        }

    }

    function resit($encnoresit, $status) {
        try {
            $id = Crypt::decrypt($encnoresit);
        } catch (\Throwable $th) {
            abort(404, 'Resource not found');
        }
        $bayaran = Bayaran::find($id);
        return view('frontend.keahlian.resit', compact('bayaran','status'));
    }

    function isStringAllNumbers($str) {
        return preg_match('/^[0-9]+$/', $str) === 1;
    }

    function carian() {
        return view('carian.index');
    }

    function search(Request $request) {
        $request->validate([
            'nokp'=>'required'
        ]);

        $keahlian = Keahlian::where('nokp',$request->nokp)->first();

        if($keahlian){
            return redirect()->route('profil.index', ['u'=>Crypt::encrypt($keahlian->id)]);
        }else{
            $keahlian = Keahlian::where('nokppasangan',$request->nokp)->first();
            if($keahlian){
                return redirect()->route('profil.index', ['u'=>Crypt::encrypt($keahlian->id)]);
            }else{
                $tanggungan = Tanggungan::where('nokp',$request->nokp)->first();
                if($tanggungan){
                    return redirect()->route('profil.index', ['u'=>Crypt::encrypt($tanggungan->ketua->id)]);
                }else{

                }
                // return redirect()->route('profil.index', ['u'=>Crypt::encrypt($keahlian->id)]);
            }
        }
    }

    function delete(Request $request){
        $bayaran = Bayaran::find($request->id);
        $bayaran->forceDelete();
        return response()->json(['status'=>'success']);
    }

}
