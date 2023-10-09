<footer>
  <div class="container">
    <div class="d-flex">
      <div class="col left">
        <div class="footer-logo">
          <img src="{{asset('frontend/images/footer-logo.png')}}" alt="HorseYard">
        </div>
        <p class="copyright">
          Copyright © 2021 Horse Yard.<br>Any reproduction without permission is prohibited.
        </p>
        <div class="social">
          <a href="https://www.facebook.com/HorseYard" target="_blank"><span class="icon facebook"></span></a>
          <!-- <a href="instagram.com"><span class="icon instagram"></span></a> -->
          <a href="https://twitter.com/HorseYard" target="_blank"><span class="icon twitter"></span></a>
        </div>
      </div>
      <div class="col">
        <h4>About Horse Yard</h4>
        <ul class="footer-links">
          <li><a href="{{ url('about') }}">About HorseYard</a></li>
          <!-- <li><a href="{{ url('imprint') }}">Imprint</a></li> -->
          <li><a href="{{ url('privacy-policy') }}">Data Privacy</a></li>
          <li><a href="{{ url('advertise') }}">Advertising</a></li>
        </ul>
      </div>
      <div class="col">
        <h4>QuickNav Horse Market</h4>
        <ul class="footer-links">
          <li><a href="{{ url('horses-for-sale') }}">Horses For Sale</a></li>
          <li><a href="{{ url('horses-for-sale/ponies') }}">Ponies</a></li>
          <li><a href="{{ url('horses-for-sale/foals') }}">Foals</a></li>
          <li><a href="{{ url('field-sex/stallion') }}">Stallions</a></li>
          <li><a href="{{ url('signup')}}">Sellers</a></li>
        </ul>
      </div>
      <div class="col">
        <h4>Your Horse Yard</h4>
        <ul class="footer-links">
          <!-- <li><a href="{{ url('rights_of_withdrawal') }}">Right of withdrawal</a></li> -->
          <li><a href="{{ url('terms-a-conditions') }}">Terms and Conditions</a></li>
          <li><a href="{{ url('help') }}">Help</a></li>
          <li><a href="{{ url('advertise#contact-us') }}">Contact</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>
