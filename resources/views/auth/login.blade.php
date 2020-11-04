<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - Isofttechn Admin</title>
    <meta name="description" content="Free Bootstrap Theme by uicookies.com">
    <meta name="keywords" content="free website templates, free bootstrap themes, free template, free bootstrap, free website template">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,700">
    <link rel="stylesheet" href="frontend/css/styles-merged.css">
    <link rel="stylesheet" href="frontend/css/style.min.css">

   
  </head>
  <body>
  @include('frontend.header')
  

<section class="probootstrap-hero probootstrap-xs-hero probootstrap-hero-colored" 
style='background:#fff !important'>
      <div class="container">
        <div class="row">
          <div class="col-md-8 text-left probootstrap-hero-text item-center lead">
            <h1 class="probootstrap-animate"
             data-animate-effect="fadeIn"
             style='color:#000 !important;'
             >Login</h1>
            
            <form action="{{ route('login') }}" method="post" class="probootstrap-form">
             @csrf

              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" 
                id="email"
                 name="email"
                 value="{{ old('email') }}" 
                 required autofocus
                 >
                 @if ($errors->has('email'))
                      <span class="help-block" role="alert">
                          <strong>{{ $errors->first('email') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="form-group">
                <label for="name">Password</label>
                <input type="password" class="form-control" 
                id="password"
                 name="password"
                 value="{{ old('email') }}" 
                 required autofocus
                 >
                 @if ($errors->has('password'))
                      <span class="help-block" role="alert">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="form-group clearfix mb40">
                    <label for="remember" class="probootstrap-remember">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                      

                    @if (Route::has('password.request'))
                        <a class="probootstrap-forgot" href="{{ route('password.request') }}" target="_blank">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                  </div>
                  

                <div class="form-group">
                <input type="submit" class="btn btn-primary btn-lg" id="submit" name="submit" value="Login">
              </div>
            </form>

          </div>
        </div>
      </div>
    </section>

@include('frontend.footer')

    <script src="frontend/js/scripts.min.js"></script>
    <script src="frontend/js/custom.min.js"></script>
  </body>
</html>