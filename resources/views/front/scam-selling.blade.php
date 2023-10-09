@extends('front.layouts.master')
@section('title', 'Scams Selling | Horseyard')
@section('bodycls', 'cms scam')
@section('canonical-content')
  <link rel="canonical" href="{{URL::current()}}"/>
@endsection
@section('css-content')  
  <link rel="stylesheet" href="{{ asset('/frontend/css/custom.min.css') }}?v={{ CSS_JS_VER }}">  
  <link rel="stylesheet" href="{{ asset('/frontend/custom_js_css/css/custom.css') }}?v={{ CSS_JS_VER }}"> 
@endsection
@section('content')
  <div id="main"  class="cms scam">
    <div class="breadcrumbs">
      <div class="container">
        <ul>
          <li><a href="{{url('/')}}">Home</a></li>
          <li>Scam selling</li>
        </ul>
      </div>
    </div>
    <section class="brand-overview scam">
      <div class="container">
        <div class="d-flex">
          <div class="col d-flex justify-content-center flex-col align-items-center">
            <h1 class="page-title-large">Scams selling</h1>
            <p class="text-center">At Horseyard, it is important to us that all of our users have a safe, successful and enjoyable experience. Whether you are hoping to buy or to sell a horse, following these tips and guidelines will help you safely navigate our site. List
              your horse and find the perfect buyer, or discover the horse that fits your goals and dreams.</p>
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
                  <span class="icon lock"></span> Safety Guide for Sellers
                </div>
              </h2> 
              <div class="guide-content">
                <ol>
                  <li>When creating your ad, make sure that you choose a secure and unique password for your account.</li>
                  <li>Do a little research before deciding on the selling price for your horse. Compare your horse’s skills, breed, age and experience with the market. Also take into consideration the health of your horse and any ailments he might be suffering
                    from.
                  </li>
                  <li>Safely manage any inquiries you receive from potential buyers. Do not provide them with any personal identification details; such as, license, banking information and credit card information. Always be wary if a buyer offers you an amount
                    considerably more than the asking price, or if he or she requests that you pay for shipping services.</li>
                  <li>Decide how you will handle in-person meetings. In the event that a buyer wishes to see the horse you are selling in person and arrange for a vet check, decide where the meeting should take place. If you do not feel comfortable meeting
                    at your personal residence or theirs, arrange a meeting in a more public location.</li>
                  <li>Be prepared to accept offers. Know how much you are willing to accept for your horse; this includes the minimum price you are willing to negotiate to. Be very cautious and heed any warning signs you might experience. Unfortunately, fraudulent
                    buyers and scams are becoming more and more of a problem for classified ads. Consider the scams listed below and keep them in mind as you receive offers. Remember, if a deal is too good to be true, it probably is!</li>
                  <li>When receiving payment, stay away from money transfer services. Be wary of high pressure tactics to speed up the transaction, and don’t provide financial information without establishing a comfort level with a buyer. Always write down
                    the terms of the deal before completing a transaction.</li>
                </ol>
              </div>
              <h2 class="title">
                <div class="d-flex align-items-center">
                  <span class="icon warning"></span> What to Watch Out for…
                </div>
              </h2>
              <div class="guide-content">
                <h3>Fraudulent Buyers & Enquirers</h3>
                <ul>
                  <li><strong>Buyer Waiting Scams –</strong> This type of scam is carried out over the phone. A seller is contacted by a buyer claiming that, if the seller pays a small fee over the phone with their debit card, they have a buyer waiting to
                    make a purchase immediately. If the seller agrees, they then withdraw as much money as possible from the victim’s account.</li>
                  <li><strong>Foreign Buyers/Agents –</strong> When placing your advertisement, be cautious of scammers that pose as genuine buyers. These scammers will make up stories that they need your help in paying an agent or third party for upfront
                    costs like transportation or insurance. They will also give you a promise of reimbursing you for these costs.</li>
                </ul>
                <p>You should also avoid potential buyers that are willing to make a purchase without seeing the item first; this is especially true for expensive purchases like a horse. The majority of buyers will want to see the horse for themselves, have
                  a vet check and even go for a “test” ride.</p>
                <p>Potential overseas buyers that are interested in making a purchase, despite the availability of a similar prospect in their own country, should also be handled with caution. If the shipping costs far outweigh the amount for the horse itself,
                  you are more than likely dealing with a scam.</p>
                <ul>
                  <li><strong>Specific Personal Details –</strong> You should always be suspicious when a potential buyer is more interested in obtaining your personal information rather than learning more about the horse itself.</li>
                </ul>
                <hr>
                <h3>Phishing Scams</h3>
                <ul>
                  <li><strong>Suspicious Email –</strong> Phishing attempt. Some classified users receive suspicious emails from time to time. These emails will request you to confirm your identity and give account verification. They might even inform you
                    that an ad supposedly posted using your account and was deleted for fraud. These emails are sent by fraudulent people. They are not being sent by Horseyard!</li>
                  <li><strong>Phishing SMS –</strong> Some scammers will try to trick you by sending fake SMS messages that ask you to contact them via email. These messages typically contain a name in the title or an overseas phone number. Within the communication,
                    they will fabricate stories as to why they cannot communicate via phone.</li>
                  <p>They will then offer you several hundred or even thousands of dollars more than your asking price. They “really love and want your horse”, but they prefer to have their shipping agent pick it up. This claim will then be followed with
                    a request to have your PayPal account information, but you will never receive the money. Always try to meet in person when you can to avoid SMS fraud.</p>
                </ul>
                <hr>
                <h3>Payment Scams</h3>
                <ul>
                  <li><strong>Forged Banker’s Cheques –</strong> There are three different types of cheque fraud: counterfeit, forgery and fraudulently altered. When a cheque has been forged, it means that a genuine cheque has been stolen from an innocent
                    customer and was used by a fraudster with a forged signature. In order to avoid this scam, Horseyard advises you to never deliver your horse until the cheque has successfully cleared with your bank.</li>
                  <li><strong>Fake Escrow Services –</strong> This scam involves a buyer suggesting the use of an escrow service to complete a transaction. Do not let the “official” appearance of these sites trick you; these escrow websites are often run
                    by fraudsters.</li>
                  <li><strong>Overpayment Scam –</strong> The scammer will more than likely invent an excuse as to why they are sending you an overpayment; such as, to cover fees, extra shipping costs or human error. The scammer will then request that you
                    refund them the excess amount through an online banking transfer, pre-loaded money card or a wire transfer. Later on, you will discover that the cheque has bounced.</li>
                  <li><strong>Paypal Scam -</strong> A seller is contacted via email by an interested “buyer” or scammer. A suggestion is then made by the scammers to make a payment through the secure payment site PayPal. They will then claim to have transferred
                    the agreed sum into the seller’s PayPal account while they wait to receive the horse, but the money is never deposited.</li>
                  <li><strong>Payment Plan –</strong> A potential buyer that wishes to work out a payment plan with you for your horse may also be up to no good. When this occurs, the buyer will get you to agree to a payment plan only to leave you with the
                    initial payment and disappear with your horse. Horseyard strongly advises you to never agree to a payment plan, regardless of the terms.</li>
                  <li><strong>Western Union –</strong> Avoid any arrangement with a potential buyer that asks for the payment to take place via money order, wire transfer, international funds transfer, pre-loaded card or electronic currency. This may be an
                    attempt to defraud you of your money.</li>
                </ul>
                <p>Above all, use <strong>common sense</strong>. If a deal seems too good to be true, it probably is!</p>
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