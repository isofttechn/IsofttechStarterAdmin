
    
  <nav class="navbar probootstrap-megamenu navbar-default probootstrap-navbar">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{('/')}}" title="ISOFTTECHN">Isofttechn</a>
        </div>

        <div id="navbar-collapse" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="{{('/')}}">Home</a></li>


            <li class="probootstra-cta-button">
              <a  href="https://isofttechn.netlify.app/" class="btn btn-danger" target="_blank">Hire Me</a>
            </li>

            @guest
            <li class="probootstra-cta-button">
              <a href="{{ route('login') }}" class="btn" >
                Log in
              </a>
            </li>
            <li class="probootstra-cta-button last">
              <a href="{{ route('register') }}" class="btn btn-ghost">
                Sign up
              </a>
            </li>
            @else
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                      {{ Auth::user()->name }} <span class="caret"></span>
                  </a>

                  <ul class="dropdown-menu">
                      <li>

                      <a href="{{('/dashboard') }}"
                              >
                              Dashboard
                          </a>

                          <a href="{{('/profile') }}"
                              >
                              Profile
                          </a>

                          <a href="{{ route('logout') }}"
                              onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                              Logout
                          </a>
                          

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              {{ csrf_field() }}
                          </form>
                      </li>
                  </ul>
              </li>
          @endguest

          </ul>
        </div>
      </div>
    </nav>






