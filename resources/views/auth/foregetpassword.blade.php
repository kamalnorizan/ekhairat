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
	<link rel="stylesheet" href="{{ asset('resFront/css/dark.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/css/font-icons.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/css/animate.css') }}" type="text/css" />
	<link rel="stylesheet" href="{{ asset('resFront/css/magnific-popup.css') }}" type="text/css" />

	<link rel="stylesheet" href="{{ asset('resFront/css/custom.css') }}" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Document Title
	============================================= -->
	<title>Reset Katalaluan</title>

</head>

<body class="stretched">

	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Content
		============================================= -->
		<section id="content">
			<div class="content-wrap py-0">

				<div class="section p-0 m-0 h-100 position-absolute" style="background: url('{{ asset('resFront/images/parallax/home/1.jpg') }}') center center no-repeat; background-size: cover;"></div>

				<div class="section bg-transparent min-vh-100 p-0 m-0">
					<div class="vertical-middle">
						<div class="container-fluid py-2 mx-auto">
							<div class="center">
								<a href="{{ url('/') }}"><img src="{{ asset('resFront/images/logo-dark.png') }}" alt="Canvas Logo" style="max-width: 300px"></a>
							</div>

							<div class="card mx-auto rounded-0 border-0" style="max-width: 400px; background-color: rgba(255,255,255,0.93);">
								<div class="card-body" style="padding: 40px;">
									<form id="login-form" name="login-form" class="mb-0" action="{{route('forget.password.post')}}" method="post">
										<h3>Lupa Kata Laluan</h3>
										<p>Sila masukkan email yang telah didaftarkan untuk reset semula katalaluan</p>
										@if(session('message'))
                                            <div class="alert alert-info">
                                                {{ session('message') }}
                                            </div>
                                        @endif
                                        @csrf
                                        @if ($errors->any())
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="alert alert-danger">
                                                    @foreach ($errors->all() as $error)
                                                        {{ $error }}<br>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        @endif
										<div class="row">
											<div class="col-12 form-group">
												<label for="username">Alamat Email:</label>
												<input type="email" id="email" name="email" value="" class="form-control not-dark" />
											</div>
											<div class="col-12 form-group">
												<a class="btn btn-link m-0" style="padding-left:0px!important" href="{{route('index')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
												<button type="submit" class="button button-3d button-black m-0" id="login-form-submit" name="login-form-submit" value="login">Reset Kata Laluan</button>
												<a href="{{route('login')}}" class="float-end">Log Masuk</a>
											</div>
										</div>
									</form>
								</div>
							</div>

							<div class="text-center dark mt-3"><small>&copy; All Rights Reserved by Badan Khairat Surau al-Hidayah.</small></div>
						</div>
					</div>
				</div>

			</div>
		</section><!-- #content end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
	<script src="{{ asset('resFront/js/jquery.js') }}"></script>
	<script src="{{ asset('resFront/js/plugins.min.js') }}"></script>

	<!-- Footer Scripts
	============================================= -->
	<script src="{{ asset('resFront/js/functions.js') }}"></script>
    <script>
        $("#nokp").keyup(function(){
            var s= $("#nokp").val();
            if(s.length == 6){
                $("#nokp").val(s+"-");
            }

            if(s.length == 9){
                $("#nokp").val(s+"-");
            }
        });
    </script>
</body>
</html>
