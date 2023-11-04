<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keahlian;
use App\Models\Smsblast;
use App\Models\SmsblastGroup;
use App\Models\SmsblastDetail;
use App\Models\SMSBlastTemplate;
use Illuminate\Support\Str;
use Auth;
use App\Jobs\SendSMS;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class SmsblastController extends Controller
{
    function index() {
        $templates = SMSBlastTemplate::where('status','active')->pluck('title','id');
        $templates[''] = 'Pilih Template';
        // dd($templates);
        $smsBlasts = Smsblast::orderBy('id', 'desc')->get();
        return view('smsblast.index',compact('smsBlasts','templates'));
    }

    function test() {

        $url =  'https://www.sms123.net/api/send.php?apiKey=dfb4f51da89af77d120031d0ea225221&recipients=60162084090;60162064090&messageContent=MASJID%20AT-TAQWA%20DSP%0A%0ATEST SMS&referenceID=q64b44';
        $response = file_get_contents($url);
        $response= json_decode($response);

        dump($response);
        dump($response->data[0]->recipients);
        dd($response->data[1]);
        // $response = curl_exec($curl);
        // curl_close($curl);

    }

    function getTemplate(Request $request) {
        $template = SMSBlastTemplate::find($request->id);
        return response()->json($template, 200);
    }

    function penerima(Request $request) {
        switch ($request->penerima) {
            case '1':
                $keahlian = Keahlian::whereNotNull('notel_hp')->count();
                break;
            case '2':
                $keahlian = Keahlian::whereDoesntHave('bayaranDetailsPaid', function($query){
                    $query->where('jenis', 'yuran')->where('tahun','2024');
                })->whereNotNull('notel_hp')->count();
                break;
        }

        $url =  'https://www.sms123.net/api/getBalance.php?apiKey='.env('SMSAPIKEY').'&email='.env('SMSEMAIL');
        $response = file_get_contents($url);
        $response= json_decode($response);
        $balance = $response->balance;
        $totalCost = 2.7 * $keahlian;
        $penerima = $keahlian;
        $msg='';
        if($balance < $totalCost) {
            $msg = 'Kredit tidak mencukupi. Kredit semasa anda adalah sebanyak '.$balance.' dan kos penghantaran untuk '.$penerima.' SMS adalah sebanyak '.number_format($totalCost,2).' kredit. Sila topup kredit anda.';
        }else{
            $msg='cukup';
        }
        $data = [
            'jumlah' => $penerima,
            'response' => $response,
            'totalCost' => $totalCost,
            'msg' => $msg
        ];
        return response()->json($data, 200);
    }

    function send(Request $request) {
        switch ($request->penerima) {
            case '1':
                $keahlian = Keahlian::select('notel_hp')->whereNotNull('notel_hp')->pluck('notel_hp')->toArray();
                break;
            case '2':
                $keahlian = Keahlian::select('notel_hp')->whereDoesntHave('bayaranDetailsPaid', function($query){
                    $query->where('jenis', 'yuran')->where('tahun','2024');
                })->whereNotNull('notel_hp')->pluck('notel_hp')->toArray();
                break;
            case '3':
                $keahlian = explode(';', $request->customTel);
                break;
        }

        $smsBlast = new Smsblast;
        $smsBlast->msg = $request->mesej;
        $smsBlast->dateToBlast = date('Y-m-d');
        $smsBlast->status = 'pending';
        $smsBlast->msgCode = Str::random(14);
        $smsBlast->created_by = Auth::user()->id;
        $smsBlast->save();
        if(count($keahlian)>1){
            $chunks = array_chunk($keahlian, 99);
            // dd($chunks);
            foreach ($chunks as $key => $chunk) {
                $customRreferenceId = Str::random(6);
                $smsblastGroup = new SmsblastGroup;
                $smsblastGroup->smsblast_id = $smsBlast->id;
                $smsblastGroup->customRreferenceId = $customRreferenceId;
                $smsblastGroup->status = 'pending';
                $smsblastGroup->save();

                foreach ($chunk as $key => $chunkDetail) {
                    $smsblastDetail = new SmsblastDetail;
                    $smsblastDetail->smsblast_id = $smsBlast->id;
                    $smsblastDetail->smsblast_group_id = $smsblastGroup->id;
                    $chunkDetail= str_replace(' ', '', $chunkDetail);
                    $chunkDetail= str_replace('-', '', $chunkDetail);
                    if(substr($chunkDetail, 0, 1) == '0'){
                        $chunkDetail = '6'.$chunkDetail;
                    }
                    $smsblastDetail->phoneNumber = $chunkDetail;
                    $smsblastDetail->status = 'pending';
                    if($this->isStringAllNumbers($chunkDetail)){
                        $smsblastDetail->save();
                    }
                }
            }
        }else{
            $customRreferenceId = Str::random(6);
            $smsblastGroup = new SmsblastGroup;
            $smsblastGroup->smsblast_id = $smsBlast->id;
            $smsblastGroup->customRreferenceId = $customRreferenceId;
            $smsblastGroup->status = 'pending';
            $smsblastGroup->save();

            foreach ($keahlian as $key => $chunkDetail) {
                $smsblastDetail = new SmsblastDetail;
                $smsblastDetail->smsblast_id = $smsBlast->id;
                $smsblastDetail->smsblast_group_id = $smsblastGroup->id;
                $chunkDetail= str_replace(' ', '', $chunkDetail);
                if(substr($chunkDetail, 0, 1) == '0'){
                    $chunkDetail = '6'.$chunkDetail;
                }
                $smsblastDetail->phoneNumber = $chunkDetail;
                $smsblastDetail->status = 'pending';
                if($this->isStringAllNumbers($chunkDetail)){
                    $smsblastDetail->save();
                }
            }
        }
        dispatch(new SendSMS($smsBlast->smsBlastGroups->first()->id));
        flash('SMS Telah Diproses')->success()->important();
        return redirect()->back();
    }

    function processSend($id) {
        $smsblastGroup = SmsblastGroup::with('smsBlastDetails')->find($id);
        $smsblastGroup->status = 'processing';
        $smsblastGroup->save();

        $smsBlast = $smsblastGroup->smsBlast;

        $smsblastDetails = SmsblastDetail::where('smsblast_group_id', $id)->pluck('phoneNumber')->toArray();
        $smsNumbers = implode(';', $smsblastDetails);

        $msg = urlencode(env('SMSCODE').' '.$smsBlast->msg);
        $apiKey = env('SMSAPIKEY');
        // dd($smsblastGroup->customRreferenceId);
        $url =  'https://www.sms123.net/api/send.php?apiKey='.$apiKey.'&recipients='.$smsNumbers.'&messageContent='.$msg.'&referenceID='.$smsblastGroup->customRreferenceId;
        $response = file_get_contents($url);
        // dd($response);
        $response= json_decode($response);
        foreach ($response->data as $key => $data) {
            $smsblastGroup->smsBlastDetails->where('phoneNumber', $data->recipients)->first()->update([
                'status' => 'sent',
                'referenceID' => $data->referenceID
            ]);
        }

        $smsblastGroup->status = 'sent';
        $smsblastGroup->save();
        if($smsBlast->smsBlastGroups->where('status', 'pending')->count()>0){
            dispatch(new SendSMS($smsBlast->smsBlastGroups->where('status', 'pending')->first()->id));
        }else{
            $smsBlast->status = 'sent';
            $smsBlast->save();
        }
    }

    function isStringAllNumbers($str) {
        return preg_match('/^[0-9]+$/', $str) === 1;
    }
}

