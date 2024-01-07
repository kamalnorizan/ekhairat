<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Alamat;
use App\Models\Tahun;
use App\Models\Config;
use App\Models\Keahlian;
use App\Models\Bayaran;
use App\Models\BayaranDetail;
use App\Models\Tanggungan;
use App\Models\Smsblast;
use App\Models\SmsblastGroup;
use App\Models\SmsblastDetail;
use App\Models\TahunTajaan;
use Illuminate\Support\Str;
use App\Jobs\SendSMS;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Crypt;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProfilController extends Controller
{
    function index($u=null) {
        $type = 'k';
        if($u!=null) {
            $keahlian = Keahlian::find(Crypt::decrypt($u));
        }else{
            $keahlian = Auth::user()->keahlian;
        }
        //semak fpx
        $bayaranFpx = Bayaran::where('nokp',$keahlian->nokp)->where('carabayaran','FPX')->where('statusbayaran','4')->get();
        foreach($bayaranFpx as $bayaranf) {
            if($bayaranf->billCode != null || $bayaranf->billCode != ''){
                $client = new Client();
                $options = [
                'multipart' => [
                    [
                    'name' => 'billCode',
                    'contents' => $bayaranf->billCode
                    ],
                    [
                    'name' => 'billpaymentStatus',
                    'contents' => '1'
                    ]
                ]];
                //post request
                $promise = $client->postAsync('https://toyyibpay.com/index.php/api/getBillTransactions', $options);

                $promise->then(
                    function ($response) use ($bayaranf) {
                        $data = json_decode($response->getBody()->getContents());

                        if($data[0]->billpaymentStatus == '1'){
                            $noResit = Bayaran::with('keahlian')->where('noresitnew', 'like', '%'.date('Y').'%')->orderBy('noresitnew', 'desc')->first();
                            $resitNew = substr($noResit->noresitnew,5,4) + 1;
                            $resitNew = 'R'.date('Y').str_pad($resitNew, 4, '0', STR_PAD_LEFT);
                            $bayaranf->statusbayaran = '1';
                            $bayaranf->refnumber = $data[0]->billpaymentInvoiceNo;
                            $bayaranf->noresitnew = $resitNew;
                            $bayaranf->save();
                        }
                    },
                    function ($exception) {
                        echo $exception->getMessage();
                    }
                );
                $promise->wait();
            }
        }

        $lt_alamat = Alamat::pluck('keterangan','id');
        $tahun = Tahun::all();
        $databayaran = collect();
        $tahunTajaan = TahunTajaan::all();
        foreach($keahlian->bayaran->where('statusbayaran','1') as $bayaran) {
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
        return view('backend.keahlian.profil',compact('type','keahlian','lt_alamat','databayaran','tahun','configpendaftaran','configtahunsemasa'));
    }

    function kemaskiniDokumen (Request $request) {
        $validator=Validator::make($request->all(), [
            'dokumen' => 'required|mimes:jpeg,png,jpg,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $bayaran = Bayaran::find($request->id);
        $file = $request->file('dokumen');
        $fileName = Str::random(40).'.'.$file->getClientOriginalExtension();
        $file->move(public_path('uploads/'.$bayaran->keahlian->nokp.'/'), $fileName);
        $bayaran->buktibayaran = 'uploads/'.$bayaran->keahlian->nokp.'/'.$fileName;
        $bayaran->save();

        $data['status'] = 'success';
        $data['buktibayaran'] = $bayaran->buktibayaran;
        return response()->json($data, 200);

    }

    function update(Request $request) {
        // dd($request->all());
        $id = $request->id;
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
                $tanggungan->tlahir = Carbon::parse($tarikh)->format('Y-m-d');
                $tanggungan->nokpketua = $keahlian->nokp;
                $tanggungan->save();
            }
        }

        if($request->requestType=='kemaskini'){
            flash('Maklumat keahlian anda telah berjaya dikemaskini')->success()->important();
            return redirect()->back();
        }else{
            flash('Maklumat keahlian anda telah berjaya dikemaskini')->success()->important();
            return redirect()->route('profil.pembaharuan',Crypt::encrypt($keahlian->id));
        }

    }

    function pembaharuan($encid, $type=null) {
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

        return view('profil.pembaharuan', compact('keahlian','yearsToRenew','type'));
    }

    function pembayaran(Request $request) {
        $validator=Validator::make($request->all(), [
            'nokp' => 'required',
            'jumlah' => 'required|integer',
            'caraPembayaran' => 'required',
            'checkboxTahun' => 'required|array|min:1',
            'buktiSumbangan' => 'required_if:caraPembayaran,1|mimes:jpeg,png,jpg,pdf|max:1024'
        ]);

        // dd($request->all());

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $keahlian = Keahlian::where('nokp',$request->nokp)->first();
        $rekodBayaran = Bayaran::where('nobil','like','BIL'.(date('Y')).'%')->orderBy('nobil','desc')->first();
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

        if($request->caraPembayaran=='1'){
            $bayaran->carabayaran = 'ONLINE';
            $bayaran->statusbayaran = '2';
            $file = $request->file('buktiSumbangan');
            $fileName = Str::random(40).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/'.$request->nokp.'/'), $fileName);
            $bayaran->buktibayaran = 'uploads/'.$request->nokp.'/'.$fileName;
        }else if($request->caraPembayaran=='2'){
            $bayaran->carabayaran = 'FPX';
            $bayaran->statusbayaran = '0';
        }else if($request->caraPembayaran=='3'){
            $bayaran->carabayaran = 'TUNAI';
            $bayaran->statusbayaran = '0';
        }else if($request->caraPembayaran=='4'){
            $bayaran->carabayaran = 'TAJAAN';
            $bayaran->statusbayaran = '1';
            $bayaran->jumlahbayaran = '0';
        }else if($request->caraPembayaran=='5'){
            $bayaran->carabayaran = 'TAJAAN';
            $bayaran->statusbayaran = '1';
            $bayaran->jumlahbayaran = '0';
        }

        if($request->has('pengesahanSemak')){
            $noResit = Bayaran::with('keahlian')->where('noresitnew', 'like', '%'.date('Y').'%')->orderBy('noresitnew', 'desc')->first();
            $resitNew = substr($noResit->noresitnew,5,4) + 1;
            $resitNew = 'R'.date('Y').str_pad($resitNew, 4, '0', STR_PAD_LEFT);
            $bayaran->statusbayaran = '1';
            $bayaran->kelulusanbayaran_oleh = Auth::user()->id;
            $bayaran->kelulusanbayaran_pada = date('Y-m-d H:i:s');
            $bayaran->noresitnew = $resitNew;
        }

        $bayaran->save();
        if($request->has('checkboxTahun')){
            foreach ($request->checkboxTahun as $key => $value) {
                $bayaranDetail = new BayaranDetail;
                $bayaranDetail->nobil = $bil;
                $bayaranDetail->jenis = 'yuran';
                $bayaranDetail->tahun = $value;
                $bayaranDetail->bayaran_id = $bayaran->id;
                if($request->caraPembayaran=='4'){
                    $bayaranDetail->amaun = 0.00;
                }elseif($request->caraPembayaran=='5'){
                    $bayaranDetail->amaun = 0.00;
                }else{
                    $bayaranDetail->amaun = 50.00;
                }
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
            $info = curl_getinfo($curl);
            curl_close($curl);
            $obj = json_decode($result);
            // dd($obj);
            $data['fpx']=$obj[0];
            $bayaran->billCode = $obj[0]->BillCode;
            $bayaran->save();
        }

        if($request->has('pengesahanSemak')){
            $phoneNumber = $bayaran->keahlian->notel_hp;

            if ($phoneNumber!=null && $phoneNumber!='') {
                $phoneNumber= str_replace(' ', '', $phoneNumber);
                $phoneNumber= str_replace('-', '', $phoneNumber);
                if(substr($phoneNumber, 0, 1) == '0'){
                    $phoneNumber = '6'.$phoneNumber;
                }
                if($request->caraPembayaran=='1' || $request->caraPembayaran=='2' || $request->caraPembayaran=='3'){
                    if($this->isStringAllNumbers($phoneNumber)){
                        $mesej = 'Pembayaran anda sebanyak RM '.$bayaran->jumlahbayaran.' telah disahkan. No resit anda adalah '.$bayaran->noresitnew.'. Sila cetak resit anda di sistem ekhairat';
                        $smsBlast = new Smsblast;
                        $smsBlast->msg = $mesej;
                        $smsBlast->dateToBlast = date('Y-m-d');
                        $smsBlast->status = 'pending';
                        $smsBlast->msgCode = Str::random(14);
                        $smsBlast->created_by = Auth::user()->id;
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
            }
        }

        $data['status'] = 'success';
        return response()->json($data, 200);
    }


    function resit($encid) {
        try {
            $id = Crypt::decrypt($encid);
        } catch (\Throwable $th) {
            abort(404, 'Resource not found');
        }
        $bayaran = Bayaran::find($id);
        return view('resit.backend', compact('bayaran'));
    }

    function loadPengesahan(Request $request) {
        $bayaran = Bayaran::with('bayaranDetails')->find($request->id);
        $data['bayaran'] = $bayaran;
        return response()->json($data, 200);
    }

    function sahkanPembayaran(Request $request) {
        $bayaran = Bayaran::find($request->id);
        $noResit = Bayaran::with('keahlian')->where('noresitnew', 'like', '%'.date('Y').'%')->orderBy('noresitnew', 'desc')->first();
        $resitNew = substr($noResit->noresitnew,5,4) + 1;
        $resitNew = 'R'.date('Y').str_pad($resitNew, 4, '0', STR_PAD_LEFT);
        $bayaran->statusbayaran = '1';
        $bayaran->kelulusanbayaran_oleh = Auth::user()->id;
        $bayaran->kelulusanbayaran_pada = date('Y-m-d H:i:s');
        $bayaran->noresitnew = $resitNew;
        $bayaran->save();
        $phoneNumber = $bayaran->keahlian->notel_hp;
        if ($phoneNumber!=null && $phoneNumber!='') {
            $phoneNumber= str_replace(' ', '', $phoneNumber);
            $phoneNumber= str_replace('-', '', $phoneNumber);
            if(substr($phoneNumber, 0, 1) == '0'){
                $phoneNumber = '6'.$phoneNumber;
            }
            if($this->isStringAllNumbers($phoneNumber)){
                $mesej = 'Pembayaran anda sebanyak RM '.$bayaran->jumlahbayaran.' telah disahkan. No resit anda adalah '.$resitNew.'. Sila cetak resit anda di sistem ekhairat';
                $smsBlast = new Smsblast;
                $smsBlast->msg = $mesej;
                $smsBlast->dateToBlast = date('Y-m-d');
                $smsBlast->status = 'pending';
                $smsBlast->msgCode = Str::random(14);
                $smsBlast->created_by = Auth::user()->id;
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


        return response()->json(['message' => 'Berjaya disahkan'], 200);
    }

    function sahkanPembayaranfpx(Request $request){
        $bayaran = Bayaran::find($request->id);
        $noResit = Bayaran::with('keahlian')->where('noresitnew', 'like', '%'.date('Y').'%')->orderBy('noresitnew', 'desc')->first();
        $resitNew = substr($noResit->noresitnew,5,4) + 1;
        $resitNew = 'R'.date('Y').str_pad($resitNew, 4, '0', STR_PAD_LEFT);
        $bayaran->statusbayaran = '1';
        $bayaran->carabayaran = 'FPX';
        $bayaran->refnumber = $request->billpaymentInvoiceNo;
        $bayaran->billCode = $request->kodFpx;
        $bayaran->noresitnew = $resitNew;
        $bayaran->save();
        $phoneNumber = $bayaran->keahlian->notel_hp;
        if ($phoneNumber!=null && $phoneNumber!='') {
            $phoneNumber= str_replace(' ', '', $phoneNumber);
            $phoneNumber= str_replace('-', '', $phoneNumber);
            if(substr($phoneNumber, 0, 1) == '0'){
                $phoneNumber = '6'.$phoneNumber;
            }
            if($this->isStringAllNumbers($phoneNumber)){
                $mesej = 'Pembayaran anda sebanyak RM '.$bayaran->jumlahbayaran.' telah disahkan. No resit anda adalah '.$resitNew.'. Sila cetak resit anda di sistem ekhairat';
                $smsBlast = new Smsblast;
                $smsBlast->msg = $mesej;
                $smsBlast->dateToBlast = date('Y-m-d');
                $smsBlast->status = 'pending';
                $smsBlast->msgCode = Str::random(14);
                $smsBlast->created_by = Auth::user()->id;
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


        return response()->json(['message' => 'Berjaya disahkan'], 200);
    }

    function isStringAllNumbers($str) {
        return preg_match('/^[0-9]+$/', $str) === 1;
    }

    function semakPembayaranFpx(Request $request){
        $some_data = array(
            'billCode' => $request->kodFpx
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
          return response()->json($data, 200);
    }
}
