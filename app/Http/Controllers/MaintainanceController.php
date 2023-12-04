<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bayaran;
class MaintainanceController extends Controller
{
    function index() {
        $semakBayaranFpx = Bayaran::whereIn('statusbayaran',[0,4])->where('carabayaran','FPX')->get();

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
                echo 'found | '.$semakBayaranFpxSingle->id.'<br>';
            }else{
                echo 'not found | '.$semakBayaranFpxSingle->id.'<br>';
            }
        }
    }
}
