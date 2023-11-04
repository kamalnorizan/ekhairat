@extends('layouts.appFront')

@section('head')
<style>

    .toggle-header, .toggle-content {

        font-size: 18px;
        line-height: 24px;
        font-weight: 400;
    }

    .toggle-active > .toggle-header{
        color: #fd680e;
    }

    .row.clearfix.btnFix{
        --bs-gutter-x: 0rem!important;
    }

    .button.button-full.button-left{
        background-color: #1ABC9C;
    }

    .button.button-full.button-right{
        background-color: #f9a622;
    }

    .button.button-full.button-left:hover{
        background-color: #2b2b2b;
    }

    .button.button-full.button-right:hover{
        background-color: #2b2b2b;
    }


    #blink {
        font-size: 20px;
        font-weight: bold;
        font-family: sans-serif;
        color: #1c87c9;
        transition: 0.4s;
    }
    
    dl, dt, dd, ol, ul, li {
        margin: 5px;
        padding: 2px;
    }

</style>
 <script src="https://www.google.com/recaptcha/api.js"></script>
@endsection

@section('header')
<section id="slider" class="slider-element slider-parallax swiper_wrapper min-vh-60 min-vh-md-100 include-header">
    <div class="slider-inner">
        <div class="swiper-container swiper-parent">
            <div class="swiper-wrapper">
                <div class="swiper-slide dark">
                    <div class="container">
                        <div class="slider-caption slider-caption-center">
                            <h2 data-animate="fadeInUp">Selamat Datang</h2>
                            <p class="d-xs-block mt-2 bg-white text-black" data-animate="fadeInUp" data-delay="200">eKhairat Surau al-Hidayah, Bandar Saujana Putra. <br> </p>
                            <p class="d-xs-block mt-2 text-black" data-animate="fadeInUp" data-delay="200"><button type="button" class="btn btn-lg btn-warning semakKeahlianBtn">Semak/Daftar Keahlian</button> </p>
                        </div>
                    </div>
                    <div class="video-wrap no-placeholder" >
                        <video id="slide-vid" poster="{{ asset('resFront/images/videos/explore-poster.jpg') }}"  preload="auto" loop autoplay muted playsinline>
                            <source src='{{ asset('/images/Khairat (1).mp4') }}' type='video/mp4' />
                        </video>
                        <div class="video-overlay" style="background-color: rgba(0,0,0,0.2);"></div>
                    </div>
                </div>
                <div class="swiper-slide ">
                    <div class="container">
                        <div class="slider-caption slider-caption-center">
                            <h2 data-animate="fadeInUp">Memo 2024/2025</h2>
                            <p class="d-xs-block bg-white text-black" data-animate="fadeInUp" data-delay="200">Perubahan Manfaat Polisi Badan Khairat Kematian (BKK SAHBSP) Tahun 2024-2025 Surau al-Hidayah Bandar Saujana Putra</p>
                            <p class="d-xs-block mt-2 text-black" data-animate="fadeInUp" data-delay="200"><button type="button"  data-toggle="modal" data-target="#memo2023" class="btn btn-lg btn-warning">Baca Selanjutnya</button> </p>
                        </div>
                    </div>

                    <div class="swiper-slide-bg" style="background-image: url('{{ asset('resFront/images/slider/swiper/1.jpg') }}');"></div>
                </div>
                <div class="swiper-slide ">
                    <div class="container">
                        <div class="slider-caption slider-caption-center">
                            <h2 data-animate="fadeInUp">Maklumat Penting</h2>
                            <p class="d-xs-block mt-2 text-black" data-animate="fadeInUp" data-delay="200"><button type="button"   data-toggle="modal" data-target="#maklumatPenting" class="btn btn-lg btn-warning">Baca Selanjutnya</button> </p>
                        </div>
                    </div>
                    <div class="swiper-slide-bg" style="background-image: url('{{ asset('resFront/images/slider/swiper/3.jpg') }}'); background-position: center top;"></div>
                </div>
            </div>
            <div class="slider-arrow-left"><i class="icon-angle-left"></i></div>
            <div class="slider-arrow-right"><i class="icon-angle-right"></i></div>
        </div>

        <a href="#" data-scrollto="#content" data-offset="100" class="one-page-arrow dark"><i class="icon-angle-down infinite animated fadeInDown"></i></a>

    </div>
</section>
<div class="row clearfix btnFix" style="padding: 0px!important; height: 170px"">
    <div class="col-md-6">
        <button type="button" class="button button-full button-left center text-end" data-toggle="modal" data-target="#memo2023">
            <div class="container clearfix">
                MEMO 2024/2025 <strong>Klik di sini</strong> <i class="icon-caret-right" style="top:4px;"></i>
            </div>
        </button>
    </div>
    <div class="col-md-6">
        <button type="button" class="button button-full button-right center text-end" data-toggle="modal" data-target="#maklumatPenting">
            <div class="container clearfix">
                MAKLUMAT PENTING <strong>Klik di sini</strong> <i class="icon-caret-right" style="top:4px;"></i>
            </div>
        </button>
    </div>
</div>

@endsection
@section('content')

<div class="content-wrap" style="padding: 0px!important;">
    <div class="row clearfix align-items-stretch">

        <div class="col-lg-3 col-md-6 dark center col-padding" style="background-color: #515875;">
            <i class="i-plain i-xlarge mx-auto icon-line2-users"></i>
            <div class="counter counter-lined"><span data-from="100" data-to="{{$keahlian}}" data-refresh-interval="50" data-speed="2000"></span></div>
            <h5>KELUARGA</h5>
        </div>

        <div class="col-lg-3 col-md-6 dark center col-padding" style="background-color: #576F9E;">
            <i class="i-plain i-xlarge mx-auto icon-user"></i>
            <div class="counter counter-lined"><span data-from="100" data-to="{{$ahli}}" data-refresh-interval="100" data-speed="2500"></span></div>
            <h5>AHLI</h5>
        </div>

        <div class="col-lg-3 col-md-6 dark center col-padding" style="background-color: #6697B9;">
            <i class="i-plain i-xlarge mx-auto icon-line2-directions"></i>
            <div class="counter counter-lined"><span data-from="10" data-to="{{$penerima->count()}}" data-refresh-interval="25" data-speed="3500"></span></div>
            <h5>TELAH DIURUSKAN</h5>
        </div>

        <div class="col-lg-3 col-md-6 dark center col-padding" style="background-color: #88C3D8;">
            <i class="i-plain i-xlarge mx-auto icon-line2-layers"></i>
            <div class="counter counter-lined"><span data-from="60" data-to="150" data-refresh-interval="30" data-speed="2700"></span>K</div>
            <h5>JUMLAH KUTIPAN</h5>
        </div>

    </div>
    <section id="mengenai" class="page-section mt-5" data-onepage-settings='{"offset":140,"speed":"1500","easing":"easeInOutExpo"}'>

        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-12">
                    <div class="heading-block">
                        <h1>Syarat Penyertaan Badan Khairat Kematian Surau al-Hidayah(BKKSAH),  Bandar Saujana Putra.</h1>
                    </div>
                </div>
            </div>
            <div class="row align-items-top mb-3">
                <div class="col-md-6">
                    <h5>Sumbangan yuran tahunan tetap 1 keluarga</h5>
                        RM 50.00 ( suami , isteri-1 & anak-anak sahaja ).
                </div>
                <div class="col-md-6">
                    <h5>Kaedah pilihan sumbangan</h5>
                        <span><i class="fa fa-check"></i> RM 50.00 - setahun sekali</span> <br>
                        <span class="text-success"><i class="fa fa-check"></i> RM 100.00 - 2 tahun sekali.</span>
                </div>
                <div class="col-md-12">
                   <div class="divider divider-center"><i class="icon-cloud"></i></div>
                </div>
                <div class="col-lg-6">
                    <h5>Syarat-syarat Penyertaan</h5>
                    <ul>
                        <li>Warganegara Malaysia.</li>
                        <li>Terbuka kepada orang Islam yang bermastautin di dalam qaryah surau-surau & Masjid sekitar Bandar Saujana Putra dan Bandar Rimbayu.</li>
                        <li>Seorang ahli dimestikan membayar yuran penyertaan dan pembaharuan setiap tahun mengikut tempoh yang akan ditetapkan yang kebiasaan bermula pertengahan bulan September hingga Disember . Pengumuman akan dibuat melalui sosial media dan banner-banner untuk makluman seluruh ahli qaryah.</li>
                        <li>Terbuka kepada orang Seorang ahli dimestikan membayar yuran penyertaan dan pembaharuan setiap tahun mengikut tempoh yang akan ditetapkan yang kebiasaan bermula pertengahan bulan September hingga Disember . Pengumuman akan dibuat melalui sosial media dan banner-banner untuk makluman seluruh ahli qaryah.</li>
                        <li>Keahlian khairat kematian wajib/perlu diperbaharui setiap tahun apabila tamat tempohnya ( 01 Januari sehingga 31 Disember )</li>
                        <li>Kaedah pendaftaran dan bayaran secara ONLINE @ atas talian yang dibuat sendiri oleh ahli telah pun di laksanakan sejak tahun 2021 akibat pandemik Covid.19 dan akan terus digunakan pada masa akan datang.</li>
                    </ul>
                    <button type="button"  data-toggle="modal" data-target="#memo2023" class="btn btn-lg btn-warning"> Klik di sini untuk Syarat Keahlian Lengkap</button>
                        
                </div>

                <div class="col-lg-6 align-self-end">

                    <div class="position-relative overflow-hidden">
                        <img src="{{ asset('resFront/images/services/main-fbrowser.png') }}" data-animate="fadeInUp" data-delay="100" alt="Chrome">
                        {{-- <img src="{{ asset('resFront/images/services/main-fmobile.png') }}" style="top: 0; left: 0; min-width: 100%; min-height: 100%;" data-animate="fadeInUp" data-delay="400" alt="iPhone" class="position-absolute"> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="pengumuman" class="page-section parallax dark mb-0 skrollable skrollable-between" data-onepage-settings="{"offset":0,"speed":"1500","easing":"easeInOutExpo"}" style="background-image: url('{{ asset("resFront/images/services/home-testi-bg.jpg") }}'); padding: 100px 0;" data-bottom-top="background-position:0px 300px;" data-top-bottom="background-position:0px -300px;">
        <div class="fancy-title title-center title-border">
            <h3>Maklumat Kematian</h3>
        </div>

        <div id="oc-images" class="owl-carousel  carousel-widget" data-loop="true" data-nav="false" data-autoplay="4000" data-pagi="false" data-items-xs="1" data-items-sm="2" data-items-lg="3" data-items-xl="4">
            @foreach ($penerimaSlide as $terima)
                <div class="oc-item text-center">
                    <strong>{{strtoupper($terima->nama)}}</strong>
                    <br><small><i class="fa fa-calendar"></i>&nbsp;{{Carbon\Carbon::parse($terima->tarikhmeninggal)->isoFormat('LL')}}</small>
                    <br><small><i class="fa fa-map-pin"></i>&nbsp;{{$terima->kubur != '' ? $terima->kubur : 'N/A'}}</small>
                    <br><span class="badge {{$terima->status == '1' ? 'bg-success ' : 'bg-warning'}} rounded-pill">{{$terima->status == '1' ? 'Ahli' : 'Bukan Ahli'}}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section id="co" class="page-section" data-onepage-settings="{'offset':0,'speed':'1500','easing':'easeInOutExpo'}" >
        <div class="container  clearfix align-items-stretch"  >
            <div class="heading-block topmargin-lg center">
                <h2>Kelebihan BKKSAH</h2>
                <span class="mx-+">Alhamdulillah BKKK Surau Al Hidayah Bandar Saujana Putra (SAHBSP) bersepakat meneruskan tabung khairat kematian untuk kali -2 bersama dengan seluruh qaryah BSP berdasarkan konsep takaful & taawun. Pengurusan jenazah serta pampasan manfaat kematian akan di uruskan sendiri oleh pasukan BKKK SAHBSP yang bernaung di bawah Surau Al Hidayah.</span>
            </div>

            <div class="row align-items-center col-mb-50 mb-4">
                <div class="col-lg-4 col-md-6">

                    <div class="feature-box flex-md-row-reverse text-md-end" data-animate="fadeIn">
                        <div class="fbox-icon">
                            <a href="#"><i class="icon-line-heart"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Fardhu Kifayah</h3>
                            <p>Melaksanakan tuntutan fardhu kifayah kepada seluruh ahli qaryah Bandar Saujana Putra & Bandar Rimbayu..</p>
                        </div>
                    </div>

                    <div class="feature-box flex-md-row-reverse text-md-end mt-5" data-animate="fadeIn" data-delay="200">
                        <div class="fbox-icon">
                            <a href="#"><i class="icon-cloud1"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Organisasi Badan Khairat</h3>
                            <p>Mewujudkan satu organisasi badan khairat yg tersusun, cekap & berintegriti.</p>
                        </div>
                    </div>

                    <div class="feature-box flex-md-row-reverse text-md-end mt-5" data-animate="fadeIn" data-delay="400">
                        <div class="fbox-icon">
                            <a href="#"><i class="icon-line-layers"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Pusat Kebajikan dan Perkhidmatan</h3>
                            <p>Menjadikan surau Al Hidayah sebagai pusat pembudayaan kerja-kerja kebajikan dan perkhidmatan kepada masyarakat sekitar</p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4 d-md-none d-lg-block text-center">
                    <img src="{{ asset('resFront/images/services/iphone7.png') }}" alt="iphone 2">
                </div>

                <div class="col-lg-4 col-md-6">

                    <div class="feature-box" data-animate="fadeIn">
                        <div class="fbox-icon">
                            <a href="#"><i class="icon-boxes"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Takaful dan Taawun</h3>
                            <p>Membantu meringankan bebanan waris dengan konsep Takaful serta taawun dan pengurusan jenazah yang lebih efisyen.</p>
                        </div>
                    </div>

                    <div class="feature-box mt-5" data-animate="fadeIn" data-delay="200">
                        <div class="fbox-icon">
                            <a href="#"><i class="icon-line-check"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Efisyen dan Produktif</h3>
                            <p>Menguruskan tabungan ahli & jenazah ke arah yg lebih efisyen dan produktif.</p>
                        </div>
                    </div>

                    <div class="feature-box mt-5" data-animate="fadeIn" data-delay="400">
                        <div class="fbox-icon">
                            <a href="#"><i class="icon-eye"></i></a>
                        </div>
                        <div class="fbox-content">
                            <h3>Visi</h3>
                            <p>Memantapkan institusi Surau sebagai Pusat Modal Insan Masyarakat.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section id="carta" class="page-section" data-onepage-settings="{"offset":140,"speed":"1500","easing":"easeInOutExpo"}">
        <div class="row clearfix align-items-stretch">
            <div class="col-lg-12 center col-padding">
                <div class="fancy-title title-center title-border">
                    <h3>CARTA ORGANISASI</h3>
                </div>
                <div class="center bottommargin">
                    <img src="{{ asset('/images/carta.jpg') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </section>



    <section id="semakKeahlian" class="page-section parallax mb-0 skrollable skrollable-between"  style="background-image: url('{{ asset("resFront/images/services/home-testi-absg.jpg") }}'); padding: 50px 0;" data-bottom-top="background-position:0px 600px;" data-top-bottom="background-position:0px -1300px;"  data-onepage-settings="{"offset":140,"speed":"1500","easing":"easeInOutExpo"}">
        <div class="container clearfix">

            <div class="heading-block topmargin-sm center">
                <h3>Semak Keahlian</h3>
            </div>

            <div class="row">
                <div class="col-md-4 offset-md-4 mx-auto align-items-center">
                    <div class="form-group{{ $errors->has('nokp') ? ' has-error' : '' }}">
                        {!! Form::label('nokp', 'No Kad Pengenalan') !!}
                        {!! Form::text('nokp', null, ['class' => 'form-control', 'required' => 'required']) !!}
                        <small class="text-danger">{{ $errors->first('nokp') }}</small>
                    </div>
                    
                    <div class="g-recaptcha" id="g-recaptcha" data-sitekey="6LdoP6EnAAAAAJLBQhIFMxXCgd6IUIzSGg0xaoXJ"></div>
                    <button id="buttonCheck" class="btn btn-success  float-end">Semak</button>
                </div>
            </div>

        </div>
    </section>

    <section id="carta" class="page-section" data-onepage-settings="{"offset":140,"speed":"1500","easing":"easeInOutExpo"}">
        <div class="row clearfix align-items-stretch">
            <div class="col-lg-12 center mt-5">
                <div class="fancy-title title-center title-border ">
                    <h3>SOALAN & JAWAPAN</h3>
                </div>
            </div>
            <div class="col-md-8 offset-md-2">
                <div class="bottommargin">
                    <div class="container">
                        <div id="faqs" class="faqs">
                            <div class="toggle faq faq-marketplace faq-authors" style="">
                                <div class="toggle-header">
                                    <div class="toggle-icon">
                                        <i class="toggle-closed icon-question-sign"></i>
                                        <i class="toggle-open icon-ok-sign"></i>
                                    </div>
                                    <div class="toggle-title">
                                        Berapakah Sumbangan Yuran Tahunan Tetap bagi 1 Keluarga?
                                    </div>
                                </div>
                                <div class="toggle-content" style="display: none;">Sumbangan Yuran Tahunan Tetap bagi 1 Keluarga : RM 50.00 ( Suami , Isteri-1 & Anak-anak sahaja ).</div>
                            </div>

                            <div class="toggle faq faq-authors faq-miscellaneous" style="">
                                <div class="toggle-header">
                                    <div class="toggle-icon">
                                        <i class="toggle-closed icon-question-sign"></i>
                                        <i class="toggle-open icon-ok"></i>
                                    </div>
                                    <div class="toggle-title">
                                        Apakah kaedah sumbangan BKKSAH?
                                    </div>
                                </div>
                                <div class="toggle-content" style="display: none;">Ada 2 kaedah pilihan sumbangan samada setahun atau dua tahun (RM100.00) sekali. Manakala untuk anak yang telah bekerja atau ibubapa ahli hendaklah di daftarkan secara berasingan.</div>
                            </div>

                            <div class="toggle faq faq-miscellaneous" style="">
                                <div class="toggle-header">
                                    <div class="toggle-icon">
                                        <i class="toggle-closed icon-question-sign"></i>
                                        <i class="toggle-open icon-ok"></i>
                                    </div>
                                    <div class="toggle-title">
                                        Bagaimana cara untuk saya mendaftar sebagai ahli BKKSAH?
                                    </div>
                                </div>
                                <div class="toggle-content" style="display: none;">Bagi Pendaftaran Baharu/Pembaharuan Ahli secara cash, Borang Penyertaan yang lengkap perlu diisi & yuran tersebut hendaklah diserah kepada AJK BKKSAH yang terlibat sahaja dan pastikan slip disimpan untuk rujukan. Borang Pendaftaran Keahlian BKKSAH boleh didapati di pautan ini.<br>
                                    Bagi Pendaftaran Baharu/Pembaharuan Ahli yang membuat sumbangan secara "Online Transfer", Anda digalakkan untuk mengisi maklumat keahlian dan maklumat sumbangan secara di atas talian.</div>
                            </div>

                            <div class="toggle faq faq-authors faq-legal faq-itemdiscussion" style="">
                                <div class="toggle-header">
                                    <div class="toggle-icon">
                                        <i class="toggle-closed icon-question-sign"></i>
                                        <i class="toggle-open icon-ok-alt"></i>
                                    </div>
                                    <div class="toggle-title">
                                        Siapakah yang layak mendaftar BKKSAH?
                                    </div>
                                </div>
                                <div class="toggle-content" style="display: none;">Penyertaan sebagai ahli BKKSAH ini terbuka kepada semua penduduk islam seluruh qaryah Bandar Saujana Putra.</div>
                            </div>

                            <div class="toggle faq faq-marketplace faq-authors" style="">
                                <div class="toggle-header">
                                    <div class="toggle-icon">
                                        <i class="toggle-closed icon-question-sign"></i>
                                        <i class="toggle-open icon-ok"></i>
                                    </div>
                                    <div class="toggle-title">
                                        Di manakah perlu menghantar borang wang sumbangan BKKSAH(Bagi Sumbangan Cash)?
                                    </div>
                                </div>
                                <div class="toggle-content" style="display: none;">Borang penyertaan boleh dihantar kepada AJK BKKSAH atau jemaah boleh memasukkan borang daftar beserta wang sumbangan ke dalam tabung putih yang disediakan oleh pihak BKKSAH serta jemaah perlu mencatat nama pada buku log yang telah disediakan. Anda digalakkan untuk membayar secara "Online Transfer" dan mengisi maklumat keahlian serta maklumat sumbangan di atas talian.</div>
                            </div>

                            <div class="toggle faq faq-affiliates faq-miscellaneous" style="">
                                <div class="toggle-header">
                                    <div class="toggle-icon">
                                        <i class="toggle-closed icon-question-sign"></i>
                                        <i class="toggle-open icon-ok"></i>
                                    </div>
                                    <div class="toggle-title">
                                        Bilakah tarikh akhir penyerah borang pendaftaran ahli baru dan penyerahan wang sumbangan BKKSAH?
                                    </div>
                                </div>
                                <div class="toggle-content" style="display: none;">Tarikh akhir serahan pada 28 Februari 2024.</div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- Modal -->
<div class="modal fade" id="memo2023" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color:#1ABC9C">
                <h5 class="modal-title">Memo 2024/2025</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> --}}
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="center" style="padding: 5px;">
                    <iframe src="{{asset('resFront/images/Memo2024.pdf')}}" width="100%" height="600px"></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="maklumatPenting" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color:#f9a622">
                <h3 class="modal-title text-white">Maklumat Penting</h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p></p><li>Tarikh pendaftaran keahlian baharu &amp; pembaharuan 2024/2025 <span style="color:green"><strong>DIBUKA SEHINGGA 28 FEB 2024</strong></span>.</li><p></p>
        <p></p><li>Ahli yang telah menghantar borang secara serahan, sila tunggu pengesahan dari pihak AJK BKKSAH dan semakan secara online hanya boleh dibuat selepas 7 hari dari tarikh tutup permohonan.</li><p></p>
         <p></p><li>Bagi ahli yang telah mengemaskini/mendaftar borang secara online, pengesahan keahlian mengambil masa lebih kurang 7 hari dari tarikh kemaskini.</li><p></p>
          <p></p><li>Sebelum mengisi borang penyertaan dalam talian sila baca <span style="color:red"><strong>syarat-syarat</strong></span> di  pautan ini : <a href="{{asset('resFront/images/Memo2024.pdf')}}" target="_blank"><strong><i class="fa fa-file-pdf-o fa-2x text-danger" aria-hidden="true"></i></strong></a>.</li>
      <p></p>
      <p></p><li>Contoh Salinan Transfer Bank. <a href="{{ asset('images/salinan.jpeg') }}" target="_blank"><strong><img src="{{ asset('images/banklogo.png') }}" height="35" width="150"></strong></a>
      </li><p></p>
      <p></p><li>Bagi ahli lama, sila kemaskini data anda &amp; membuat pembayaran pembaharuan keahlian. Untuk Semakan, sila klik di sini <a class="semakKeahlianBtn"  data-dismiss="modal" id="semakKeahlianBtn" class="btn btn-info"  href="#" data-href="#semakKeahlian">SEMAK KEAHLIAN</a>.
      </li><p></p>
      <p></p><div id="blink" style="opacity: 0;"><span style="color:#F00;"><strong>!!!  INGATAN  !!! <br>
            ➡️PASTIKAN MAKLUMAT DISEMAK SEBELUM DI HANTAR⬅️</strong></span>
            </div>
       <p></p>
        <p><strong>Sumbangan Melalui Online</strong><br>
            Sumbangan Badan Khairat Kematian<br>
            SURAU AL-HIDAYAH<br>
            Kuwait Finance House<br>
            Bandar Saujana Putra.<br>
            <strong>(No Akaun : 017141001508)</strong><!-- <button type="submit" class="btn btn-outline-primary" onclick="salin_akaun()">SALIN NO AKAUN</button> --></p>

    </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-semakKeahlian" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-body text-center">
                Body
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
	var blink = document.getElementById('blink');
	setInterval(function() {
	blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
	}, 1000);

    $('.semakKeahlianBtn').click(function (e) {
        e.preventDefault();
        $('#menuSemakKeahlian').click();
    });

	$("#nokp").keyup(function(){
		var s= $("#nokp").val();
		if(s.length == 6){
			$("#nokp").val(s+"-");
		}

		if(s.length == 9){
			$("#nokp").val(s+"-");
		}
	});

    $('#buttonCheck').click(function (e) {
        e.preventDefault();
        var recaptchaValue = grecaptcha.getResponse();
        
        if($("#nokp").val() == ''){
            $('#nokp').addClass('error');
            $('#nokp').closest('.form-group').find('.text-danger').text('Sila masukkan No. Kad Pengenalan');
            return false;
        }else{
            if (recaptchaValue === "") {  // Check if reCAPTCHA is completed
                alert('Sila lengkapkan proses reCAPTCHA sebelum hantar.');
                return false;  // Stop the execution here
            }
            $('#nokp').removeClass('error');
            $('#nokp').closest('.form-group').find('.text-danger').text('');

            $.ajax({
                type: "post",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                url: "{{route('front.checkKeahlian')}}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'nokp': $("#nokp").val(),
                    'g-recaptcha-response': recaptchaValue
                },
                dataType: "json",
                success: function (response) {
                    if (response.html) { // Check if the 'html' key exists in the response
                        $('#modal-semakKeahlian').find('.modal-body').html(response.html);
                        $('#modal-semakKeahlian').modal('show');
                    } else {
                        // Handle cases where the response does not contain expected data
                        console.warn('Unexpected server response.');
                        grecaptcha.reset();
                        alert('Sila lengkapkan proses reCAPTCHA semula.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Request failed: " + textStatus);
                    // Optionally display a user-friendly error message
                    alert('An error occurred while processing your request. Please try again.');
                }
            });
        }
    });

    $(document).on("click",".ttupModal",function (e) {
        e.preventDefault();
        $(this).closest('.modal').modal('hide');
    });

</script>
@endsection
