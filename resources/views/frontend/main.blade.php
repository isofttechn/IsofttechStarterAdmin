<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') - Isofttechn Admin</title>
    <meta name="description" content="Free Bootstrap Theme by uicookies.com">
    <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,700">
    <link rel="stylesheet" href="frontend/css/styles-merged.css">
    <link rel="stylesheet" href="frontend/css/style.min.css">

   
  </head>
  <body>
    
    <!-- Fixed navbar -->    
    @include('frontend.header')
    <!-- navbar-fixed-top  -->
    
    
    @yield('content')


@include('frontend.footer')
 
    <!-- Modal login -->
    <!-- <div class="modal fadeInUp probootstrap-animated" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-md vertical-align-center">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-cross"></i></button>
            <div class="probootstrap-modal-flex">
              <div class="probootstrap-modal-figure" style="background-image: url(frontend/img/modal_bg.jpg);"></div>
              <div class="probootstrap-modal-content">


               @include('auth.login')



              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- END modal login -->
    
    <!-- Modal signup -->
    <!-- <div class="modal fadeInUp probootstrap-animated" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
      <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-md vertical-align-center">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-cross"></i></button>
            <div class="probootstrap-modal-flex">
              <div class="probootstrap-modal-figure" style="background-image: url(img/modal_bg.jpg);"></div>
              <div class="probootstrap-modal-content">


              @include('auth.register')


              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->
    <!-- END modal signup -->

    <script src="frontend/js/scripts.min.js"></script>
    <script src="frontend/js/custom.min.js"></script>
  </body>
</html>