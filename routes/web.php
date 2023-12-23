<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeahlianController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TanggunganController;
use App\Http\Controllers\KetetapanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SmsblastController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\PembaharuanController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MaintainanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/m-artisan', function () {
    if( env('CUSTOM_ARTISAN') ){
        echo "<form method=post>";
        echo "<input type='hidden' name='_token' value='" . csrf_token() . "' />";
        echo "<input type='text' name='command' placeholder='Write your artisan command here' />";
        echo "<button>Execute</button>";
        echo "</form>";
        return 'write command without php artisan.';
    }else{
        return "Naaah... Not Allowed !!";
    }

});
Route::post('/m-artisan', function (Request $request) {
    if (env('CUSTOM_ARTISAN')) {
        echo "<form method=post>";
        echo "<input type='hidden' name='_token' value='" . csrf_token() . "' />";
        echo "<input type='text' name='command' value='".$request->command."' placeholder='writ your artisan command here' />";
        echo "<button>Execute</button>";
        echo "</form>";
        try {
            Artisan::call($request->command);
            dump(Artisan::output());
        } catch (\Throwable $th) {
            echo "Error : ".$th->getMessage();
        }
    }else{
        return 'Naaah... Not Allowed !!';
    }
    return 'Command executed';
});

Route::middleware(['visitcounter'])->group(function () {
    Route::get('/', [FrontEndController::class,'index'])->name('index');
});

// Route::get('/maintainance/checkfpx', [MaintainanceController::class,'index'])->name('maintainance.index')->middleware('auth');

Route::post('/checkKeahlian', [FrontEndController::class,'checkKeahlian'])->name('front.checkKeahlian');
Route::get('/checkKeahlian/{ic}', [FrontEndController::class,'checkKeahlianBe'])->name('front.checkKeahlianBe');
Route::get('keahlian', [KeahlianController::class,'frontIndex'])->name('keahlian.front.index');
Route::get('perincian/{encid}', [KeahlianController::class,'perincian'])->name('keahlian.front.perincian');
Route::get('pembaharuan/bayaran/{encid}/{type?}', [KeahlianController::class,'pembaharuanbayaran'])->name('keahlian.front.pembaharuanbayaran');
Route::get('pembaharuan/{encid}/{type?}', [KeahlianController::class,'pembaharuan'])->name('keahlian.front.pembaharuan');
Route::get('kemaskini/{encid}', [KeahlianController::class,'kemaskini'])->name('keahlian.front.kemaskini');
// Route::get('permohonan', [KeahlianController::class,'permohonan'])->name('keahlian.front.permohonan');
Route::post('pembaharuan/ajaxloadpembaharuan', [PembaharuanController::class,'ajaxloadpembaharuan'])->name('pembaharuan.ajaxloadpembaharuan');
Route::post('pembaharuan/pembayaran', [KeahlianController::class,'pembayaran'])->name('keahlian.front.pembayaran');
Route::post('pembaharuan/delete', [KeahlianController::class,'delete'])->name('pembaharuan.delete');
Route::post('pembaharuan/{encid}', [KeahlianController::class,'pembaharuanStore'])->name('keahlian.front.pembaharuanStore');



Route::post('permohonan', [KeahlianController::class,'permohonanStore'])->name('keahlian.front.permohonanStore');

Route::get('/resitUpdate', [KeahlianController::class, 'resitUpdate'])->name('keahlian.front.resitUpdate');
Route::get('/statuspembayaran', [KeahlianController::class, 'statuspembayaran'])->name('keahlian.front.statuspembayaran');
Route::get('/resit/{encnoresit}/{status}', [KeahlianController::class, 'resit'])->name('keahlian.front.resit');

Route::post('tanggungan/loadTanggunganAjax', [TanggunganController::class,'loadTanggunganAjax'])->name('tanggungan.loadTanggunganAjax');
Route::post('tanggungan/deleteTanggunganAjax', [TanggunganController::class,'deleteTanggunganAjax'])->name('tanggungan.deleteTanggunganAjax');


Auth::routes(['register'=>false]);
Route::get('forget-password', [FrontEndController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [FrontEndController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [FrontEndController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [FrontEndController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// Route::get('/generateBayaran', [HomeController::class, 'generateBayaran'])->name('generateBayaran');
Route::get('/generateTarikhLahir', [HomeController::class, 'generateTarikhLahir'])->name('generateTarikhLahir');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/checkuser', [HomeController::class, 'checkuser'])->name('checkuser');
Route::post('home/updatePinAjax', [HomeController::class,'updatePinAjax'])->name('home.updatePinAjax');

Route::middleware(['auth', 'checkSessionTimeout'])->group(function () {
    Route::get('profil/resit/{encid}', [ProfilController::class,'resit'])->name('profil.resit');
    Route::get('profil/pembaharuan/{encid}', [ProfilController::class,'pembaharuan'])->name('profil.pembaharuan');
    Route::get('profil/{u?}', [ProfilController::class,'index'])->name('profil.index');
    Route::post('profil/pembayaran', [ProfilController::class,'pembayaran'])->name('profil.pembayaran');
    Route::post('profil/kemaskiniDokumen', [ProfilController::class,'kemaskiniDokumen'])->name('profil.kemaskiniDokumen');
    Route::post('profil/update', [ProfilController::class,'update'])->name('profil.update');
    Route::post('profil/loadPengesahan', [ProfilController::class,'loadPengesahan'])->name('profil.loadPengesahan');
    Route::post('profil/sahkanPembayaran', [ProfilController::class,'sahkanPembayaran'])->name('profil.sahkanPembayaran');
    Route::post('profil/semakPembayaranFpx', [ProfilController::class,'semakPembayaranFpx'])->name('profil.semakPembayaranFpx');
    Route::post('profil/sahkanPembayaranfpx', [ProfilController::class,'sahkanPembayaranfpx'])->name('profil.sahkanPembayaranfpx');

});


Route::get('keahlianadm', [KeahlianController::class,'index'])->name('keahlianadm.index');
Route::post('keahlianadm/ajaxLoadAhli', [KeahlianController::class,'ajaxLoadAhli'])->name('keahlianadm.ajaxLoadAhli');

Route::get('/ketetapan', [KetetapanController::class, 'index'])->name('ketetapan.index');
Route::post('/ketetapan/updateStatusPembaharuan', [KetetapanController::class, 'updateStatusPembaharuan'])->name('ketetapan.updateStatusPembaharuan');
Route::post('/ketetapan/ajaxLoadPengguna', [KetetapanController::class, 'ajaxLoadPengguna'])->name('ketetapan.ajaxLoadPengguna');
Route::post('/ketetapan/ajaxLoadTajaan', [KetetapanController::class, 'ajaxLoadTajaan'])->name('ketetapan.ajaxLoadTajaan');
Route::post('/ketetapan/ajaxLoadRekodTajaan', [KetetapanController::class, 'ajaxLoadRekodTajaan'])->name('ketetapan.ajaxLoadRekodTajaan');
Route::post('/ketetapan/ajaxSimpanTajaan', [KetetapanController::class, 'ajaxSimpanTajaan'])->name('ketetapan.ajaxSimpanTajaan');

Route::get('/sms',[SmsblastController::class,'index'])->name('sms.index');
Route::get('/sms/test',[SmsblastController::class,'test'])->name('sms.test');
Route::post('/sms/send',[SmsblastController::class,'send'])->name('sms.send');
Route::post('/sms/ajaxLoadAhli',[SmsblastController::class,'ajaxLoadAhli'])->name('sms.ajaxLoadAhli');
Route::post('/sms/penerima',[SmsblastController::class,'penerima'])->name('sms.penerima');
Route::post('/sms/getTemplate',[SmsblastController::class,'getTemplate'])->name('sms.getTemplate');

Route::get('/smsblast',[SmsblastController::class,'smsblast'])->name('smsblast.index');
Route::get('/sms/processSend/{id}',[SmsblastController::class,'processSend'])->name('smsblast.processSend');

Route::get('pembaharuan', [PembaharuanController::class,'index'])->name('pembaharuan.index');

Route::get('pembaharuan/cash/{encid}', [PembaharuanController::class,'cash'])->name('pembaharuan.cash');

Route::get('permohonan', [PermohonanController::class,'index'])->name('permohonan.index');
Route::post('permohonan/ajaxloadpermohonan', [PermohonanController::class,'ajaxloadpermohonan'])->name('permohonan.ajaxloadpermohonan');
Route::get('permohonan/checkPermohonan', [PermohonanController::class,'checkPermohonan'])->name('permohonan.checkPermohonan');


Route::get('carian', [KeahlianController::class,'carian'])->name('carian.index');
Route::post('carian', [KeahlianController::class,'search'])->name('carian.search');

Route::get('penerima', [PenerimaController::class,'index'])->name('penerima.index');
Route::post('penerima/semak', [PenerimaController::class,'semak'])->name('penerima.semak');
Route::post('penerima/store', [PenerimaController::class,'store'])->name('penerima.store');

Route::get('laporan', [LaporanController::class,'index'])->name('laporan.index');
Route::get('laporan/ajaxLoadLaporan', [LaporanController::class,'ajaxLoadLaporan'])->name('laporan.ajaxLoadLaporan');


