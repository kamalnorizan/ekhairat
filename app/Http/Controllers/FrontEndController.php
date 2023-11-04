<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keahlian;
use App\Models\Tanggungan;
use App\Models\Penerima;
use App\Models\Config;
use App\Models\User;
use App\Models\Bayaran;
use Str;
use DB;
use Mail;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

// Set the locale to Malay


class FrontEndController extends Controller
{
    function index() {
        App::setLocale('ms');
        $keahlian = Keahlian::count();
        $pasangan = Keahlian::whereNotNull('nokppasangan')->count();
        $tangungan = Tanggungan::count();
        $penerima = Penerima::get();
        $penerimaSlide = Penerima::whereNotNull('nama')->where('nama','!=','')->orderBy('status')->get();
        $configDaftar = Config::where('type', 'pendaftaran')->first();
        $ahli = $pasangan + $tangungan + $keahlian;
        return view('frontend.index', compact('keahlian','ahli','penerima','configDaftar','penerimaSlide'));
    }

    function checkKeahlian(Request $request) {
        $recaptchaResponse = $request->input('g-recaptcha-response');

        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'secret' => env('RECAPTCHA_SECRET_KEY'), // Using environment variable
            'response' => $recaptchaResponse,
        ]));
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        $body = json_decode($response, true);
    
        if (!$body['success']) {
            return response()->json(['error' => 'ReCAPTCHA verification failed']);
        }
        
         $keahlian = Keahlian::where('nokp', $request->nokp)->first();
        $configDaftar = Config::where('type', 'pendaftaran')->first();
        $configTahunSemasa = Config::where('type', 'tahunsemasa')->first();
        $configTahunSemasaExp = explode('/',$configTahunSemasa->value);
        // dd($configTahunSemasaExp);
        $aktifBayaran = Bayaran::where('nokp', $request->nokp)->where('statusbayaran', '1')->orderBy('id', 'desc')->first();
        $menungguPengesahan = Bayaran::where('nokp', $request->nokp)->where('statusbayaran', '2')->where('carabayaran','online')->whereHas('bayaranDetails', function($q) use ($configTahunSemasaExp){
            $q->where('jenis','yuran')->whereIn('tahun',$configTahunSemasaExp);
        })->orderBy('id', 'desc')->first();
        // dd($menungguPengesahan);
        $aktifBayaranSemasa = Bayaran::where('nokp', $request->nokp)->where('statusbayaran', '1')->whereHas('bayaranDetails', function($q){
            $q->where('jenis','yuran')->where('tahun',date('Y'));
        })->orderBy('id', 'desc')->first();
        
        $aktifBayaranSeterusnya = Bayaran::where('nokp', $request->nokp)->where('statusbayaran', '1')->whereHas('bayaranDetails', function($q){
            $q->where('jenis','yuran')->where('tahun',date('Y')+1);
        })->orderBy('id', 'desc')->first();
        
        $data['html'] =  view('frontend.keahlian', compact('keahlian', 'configDaftar', 'configTahunSemasa', 'aktifBayaran','aktifBayaranSemasa', 'aktifBayaranSeterusnya','menungguPengesahan'))->render();
        if ($keahlian) {
            $data['status'] = 'success';
        } else {
            $data['failed'] = 'failed';
        }
    
        return response()->json($data);
    }
    
    function checkKeahlianBe($nokp) {
        // $recaptchaResponse = $request->input('g-recaptcha-response');

        // $ch = curl_init();
        
        // curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        //     'secret' => env('RECAPTCHA_SECRET_KEY'), // Using environment variable
        //     'response' => $recaptchaResponse,
        // ]));
    
        // $response = curl_exec($ch);
        // curl_close($ch);
    
        // $body = json_decode($response, true);
    
        // if (!$body['success']) {
        //     return response()->json(['error' => 'ReCAPTCHA verification failed']);
        // }
        
        $keahlian = Keahlian::where('nokp', $nokp)->first();
        $configDaftar = Config::where('type', 'pendaftaran')->first();
        $configTahunSemasa = Config::where('type', 'tahunsemasa')->first();
        $configTahunSemasaExp = explode('/',$configTahunSemasa->value);
        // dd($configTahunSemasaExp);
        $aktifBayaran = Bayaran::where('nokp', $nokp)->where('statusbayaran', '1')->orderBy('id', 'desc')->first();
        $menungguPengesahan = Bayaran::where('nokp', $nokp)->where('statusbayaran', '2')->where('carabayaran','online')->whereHas('bayaranDetails', function($q) use ($configTahunSemasaExp){
            $q->where('jenis','yuran')->whereIn('tahun',$configTahunSemasaExp);
        })->orderBy('id', 'desc')->first();
        // dd($menungguPengesahan);
        $aktifBayaranSemasa = Bayaran::where('nokp', $nokp)->where('statusbayaran', '1')->whereHas('bayaranDetails', function($q){
            $q->where('jenis','yuran')->where('tahun',date('Y'));
        })->orderBy('id', 'desc')->first();
        
        $aktifBayaranSeterusnya = Bayaran::where('nokp', $nokp)->where('statusbayaran', '1')->whereHas('bayaranDetails', function($q){
            $q->where('jenis','yuran')->where('tahun',date('Y')+1);
        })->orderBy('id', 'desc')->first();
        // dd($aktifBayaranSemasa);
        return view('frontend.keahlian', compact('keahlian', 'configDaftar', 'configTahunSemasa', 'aktifBayaran','aktifBayaranSemasa', 'aktifBayaranSeterusnya','menungguPengesahan'));
    }
    
    
    function showForgetPasswordForm(){
        return view('auth.foregetpassword');
    }
    
    function submitForgetPasswordForm(Request $request){
        $request->validate([
             'email' => 'required|email|exists:users',
        ]);
        
        $token = Str::random(64);
   
        DB::table('password_resets')->insert([
          'email' => $request->email, 
          'token' => $token, 
          'created_at' => Carbon::now()
        ]);
        
        Mail::send('auth.emailforget', ['token' => $token], function($message) use($request){
          $message->to($request->email);
          $message->subject('Reset Password');
      });
        
        return back()->with('message', 'Sila semak email untuk reset katalaluan');
    }


    public function showResetPasswordForm($token) { 
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }
    
    public function submitResetPasswordForm(Request $request)
      {
          $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
    
          $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
    
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
    
          $user = User::where('email', $request->email)
                      ->update(['password' => Hash::make($request->password)]);
    
          DB::table('password_resets')->where(['email'=> $request->email])->delete();
    
          return redirect('/login')->with('message', 'Kata laluan anda telah dikemaskini');
      }
}
