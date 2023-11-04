<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
	============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700|Poppins:300,400,500,600,700|PT+Serif:400,400i&display=swap" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/css/bootstrap.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/style.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/css/swiper.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/css/dark.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/css/font-icons.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/css/animate.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/css/magnific-popup.css') }}" type="text/css" />

	<link rel="stylesheet" href="{{ asset('resFront/css/custom.css') }}" type="text/css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJM-5JyfIu6GYnLx3r8lLAYrXfOHVp160&libraries=places"></script>
    <link rel="stylesheet" href="{{ asset('js/loading/waitMe.css') }}" type="text/css" />

	<!-- Document Title
	============================================= -->
	<title>Selamat Datang ke eKhairat Surau al-Hidayah, Bandar Saujana Putra.</title>
    <style>
        .divider{
            margin: 1rem auto!important;
        }

        ul.fa-ul li i {
            margin-right: 5px;
            color: #ffa200;
        }

        .alert>button.close{
            position: absolute;
            top: 0;
            right: 0;
            z-index: 2;
            padding: 1.25rem 1rem!important;
            box-sizing: content-box;
            width: 1em;
            height: 1em;
            padding: .25em .25em;
            color: #000;
            border: 0;
            border-radius: .25rem;
            opacity: .5;
            background-color: transparent!important;
        }

    </style>
    @yield('head')
</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header" class="full-header transparent-header border-full-header header-size-custom" data-sticky-shrink="false" data-sticky-class="secondary-color">
			<div id="header-wrap">
				<div class="container">
					<div class="header-row">
						<div id="logo">
                            <a href="{{ url('/') }}" class="standard-logo" data-dark-logo="{{ asset('resFront/images/logo-dark.png') }}"><img src="{{ asset('resFront/images/logo.png') }}" alt="Canvas Logo"></a>
                            <a href="{{ url('/') }}" class="retina-logo" data-dark-logo="{{ asset('resFront/images/logo-dark@2x.png') }}"><img src="{{ asset('resFront/images/logo@2x.png') }}" alt="Canvas Logo"></a>
                        </div>

						<div id="primary-menu-trigger">
							<svg class="svg-trigger" viewBox="0 0 100 100"><path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path><path d="m 30,50 h 40"></path><path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path></svg>
						</div>

						@include('layouts.frontTopbar')
					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>

		</header><!-- #header end -->
        @yield('header')
		<!-- Content
		============================================= -->
		<section id="content">
            {{-- @if(session()->has('msg')) --}}
            <div class="container">
                <div class="content-wrap" style="padding-top: 10px!important;padding-bottom: 0px!important; margin-bottom: -80px">
                    <div class="row clearfix">
                        <div class="col-md-12">
                            @include('flash::message')
                        </div>
                    </div>
                </div>
            </div>
            {{-- @endif --}}
			@yield('content')
		</section><!-- #content end -->
        @php
            $today = Carbon\Carbon::now()->toDateString();
            $dailyVisits = DB::table('tblcounter')
                               ->where('tarikh', $today)
                               ->count('ip_address');
            
            // Weekly Visits
            $weekStartDate = Carbon\Carbon::now()->subWeek()->toDateString();
            $weekEndDate = Carbon\Carbon::now()->toDateString();
            $weeklyVisits = DB::table('tblcounter')
                               ->whereBetween('tarikh', [$weekStartDate, $weekEndDate])
                               ->count('ip_address');
            
            // Monthly Visits
            $monthStartDate = Carbon\Carbon::now()->startOfMonth()->toDateString();
            $monthEndDate = Carbon\Carbon::now()->endOfMonth()->toDateString();
            $monthlyVisits = DB::table('tblcounter')
                                ->whereBetween('tarikh', [$monthStartDate, $monthEndDate])
                                ->count('ip_address');
        @endphp
        
        
		<!-- Footer
		============================================= -->
		<footer id="footer" class="dark">
			<div class="container">

				<!-- Footer Widgets
				============================================= -->
				<div class="footer-widgets-wrap">

					<div class="row col-mb-50">
						<div class="col-md-2">
                            <div class="widget clearfix">
                                <img src="{{ asset('resFront/images/logo-dark.png') }}" width="100%" alt="Image" class="footer-logo" style="margin-bottom: 5px; max-width: 150px">
                                <small><strong>Surau al-Hidayah</strong>, <br>Bandar Saujana Putra<br>
                                Jalan SP 7/2 42610 Jenjarom, Selangor</small>
                            
                            </div>
                            
						</div>
						<div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="text-center">Hubungi Kami</h4>
                                </div>
                           
                                <div class="col-md-6">
                                    <ul class="fa-ul">
                                        <li>
                                          <i class="fa-li fa fa-phone"></i> IMAM USTAZ SAMAD <br>
                                          019 260 7323<br><br>
                                        </li>
                                        <li>
                                          <i class="fa-li fa fa-phone"></i> EN. SUHAIMI <br>
                                          016 287 4840<br><br>
                                        </li>
                                        <li>
                                          <i class="fa-li fa fa-phone"></i> EN ZAHARI<br>
                                          012 671 5013<br><br>
                                        </li>
                                      </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="fa-ul">
                                        <li>
                                          <i class="fa-li fa fa-phone"></i> EN EZZUL CAFFI <br>
                                          012 311 5754<br><br>
                                        </li>
                                        <li>
                                          <i class="fa-li fa fa-phone"></i> EN NIK MOHD RIDZUAN <br>
                                          011 2199 9914<br><br>
                                        </li>
                                      </ul>
                                      
                                </div>
                                
                            </div>
						</div>
                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-0">Jumlah Pelawat</h4>
                                    <table class="table">
                                        <tr>
                                            <td><strong>Hari Ini :</strong></td>
                                            <td  align="right">{{$dailyVisits}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Minggu Ini :</strong></td>
                                            <td  align="right">{{$weeklyVisits}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Bulan Ini :</strong></td>
                                            <td align="right">{{$monthlyVisits}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            Surau al-Hidayah
                            Bandar Saujana Putra
                            <div class="d-flex justify-content-center justify-content-md-start mt-2">
									<i class="fa fa-envelope"></i>&nbsp;bkksahbsp@gmail.com
							</div>
                            <div class="d-flex justify-content-center justify-content-md-start mt-2">
									<i class="fa fa-envelope"></i>&nbsp;adminbkksah@ekhairatsahbsp.com
							</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mt-3">
                                        <img src="{{ asset('images/banklogo.png') }}" class="" alt="" style="max-width: 250px">

                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h4 style="margin-bottom: 5px">Online Transfer</h4>
                                        Sumbangan Badan Khairat Kematian<br>
                                        <strong>SURAU AL-HIDAYAH</strong><br>
                                        Kuwait Finance House<br>
                                        Bandar Saujana Putra.<br>
                                        (No Akaun : 017141001508)
                                </div>
                            </div>

                        </div>
                        
					</div>

				</div><!-- .footer-widgets-wrap end -->

			</div>

			<!-- Copyrights
			============================================= -->
			<div id="copyrights">
				<div class="container">

					<div class="row col-mb-30">

						<div class="col-md-6 text-center text-md-start">
							Copyrights &copy; 2024 All Rights Reserved by BKKSAH.<br>
							<div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>
						</div>

						<div class="col-md-6 text-center text-md-end">
							<div class="d-flex justify-content-center justify-content-md-end">
								<a href="https://www.facebook.com/sahbsp" class="social-icon si-small si-borderless si-facebook">
									<i class="icon-facebook"></i>
									<i class="icon-facebook"></i>
								</a>
                                <a href="https://www.instagram.com/suraualhidayahbsp/?hl=en" class="social-icon si-small si-borderless si-instagram">
									<i class="icon-instagram"></i>
									<i class="icon-instagram"></i>
								</a>
							</div>

							<div class="clear"></div>

							<i class="icon-envelope2"></i> adminbkksah@ekhairatsahbsp.com <span class="middot">&middot;</span>
						</div>

					</div>

				</div>
			</div><!-- #copyrights end -->
		</footer><!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
	<script src="{{ asset('resFront/js/jquery.js') }}"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="{{ asset('resFront/js/plugins.min.js') }}"></script>
    <script src="{{ asset('js/loading/waitMe.js') }}"></script>

    <script src="https://cdn.datatables.net/v/dt/dt-1.13.4/b-2.3.6/r-2.4.1/datatables.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="{{ asset('resFront/js/functions.js') }}"></script>
    <style>

    </style>
    <script>
        $('.logoutBtn').click(function (e) {
            e.preventDefault();
            $('#logoutForm').submit();
        });
    </script>
    @yield('script')
</body>
</html>


