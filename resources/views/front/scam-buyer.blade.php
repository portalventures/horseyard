@extends('front.layouts.master')
@section('title', 'Scams Buying | Horseyard')
@section('bodycls', 'cms scam')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
<div id="main">
      <div class="breadcrumbs">
        <div class="container">
          <ul>
            <li><a href="{{URL::to('/')}}">Home</a></li>
            <li>Scam buying</li>
          </ul>
        </div>
      </div>
      <section class="brand-overview scam">
        <div class="container">
          <div class="d-flex">
            <div class="col d-flex justify-content-center flex-col align-items-center">
              <h1 class="page-title-large">Scams buying</h1>
              <p class="text-center">At Horseyard, it is important to us that all of our users have a safe, successful
                                     and enjoyable experience. Whether you are hoping to buy or to sell a horse,
                                     following these tips and guidelines will help you safely navigate our site. List
                                     your horse and find the perfect buyer, or discover the horse that fits your goals
                                     and dreams.</p>
            </div>
          </div>
        </div>
      </section>
      <section class="guide">
        <div class="container">
          <div class="row">
            <div class="col">
              <div class="guide-content-outer">
                <h2 class="title">
                  <div class="d-flex align-items-center">
                    <span class="icon lock"></span> Staying Safe while Using Horseyard
                  </div>
                </h2>
                <div class="guide-content">
                  <ol>
                    <li>When buying or selling a horse online, an in-person meeting should always be arranged in order
                        to examine the horse and to exchange money. It is advisable to also take someone with you when
                        meeting with a seller at their location, your home or workplace. Another safety precaution you
                        can take when answering an ad is to request the poster to produce identity and proof of
                        qualification before meeting with them.
                    </li>
                    <li>Always arrange for a veterinarian to examine a horse before agreeing to a sale. Make sure that
                        the horse in question is the same horse listed in the ad. Inquire after any previous health and
                        soundness issues the horse might have had in the past or is presently dealing with.
                    </li>
                    <li>Be very cautious in how you exchange money for a sale. Never send or wire money to someone you
                        do not know; this includes mailing cheques and using certain payment services. Bidpay, Western
                        Union or Money Gram, for example, have been known to be forms of fund transfer that are favoured
                        by fraudsters.
                    </li>
                    <li>Horseyard does not offer any kind of buyer protection / payment programs. If you receive an
                        email guiding you to refer to buyer protection/payment systems, please disregard the promotion
                        of such services and report it to us.
                    </li>
                    <li>Horseyard does not offer any kind of live chat support. Please be sure to disregard any emails
                        you might receive that contain a live chat link. If you do receive such an email, please be sure
                        to report it to us.
                    </li>
                  </ol>
                </div>
                <h2 class="title">
                  <div class="d-flex align-items-center">
                    <span class="icon warning"></span> Scams to Look Out for
                  </div>
                </h2>
                <div class="guide-content">
                  <ul>
                    <li><strong>Fraudulent Sellers – </strong>Be aware that scammers may try to contact you via text
                                                              messages or phone calls. They may give you a list of
                                                              reasons as to why they are unable to meet in person, but
                                                              continue to ask you about receiving payment. Keep in mind
                                                              that scammers will pose as genuine sellers, post fake ads
                                                              and/or approach you through email or on a social media
                                                              platform. Be aware that scammers may also claim to be
                                                              overseas traveling or have a sudden emergency come up and
                                                              request that payment occur prior to arranging the
                                                              delivery. They may also request that you give the payment
                                                              to a third party because they are traveling or living
                                                              overseas. Always heed warning signs.
                    </li>
                    <li><strong>Fake Ads – </strong>The number of fake ads being placed on classified sites continues to
                                                    increase. If you have knowledge of an ad being fake, please report
                                                    it by clicking the “Flag Ad” button. You can also send the Horse ID
                                                    to our help desk along with the information you have. Before buying
                                                    a horse online, always be sure to do your homework. Request
                                                    references, check identities, inquire after the horse/owner on the
                                                    appropriate breed association site, have your vet examine the horse
                                                    and buy locally if it is possible.
                    </li>
                  </ul>
                  <hr>
                  <h3>Payment Scams</h3>
                  <ul>
                    <li><strong>Western Union Scam – </strong>Never use a money transfer service such as Western Union.
                                                              If a request is made for the money to be sent via western
                                                              union or wire transfer or for the difference to be sent to
                                                              them or their shipper through these means, be aware that
                                                              this may be an attempt to defraud you of your money.
                    </li>
                    <li><strong>False Payment Scam –</strong> If you are contacted by someone claiming that your payment
                                                              was not completed and a request is made for your credit
                                                              card information, this is a scam. Never release any
                                                              personal information or credit card information to someone
                                                              who contacts you claiming to be from the website’s secure
                                                              payment provider.
                    </li>
                  </ul>
                  <p>Above all, use <strong>common sense</strong>. If a deal seems too good to be true, it probably is!
                  </p>
                </div>
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
