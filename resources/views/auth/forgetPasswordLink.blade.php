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
									<form action="{{ route('reset.password.post') }}" method="POST">
                                      @csrf
                                      <input type="hidden" name="token" value="{{ $token }}">
               
                                      <div class="form-group row">
                                          <label for="email_address" class="col-md-12 col-form-label text-md-right">Alamat E-mel</label>
                                          <div class="col-md-12">
                                              <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                              @if ($errors->has('email'))
                                                  <span class="text-danger">{{ $errors->first('email') }}</span>
                                              @endif
                                          </div>
                                      </div>
               
                                      <div class="form-group row">
                                          <label for="password" class="col-md-12 col-form-label text-md-right">Katalaluan</label>
                                          <div class="col-md-12">
                                              <input type="password" id="password" class="form-control" name="password" required autofocus>
                                              @if ($errors->has('password'))
                                                  <span class="text-danger">{{ $errors->first('password') }}</span>
                                              @endif
                                          </div>
                                      </div>
               
                                      <div class="form-group row">
                                          <label for="password-confirm" class="col-md-12 col-form-label text-md-right">Sahkan Katalaluan</label>
                                          <div class="col-md-12">
                                              <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                              @if ($errors->has('password_confirmation'))
                                                  <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                              @endif
                                          </div>
                                      </div>
               
                                      <div class="col-md-12 ">
                                          <button type="submit" class="btn btn-primary">
                                              Set Semula Kata Laluan
                                          </button>
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
