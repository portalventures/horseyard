<div class="leftNav">
    <ul>
        <li>
            <a href="{{ url('admin/dashboard') }}"
                class="d-flex align-items-center {{ $current_page == 'dashboard' ? 'active' : '' }}">
                <span class="icon dashboard mr-2"></span> Dashboard
            </a>
        </li>
        <!--
    <li>
      <a href="{{ url('homepage-settings') }}" class="{{ $current_page == 'home_page_settings' ? 'active' : '' }} d-flex align-items-center">
        <span class="icon homepage mr-2"></span> Homepage settings
      </a>
    </li>
-->
        <li class="has-submenu">
            <a href="#"
                class="d-flex align-items-center {{ $current_page == 'featured_listing_settings' ||$current_page == 'latest_listing_settings' ||$current_page == 'stallions_listing_settings' ||$current_page == 'blog_settings'? 'opened': '' }} ">
                <span class="icon homepage mr-2"></span> Homepage settings
                <span class="icon arrow ml-auto"></span>
            </a>
            @if ($current_page == 'featured_listing_settings' || $current_page == 'latest_listing_settings' || $current_page == 'stallions_listing_settings' || $current_page == 'blog_settings')
                <ul style="display: block;">
                @else
                    <ul>
            @endif
        <li>
            <a href="{{ url('admin/featured-listing-settings') }}"
                class="{{ $current_page == 'featured_listing_settings' ? 'active' : '' }} d-flex align-items-center justify-content-between">
                Featured Listing Settings
            </a>
        </li>
        <!-- <li>
            <a href="{{ url('admin/latest-listing-settings') }}"
                class="{{ $current_page == 'latest_listing_settings' ? 'active' : '' }} d-flex align-items-center justify-content-between">
                Latest Listing Settings
            </a>
        </li> -->
        <li>
            <a href="{{ url('admin/stallions_listing_settings') }}"
                class="{{ $current_page == 'stallions_listing_settings' ? 'active' : '' }} d-flex align-items-center justify-content-between">
                Stallions Listing Settings
            </a>
        </li>
        <li>
            <a href="{{ url('admin/blog-settings') }}"
                class="{{ $current_page == 'blog_settings' ? 'active' : '' }} d-flex align-items-center justify-content-between">
                Latest Blog Settings
            </a>
        </li>
    </ul>
    </li>
    <li class="has-submenu">
        <a href="#"
            class="d-flex align-items-center {{ $current_page == 'create_ad' ||$current_page == 'admin_ads' ||$current_page == 'edit_ad' ||$current_page == 'pending_ads' ||$current_page == 'approved_ads' ||$current_page == 'reported_ads' ||$current_page == 'blocked_ads'? 'opened': '' }} ">
            <span class="icon ads mr-2"></span> Ads
            <span class="icon arrow ml-auto"></span>
        </a>
        @if ($current_page == 'create_ad' || $current_page == 'admin_ads' || $current_page == 'edit_ad' || $current_page == 'pending_ads' || $current_page == 'approved_ads' || $current_page == 'reported_ads' || $current_page == 'blocked_ads')
            <ul style="display: block;">
            @else
                <ul>
        @endif
    <li>
        <a href="{{ url('admin/post-ad') }}"
            class="{{ $current_page == 'create_ad' ? 'active' : '' }} d-flex align-items-center justify-content-between">
            Post an Ad
        </a>
    </li>
    <li>
        <a href="{{ url('admin/ads') }}"
            class="{{ $current_page == 'admin_ads' ? 'active' : '' }} d-flex align-items-center justify-content-between">
            Ad List
        </a>
    </li>
    <!-- <li>
          <a href="premium-ads.html" class="d-flex align-items-center justify-content-between">
          Premium pending
          <span class="count">0</span>
        </a>
        </li> -->
    <li>
        <a href="{{ url('admin/ads') }}/{{ 'pending' }}"
            class="{{ $current_page == 'pending_ads' ? 'active' : '' }} d-flex align-items-center justify-content-between">pending
            <span class="count">{{ admin_get_pending_approved_blocked_ads_count('pending') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ url('admin/ads') }}/{{ 'approved' }}"
            class="{{ $current_page == 'approved_ads' ? 'active' : '' }} d-flex align-items-center justify-content-between">Approved
            ads
            <span class="count">{{ admin_get_pending_approved_blocked_ads_count('approved') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ url('admin/ads') }}/{{ 'blocked' }}"
            class="{{ $current_page == 'blocked_ads' ? 'active' : '' }} d-flex align-items-center justify-content-between">Blocked
            ads
            <span class="count">{{ admin_get_pending_approved_blocked_ads_count('blocked') }}</span>
        </a>
    </li>
    <li>
        <a href="{{ url('admin/ads') }}/{{ 'reported' }}"
            class="{{ $current_page == 'reported_ads' ? 'active' : '' }} d-flex align-items-center justify-content-between">Reported
            ads
            <span class="count">{{ admin_get_reported_ads_count() }}</span>
        </a>
    </li>
    </ul>
    </li>
    <li class="has-submenu">
        <a href="#"
            class="d-flex align-items-center {{ $current_page == 'blogs' || $current_page == 'create_blog' || $current_page == 'edit_blog' ? 'opened' : '' }} ">
            <span class="icon blog mr-2"></span> Blog
            <span class="icon arrow ml-auto"></span>
        </a>
        @if ($current_page == 'blogs' || $current_page == 'create_blog' || $current_page == 'edit_blog')
            <ul style="display: block;">
            @else
                <ul>
        @endif
    <li>
        <a href="{{ url('admin/all-blogs') }}"
            class="{{ $current_page == 'blogs' || $current_page == 'edit_blog' ? 'active' : '' }} d-flex align-items-center justify-content-between">
            All blogs
        </a>
    </li>
    <li>
        <a href="{{ url('admin/create-blog') }}"
            class="{{ $current_page == 'create_blog' ? 'active' : '' }} d-flex align-items-center justify-content-between">
            Create new blog
        </a>
    </li>
    </ul>
    </li>
    <li class="has-submenu">
        <a href="users.html"
            class="d-flex align-items-center {{ $current_page == 'user_list' || $current_page == 'add_users' ? 'opened' : '' }} ">
            <span class="icon users mr-2"></span> Users
            <span class="icon arrow ml-auto"></span>
        </a>
        @if ($current_page == 'user_list' || $current_page == 'add_users' || $current_page == 'blocked_user_list')
            <ul style="display: block;">
            @else
                <ul>
        @endif
    <li>
        <a href="{{ url('admin/users') }}"
            class="{{ $current_page == 'user_list' ? 'active' : '' }} d-flex align-items-center justify-content-between">
            All users
        </a>
    </li>
    <li>
        <a href="{{ url('admin/add_users') }}"
            class="{{ $current_page == 'add_users' ? 'active' : '' }} d-flex align-items-center justify-content-between">
            Add new user
        </a>
    </li>
    <li>
        <a href="{{ url('admin/blocked-users') }}"
            class="{{ $current_page == 'blocked_user_list' ? 'active' : '' }} d-flex align-items-center justify-content-between">
            Blocked users
        </a>
    </li>
    </ul>
    </li>
    <!--
    <li class="has-submenu">
      <a href="reports.html" class="d-flex align-items-center">
        <span class="icon reports mr-2"></span> Reports
        <span class="icon arrow ml-auto"></span>
      </a>
      <ul>
        <li>
          <a href="payment-reports.html" class="d-flex align-items-center justify-content-between">
          Payment
        </a>
        </li>
        <li>
          <a href="classified-ads.html" class="d-flex align-items-center justify-content-between">
          Classified ads
        </a>
        </li>
        <li>
          <a href="reports-user.html" class="d-flex align-items-center justify-content-between">
          User
        </a>
        </li>
      </ul>
    </li>
-->
    <li>
        <a href="{{ url('admin/contact-enquiries') }}"
            class="{{ $current_page == 'contact_enquiries' ? 'active' : '' }} d-flex align-items-center">
            <span class="icon enquiry mr-2"></span> Contact enquiries
        </a>
    </li>
    <li>
      <a href="{{ url('admin/explore_by_horse')}}" class="{{ $current_page == 'explore_horse' ? 'active' : ''}} d-flex align-items-center">
        <span class="icon settings mr-2"></span> Explore By Horse
      </a>
    </li>    
<!--     <li class="has-submenu">
      <a href="countries.html" class="d-flex align-items-center">
        <span class="icon map mr-2"></span> Countries
        <span class="icon arrow ml-auto"></span>
      </a>
      <ul>
        <li>
          <a href="states.html" class="d-flex align-items-center justify-content-between">
          states
        </a>
        </li>
        <li>
          <a href="cities.html" class="d-flex align-items-center justify-content-between">
          cities
        </a>
        </li>
      </ul>
    </li> -->
    <!--
    <li class="has-submenu">
      <a href="general-settings.html" class="d-flex align-items-center">
        <span class="icon blog mr-2"></span> Settings
        <span class="icon arrow ml-auto"></span>
      </a>
      <ul>
        <li>
          <a href="general-settings.html" class="d-flex align-items-center">
          General settings
        </a>
        </li>
        <li>
          <a href="ads-settings.html" class="d-flex align-items-center">
          Ads Settings & Pricing
        </a>
        </li>
        <li>
          <a href="payment-settings.html" class="d-flex align-items-center">
          Payment settings
        </a>
        </li>
        <li>
          <a href="smtp-settings.html" class="d-flex align-items-center">
          SMTP settings
        </a>
        </li>
        <li>
          <a href="subscription-settings.html" class="d-flex align-items-center">
          Subscription Settings
        </a>
        </li>
        <li>
          <a href="redirects.html" class="d-flex align-items-center">
          301 Redirects
        </a>
        </li>
        <li>
          <a href="social-settings.html" class="d-flex align-items-center">
          Social Settings
        </a>
        </li>
        <li>
          <a href="blog-settings.html" class="d-flex align-items-center">
          Blog Settings
        </a>
        </li>
        <li>
          <a href="navigation-settings.html" class="d-flex align-items-center">
          Navigation Settings
        </a>
        </li>
      </ul>
    </li>
-->

    <li>
        <a href="{{ url('admin/manage-admin-users') }}"
            class="{{ $current_page == 'manage_admin' ? 'active' : '' }} d-flex align-items-center">
            <span class="icon admin mr-2"></span> Manage admin users
        </a>
    </li>
    <li>
        <a href="{{ url('admin/change-password') }}"
            class="{{ $current_page == 'change_password' ? 'active' : '' }} d-flex align-items-center">
            <span class="icon password mr-2"></span> Change password
        </a>
    </li>
    <li>
        <a href="{{ url('logout') }}" class="d-flex align-items-center">
            <span class="icon logout mr-2"></span> Logout
        </a>
    </li>
    </ul>
</div>
