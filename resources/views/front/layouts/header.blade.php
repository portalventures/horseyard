<header>
  <div class="container-fluid">
    <div class="d-flex align-items-center flex-sm-wrap">
      <div class="logo">
        <a href="{{url('/')}}">
          <img src="{{ asset('frontend/images/logo.png') }}" alt="HorseYard">
        </a>
      </div>
      <div class="top-navigation">
        <span class="icon menu"></span>
        <ul class="d-flex align-items-center">
          <span class="icon close"></span>
          <li class="has-dropdown">
            <a href="#" class="{{ isset($current_page) && $current_page == 'buy' ? 'active' : ''}}">Buy</a>
            <div class="menu-dropdown">
              <div class="container-fluid">
                <div class="col">
                  <h3 class="submenu-title">Browse</h3>
                  <ul>
                    <li><a href="{{ url('horses-for-sale') }}">Horses for Sale</a></li>
                    <li><a href="{{ url('transport-for-horses') }}">Horse Transport for Sale</a></li>
                    <li><a href="{{ url('saddlery-and-tack') }}">Saddlery and Tack for Sale</a></li>
                    <li><a href="{{ url('property-for-sale') }}">Property for Sale</a></li>
                    <!-- <li><a href="{{ url('search_results') }}/{{''}}">Browse Listing</a></li> -->
                  </ul>
                </div>
                <div class="col">
                  <h3 class="submenu-title">Quick search</h3>
                  <ul>
                    <li><a href="{{ url('search/horses/free') }}">Horses for Free</a></li>
                    <li><a href="{{ url('search/horses/negotiable') }}">Bargain Barges</a></li>
                    <li><a href="{{ url('search/horses/under1000') }}">Under 1000$</a></li>
                    <li><a href="{{ url('search/horses/over5000') }}">Over 5000$</a></li>
                    <li><a href="{{ url('search/horses/last24hours') }}">Last 24 Hours</a></li>
                  </ul>
                </div>
                <div class="col">
                  <h3 class="submenu-title">Safety Center</h3>
                  <ul>
                    <li><a href="{{ url('scams-buying') }}">Scams</a></li>
                    <li><a href="{{ url('safety-centre') }}">Staying Safe</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li class="has-dropdown">
            <a href="#" class="{{ isset($current_page) && $current_page == 'sell' ? 'active' : ''}}">Sell</a>
            <div class="menu-dropdown">
              <div class="container-fluid">
                <div class="col">
                  <h3 class="submenu-title">Selling options</h3>
                  <ul>
                    <li><a  @if(Auth::user())
                              @if(Auth::user()->isUser())
                                href="{{ url('create-listing')}}{{'/'}}{{'horses'}}" 
                              @else
                                href="{{ url('admin/post-ad')}}"
                              @endif
                            @else 
                              href="{{ url('user/login')}}" 
                            @endif>Sell a Horse</a></li>
                    <li><a  @if(Auth::user())
                              @if(Auth::user()->isUser())
                                href="{{ url('create-listing')}}{{'/'}}{{'transport'}}" 
                              @else
                                href="{{ url('admin/post-ad')}}"
                              @endif
                            @else
                              href="{{ url('user/login')}}"
                            @endif>Sell Truck or Trailer</a></li>

                    <li><a @if(Auth::user())
                              @if(Auth::user()->isUser())
                                href="{{ url('create-listing')}}{{'/'}}{{'saddlery'}}" 
                              @else
                                href="{{ url('admin/post-ad')}}"
                              @endif
                            @else 
                              href="{{ url('user/login')}}"
                          @endif>Sell Saddlery and Tack</a></li>
                    <li><a  @if(Auth::user())
                              @if(Auth::user()->isUser())
                                href="{{ url('create-listing')}}{{'/'}}{{'property'}}" 
                              @else
                                href="{{ url('admin/post-ad')}}"
                              @endif
                            @else 
                              href="{{ url('user/login')}}"
                            @endif>Sell Property</a></li>
                  </ul>
                </div>
                <div class="col">
                  <h3 class="submenu-title">My account</h3>
                  <ul>
                    <li><a @if(Auth::user()) href="{{ url('inbox')}}" @else href="{{ url('user/login')}}" @endif>Messages</a></li>
                    <li><a @if(Auth::user()) href="{{ url('manage-ads')}}" @else href="{{ url('user/login')}}" @endif>My Adverts</a></li>
                  </ul>
                </div>
                <div class="col">
                  <h3 class="submenu-title">Safety Center</h3>
                  <ul>
                    <li><a href="{{ url('scams-selling') }}">Scams</a></li>
                    <li><a href="{{ url('safety-centre') }}">Staying Safe</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
          <li><a href="{{ url('advertise') }}" class="{{ isset($current_page) && $current_page == 'advertise' ? 'active' : ''}}">Advertise</a></li>
          <li>
            <a href="{{ url('all-news') }}" class="{{ isset($current_page) && $current_page == 'blogs' ? 'active' : ''}}">Blog</a>
          </li>
          <!-- <li><a href="{{ url('blogs') }}" class="{{ isset($current_page) && $current_page == 'blogs' ? 'active' : ''}}">News</a></li> -->
        </ul>
      </div>
      <div class="notifications-area d-flex align-items-center ml-auto">
        <!-- <div class="notification">
          <span class="icon notification"></span>
          <span class="count">2</span>
        </div> -->

          <div class="authentication">
            @if(Auth::user())
              <div class="dropdown">
                <a href="javascript:void(0);" class="userDropdown">
                  <span class="icon headerUser"></span>
                    @if(Auth()->user()->first_name != "")                    
                      {{Auth()->user()->first_name}} {{Auth()->user()->last_name}}
                    @else
                      {{explode('@',Auth()->user()->email)[0]}}
                    @endif
                  <span class="icon userDropdown"></span>
                </a>
                <div class="dropdown-menu">
                  <a class="dropdown-item user" href="javascript:void(0);">
                    @if(Auth()->user()->first_name != "")
                      {{Auth()->user()->first_name}} {{Auth()->user()->last_name}}
                    @else
                      {{explode('@',Auth()->user()->email)[0]}}
                    @endif
                  </a>
                  @if(Auth()->user()->role == "user")
                    <a class="dropdown-item" href="{{ url('inbox') }}">My Account</a>
                  @else
                    <a class="dropdown-item" href="{{ url('admin/dashboard') }}">Dashboard</a>
                  @endif
                  <a class="dropdown-item" href="{{ url('logout') }}">Log Out</a>
                </div>
              </div>
            @else
              <a href="{{ url('user/login') }}" class="active">Sign in</a>
            @endif
          </div>
          @if(!Auth::user())
            <a href="{{ url('user/login')}}" class="btn btn-primary sellhorse">Sell your horse</a>
          @else
            <a href="{{ url('create-listing')}}" class="btn btn-primary sellhorse">Sell your horse</a>
          @endif
      </div>
    </div>
  </div>
</header>