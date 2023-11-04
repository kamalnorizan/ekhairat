<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Selamat Datang ke eKhairat Surau al-Hidayah, Bandar Saujana Putra.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
    <link rel="apple-touch-icon" href="favicon.png">
    <link rel="apple-touch-icon" sizes="76x76" href="favicon.png">
    <link rel="apple-touch-icon" sizes="120x120" href="favicon.png">
    <link rel="apple-touch-icon" sizes="152x152" href="favicon.png">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta content="Ace" name="KamalNorizan" />
    <link href="{{ asset('res/assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('res/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ asset('res/assets/plugins/jquery-scrollbar/jquery.scrollbar.css') }}" rel="stylesheet" type="text/css" media="screen" />
    <link href="{{ asset('res/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" media="screen" />
    @yield('headbefore')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
    {{-- <link href="{{ asset('res/assets/plugins/jquery-datatable/media/css/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" /> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('res/assets/plugins/jquery-datatable/extensions/FixedColumns/css/dataTables.fixedColumns.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('res/assets/plugins/datatables-responsive/css/datatables.responsive.css')}}" rel="stylesheet" type="text/css" media="screen"> --}}
    <link href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" media="screen">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link class="main-stylesheet" href="{{ asset('res/pages/css/pages.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .swal-text{
            text-align:center;
        }

        .icon-thumbnail > i.fa{
            font-size: 15px!important;
        }

        @media print
        {
          .noprint {display:none;}
        }

        .dataTables_wrapper .row > div{
            display: flex;
            flex-direction: column;
        }
    </style>
    @yield('head')
</head>
  <body class="fixed-header {{Auth::user()->pinSidebar==1 ? 'sidebar-visible menu-pin' : ''}} ">
    <!-- BEGIN SIDEBPANEL-->
    <nav class="page-sidebar" data-pages="sidebar">
      <!-- BEGIN SIDEBAR MENU TOP TRAY CONTENT-->
      <div class="sidebar-overlay-slide from-top" id="appMenu">
        {{-- <div class="row">
          <div class="col-xs-6 no-padding">
            <a href="#" class="p-l-40"><img src="assets/img/demo/social_app.svg" alt="socail">
            </a>
          </div>
          <div class="col-xs-6 no-padding">
            <a href="#" class="p-l-10"><img src="assets/img/demo/email_app.svg" alt="socail">
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 m-t-20 no-padding">
            <a href="#" class="p-l-40"><img src="assets/img/demo/calendar_app.svg" alt="socail">
            </a>
          </div>
          <div class="col-xs-6 m-t-20 no-padding">
            <a href="#" class="p-l-10"><img src="assets/img/demo/add_more.svg" alt="socail">
            </a>
          </div>
        </div> --}}
      </div>
      <!-- END SIDEBAR MENU TOP TRAY CONTENT-->
      <!-- BEGIN SIDEBAR MENU HEADER-->
      <div class="sidebar-header">
        <img src="{{ asset('res/assets/img/logo_white.png') }}" alt="logo" class="brand" data-src="{{ asset('resFront/images/logo-dark.png') }}" data-src-retina="{{ asset('res/assets/img/logo_white.png') }}"  height="40">
        <div class="sidebar-header-controls">
          {{-- <button aria-label="Toggle Drawer" type="button" class="btn btn-icon-link invert sidebar-slide-toggle m-l-20 m-r-10" data-pages-toggle="#appMenu">
            <i class="pg-icon">chevron_down</i>
          </button> --}}
          <button aria-label="Pin Menu" type="button" id="pinBtn" class="btn btn-icon-link invert d-lg-inline-block d-xlg-inline-block  d-md-inline-block d-sm-none d-none float-end" data-toggle-pin="sidebar">
            <i class="pg-icon"></i>
          </button>
        </div>
      </div>
      <!-- END SIDEBAR MENU HEADER-->
      <!-- START SIDEBAR MENU -->
      @include('layouts.sidebar')
      <!-- END SIDEBAR MENU -->
    </nav>
    <!-- END SIDEBAR -->
    <!-- END SIDEBPANEL-->
    <!-- START PAGE-CONTAINER -->
    <div class="page-container ">
      <!-- START HEADER -->
      <div class="header ">
        <!-- START MOBILE SIDEBAR TOGGLE -->
        <a href="#" class="btn-link toggle-sidebar d-lg-none pg-icon btn-icon-link" data-toggle="sidebar">
      		menu</a>
        <!-- END MOBILE SIDEBAR TOGGLE -->
        <div class="">
          <div class="brand inline   ">
            <img src="{{ asset('res/assets/img/logo-dark.png') }}" alt="logo" data-src="{{ asset('res/assets/img/logo-dark.png') }}" data-src-retina="{{ asset('res/assets/img/logo-dark.png') }}"  height="40">
          </div>
        </div>
        <div class="d-flex align-items-center">
          <!-- START User Info-->
          <div class="dropdown pull-right d-lg-block d-none">
            <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="profile dropdown">
              <span class="thumbnail-wrapper d32 circular inline">
      					<img src="{{ asset('res/assets/img/profiles/avatar.jpg') }}" alt="" data-src="{{ asset('res/assets/img/profiles/avatar.jpg') }}"
      						data-src-retina="{{ asset('res/assets/img/profiles/avatar_small2x.jpg') }}" width="32" height="32">
      				</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
              <a href="#" class="dropdown-item"><span>Hi  <b>{{Auth::user()->name}},</b></span></a>
              <div class="dropdown-divider"></div>
              {{-- <a href="{{ route('user.profil') }}" class="dropdown-item">Profil</a> --}}
              {{-- <a href="#" class="dropdown-item">Your Activity</a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">Features</a>
              <a href="#" class="dropdown-item">Help</a>
              <a href="#" class="dropdown-item">Settings</a> --}}
              <a href="#" class="logoutBtn dropdown-item">Log Keluar</a>
              {{-- <div class="dropdown-divider"></div>
              <span class="dropdown-item fs-12 hint-text">Last edited by David<br />on Friday at 5:27PM</span> --}}
            </div>
          </div>
          <!-- END User Info-->
          {{-- <a href="#" class="header-icon m-l-5 sm-no-margin d-inline-block" data-toggle="quickview" data-toggle-element="#quickview">
            <i class="pg-icon btn-icon-link">menu_add</i>
          </a> --}}
        </div>
      </div>
      <!-- END HEADER -->
      <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper ">
        <!-- START PAGE CONTENT -->
        <div class="content ">
          <!-- START JUMBOTRON -->
          <div class="jumbotron noprint" data-pages="parallax">
            <div class=" container-fluid   container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="row">
                    <div class="col-6">
                        <div class="inner">
                          <ol class="breadcrumb noprint">
                            @yield('breadcrumb')
                          </ol>
                        </div>
                    </div>
                    <div class="col-6 pt-3">
                        @yield('actions')
                    </div>
                </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class=" container-fluid container-fixed-lg">
            <div class="row">
                <div class="col-md-12">
                    @include('flash::message')
                </div>
            </div>
            @yield('content')
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
        <!-- START COPYRIGHT -->
        <!-- START CONTAINER FLUID -->
        <!-- START CONTAINER FLUID -->
        <div class=" container-fluid  container-fixed-lg footer">
          <div class="copyright sm-text-center">
            <p class="small-text no-margin pull-left sm-pull-reset">
              Copyrights © 2024 All Rights Reserved by BKKSAH..
              <span class="hint-text m-l-15">eKhairat BKKSAH v01.00</span>
            </p>
            {{-- <p class="small no-margin pull-right sm-pull-reset">
              Hand-crafted <span class="hint-text">&amp; made with Love</span>
            </p> --}}
            <div class="clearfix"></div>
          </div>
        </div>
        <!-- END COPYRIGHT -->
      </div>
      <!-- END PAGE CONTENT WRAPPER -->
    </div>
    <!-- END PAGE CONTAINER -->
    <!--START QUICKVIEW -->
    <form action="{{route('logout')}}" method="post" id="logoutForm">@csrf</form>
    <!-- END OVERLAY -->
    <!-- BEGIN VENDOR JS -->
    <script src="{{ asset('res/assets/plugins/pace/pace.min.js') }}" type="text/javascript"></script>
    <!--  A polyfill for browsers that don't support ligatures: remove liga.js if not needed-->
    <script src="{{ asset('res/assets/plugins/liga.js') }}" type="text/javascript"></script>
    <script src="{{ asset('res/assets/plugins/jquery/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('res/assets/plugins/modernizr.custom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('res/assets/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('res/assets/plugins/popper/umd/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('res/assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('res/assets/plugins/jquery/jquery-easy.js') }}" type="text/javascript"></script>
    <script src="{{ asset('res/assets/plugins/jquery-unveil/jquery.unveil.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('res/assets/plugins/jquery-ios-list/jquery.ioslist.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('res/assets/plugins/jquery-actual/jquery.actual.min.js') }}"></script>
    <script src="{{ asset('res/assets/plugins/jquery-scrollbar/jquery.scrollbar.min.j') }}s"></script>
    {{-- <script src="{{ asset('res/assets/plugins/jquery-validation/js/jquery.validate.js')}}" type="text/javascript"></script> --}}

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>
    <script src="{{ asset('res/assets/plugins/jquery-validation/js/localization/messages_my.js')}}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('res/assets/plugins/select2/js/select2.full.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('res/assets/plugins/classie/classie.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.4.0/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="{{ asset('res/pages/js/pages.js') }}"></script>
    <script src="{{ asset('res/assets/js/scripts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/loading/waitMe.js') }}"></script>
    <script>
        checkPermohonan();
        $('.logoutBtn').click(function (e) {
            e.preventDefault();
            $('#logoutForm').submit();
        });

        $('#pinBtn').click(function (e) {
            e.preventDefault();
            if($('body').hasClass('menu-pin')){
                var pin = 0;
            }else{
                var pin = 1;
            }
            $.ajax({
                method: "POST",
                url: "{{route('home.updatePinAjax')}}",
                data: {
                    pin: pin,
                    _token: "{{csrf_token()}}"
                },
                dataType: "json",
                success: function (response) {

                }
            });
        });

        function checkPermohonan(){
            $.ajax({
                type: "get",
                url: "{{route('permohonan.checkPermohonan')}}",
                dataType: "json",
                success: function (response) {
                    $('#pembaharuanCount').html(response.bayaran);
                    $('#permohonanCount').html(response.permohonan);
                }
            });
        }

        $('body').on('classChange', function() {
            alert('test');
        });
    </script>
    @yield('script')
  </body>
</html>
