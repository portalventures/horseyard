@extends('front.layouts.master')
@section('title', 'Traffic*, Horseyard')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('bodycls', 'cms scam')
@section('content')
  <div id="main">
    <div class="breadcrumbs">
      <div class="container">
        <ul>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li>Advertise</li>
        </ul>
      </div>
    </div>
    <section class="brand-overview">
      <div class="container">
        <div class="d-flex">
          <div class="col d-flex justify-content-center flex-col">
            <h1 class="page-title-large">Brand Overview</h1>
            <p>Horseyard is Australia’s premier classifieds site for to buying and selling equine and equine related items. The site features a modern user interface and easy-to-use search tools that provide users with a superior user experience across desktop,
              mobile and tablet devices.</p>
            <p>Our advertising solutions can deliver your marketing message to the right audience at the right time helping you grow your business.</p>
          </div>
          <div class="col brand-image">
            <img src="{{ asset('frontend/images/horseYard-blue-large.png') }}" alt="Brand">
          </div>
        </div>
      </div>
    </section>
    <section class="traffic">
      <div class="container">
        <h2>Traffic*</h2>
        <div class="traffic-blocks">
          <div class="col">
            <span class="icon people"></span>
            <h3 class="count">11,128,650</h3>
            <small class="title">Users</small>
          </div>
          <div class="col">
            <span class="icon pageviews"></span>
            <h3 class="count">7.49M</h3>
            <small class="title">Pageviews</small>
          </div>
          <div class="col">
            <span class="icon time"></span>
            <h3 class="count">5:45</h3>
            <small class="title">Time on site</small>
          </div>
          <div class="col">
            <span class="icon heart-traffic"></span>
            <h3 class="count">70.1%</h3>
            <small class="title">Returning</small>
          </div>
        </div>
      </div>
    </section>
    <section class="demographics">
      <div class="container">
        <h2>Demographics</h2>
        <div class="demographics-outer">
          <div class="demographics-table">
            <div class="demographics-row">
              <div class="col">
                <div class="d-flex">
                  <h3 class="title">Gender</h3>
                  <div class="stats">
                    <div class="stats-block">
                      <span class="icon female"></span>
                      <p>85.3%
                        <span>Female</span>
                      </p>
                    </div>
                    <div class="stats-block">
                      <span class="icon male"></span>
                      <p>17.7%
                        <span>Male</span>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="d-flex">
                  <h3 class="title">Age</h3>
                  <div class="charts">
                    <canvas id="ageBars" width="100%" height="100%"></canvas>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="d-flex">
                  <h3 class="title">Occupation</h3>
                  <div class="charts">
                    <div class="">
                      <canvas id="occupationPie" height="135" width="135"></canvas>
                    </div>
                    <p class="text"><span class="text-red">31.8%</span>&nbsp;Work in horse Industry</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="demographics-outer">
          <div class="demographics-table">
            <div class="demographics-row">
              <div class="col">
                <h3 class="title">Education</h3>
                <div class="charts">
                  <div class="">
                    <canvas id="educationPie" height="135" width="135"></canvas>
                  </div>
                  <p class="text"><span class="text-red">45.3%</span>&nbsp;Completed tertiary studies</p>
                </div>
              </div>
              <div class="col ownership">
                <h3 class="title">Horse Ownership</h3>
                <div class="stats">
                  <div class="stats-block">
                    <div class="grid grid-col-2">
                      <span class="icon horses-orange"></span>
                      <span class="icon horses-orange"></span>
                    </div>
                    <p>43.9%
                      <span>1-2 Horses</span>
                    </p>
                  </div>
                  <div class="stats-block">
                    <div class="grid grid-col-2">
                      <span class="icon horses-black"></span>
                      <span class="icon horses-black"></span>
                      <span class="icon horses-black"></span>
                      <span class="icon horses-black"></span>
                      <span class="icon horses-black"></span>
                      <span class="icon horses-black"></span>
                      <span class="icon horses-black"></span>
                      <span class="icon horses-black"></span>
                    </div>
                    <p>17.6%
                      <span>8+ Horses</span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col">
                <h3 class="title">Geography</h3>
                <div class="statewise-map">
                  <img src="{{ asset('frontend/images/australia-map2.png') }}" alt="Australia">
                  <span class="data WA">9%</span>
                  <span class="data NT">1%</span>
                  <span class="data SA">7%</span>
                  <span class="data QL">23%</span>
                  <span class="data ACT">40%</span>
                  <span class="data VC">18%</span>
                  <span class="data TS">2%</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="offer">
      <div class="container">
        <h2>What We Offer</h2>
        <div class="offer-blocks">
          <div class="col">
            <div class="offer-icon">
              <span class="icon advertising"></span>
            </div>
            <div class="offer-details">
              <h3>Display Advertising</h3>
              <p>Display advertising provides a dynamic way to establish and grow your brand and product awareness. In addition to the standard banner sizes and targeting options available, we also offer enhanced options to ensure your message is delivered
                to the most relevant audience.</p>
            </div>
          </div>
          <div class="col">
            <div class="offer-icon">
              <span class="icon offer-social"></span>
            </div>
            <div class="offer-details">
              <h3>Social Media</h3>
              <p>Get your message across social media with our sponsored posts. Our audience of over 28,000 active Facebook and Twitter followers is highly engaged and are interested in your products, events and services.</p>
            </div>
          </div>
          <div class="col">
            <div class="offer-icon">
              <span class="icon offer-newsletter"></span>
            </div>
            <div class="offer-details">
              <h3>Newsletter</h3>
              <p>Directly reach thousands of engaged members of the equine community through our weekly newsletter with over 60,000 opt in subscribers and an average open rate is over 35%.</p>
            </div>
          </div>
          <div class="col">
            <div class="offer-icon">
              <span class="icon offer-banner"></span>
            </div>
            <div class="offer-details">
              <h3>More than just banners</h3>
              <p>Engage with your target audience through content sponsorships, giveaways, community participation, lead generation and other innovative opportunities.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="award-winner">
      <div class="container">
        <div class="d-flex">
          <span class="icon award-winner"></span>
          <p>HorseYard is a Hitwise Top Ten Award Winner in the Hitwise Lifestyle - Pets and Animals industry website category.</p>
        </div>
      </div>
    </section>
    <section class="contact" id="contact-us">
      <div class="container">
        <h2>Contact</h2>
      </div>
      <div class="form-outer">
        <div class="container">
          <div class="d-flex">
            <div class="col">
            @include('shared.errors')
          <form action="{{ url('contact_enquiry') }}" class="user_signup_form" method="post">
            @csrf
                <div class="form-group">
                  <input type="text" id="fullname" name="fullname" placeholder="Name*" class="form-control">
                </div>
                <div class="form-group">
                  <input type="email" id="email" name="email" placeholder="Email Address*" class="form-control">
                </div>
                <div class="form-group">
                  <input type="number" id="mobile" name="mobile" placeholder="Phone..." class="form-control">
                </div>
                <div class="form-group">
                  <input type="text" id="company" name="company" placeholder="Company..." class="form-control">
                </div>
                <div class="form-group">
                  <textarea name="message" id="message" cols="30" rows="10" placeholder="Message..." class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Get in Touch</button>
              </form>
            </div>
            <div class="col">
              <address>
              <h4>HorseYard Media Contact</h4>
              <p>Jane Doe</p>
              <p>038123564</p>
              <p><a href="mailto:jane.doe@horseyard.com.au">jane.doe@horseyard.com.au</a></p>
            </address>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  
@endsection
@section('js-content')  
  <script type="text/javascript" src="{{ asset('frontend/js/jquery-ui.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/jquery.validate.min.js') }}?v={{ CSS_JS_VER }}"></script>
  <script type="text/javascript" src="{{ asset('frontend/js/additional-methods.min.js') }}?v={{ CSS_JS_VER }}"></script>  
  <script type="text/javascript" src="{{ asset('frontend/js/custom.min.js') }}?v={{ CSS_JS_VER }}"></script>
@endsection
@push('custom-scripts')
  <script type="text/javascript" src="{{ asset('/frontend/custom_js_css/js/index.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('/frontend/js/chart.js') }}?v={{CSS_JS_VER}}"></script>
  <script type="text/javascript" src="{{ asset('/frontend/js/chartjs-plugins-datalabels.js') }}?v={{CSS_JS_VER}}"></script>
@endpush