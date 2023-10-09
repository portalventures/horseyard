<div class="inbox-left">
    <div class="inbox-close d-block d-lg-none">
        <span class="icon inbox-close"></span>
    </div>
    <div class="inbox-menu">
        <h3>Messages</h3>
        <ul>
            <li>
                <a class="{{ $current_page == 'compose' ? 'active' : '' }} " href="\compose">
                    <span class="icon compose"></span> Compose
                </a>
            </li>
            <li>
                @php
                    $newCnt = getInboxNewMsgCount();
                @endphp
                <a href="\inbox"
                    class="{{ $current_page == 'inbox' ? 'active' : '' }} d-flex align-items-center justify-content-between">
                    <span class="d-flex align-items-center {{ $newCnt > 0 ? 'font-weight-bold' : '' }}">
                        <span class="icon inbox"></span> Inbox
                    </span>
                    <small><strong id="unreadMessageCount">{{ $newCnt > 0 ? $newCnt : '' }}</strong></small>
                </a>
            </li>
            <li>
                <a class="{{ $current_page == 'block_user_list' ? 'active' : '' }} " href="\block_user_list">
                    <span class="icon block-user"></span> Block a user
                </a>
            </li>
        </ul>
        <h3>Sell</h3>
        <ul>
            <li>
                <a href="{{ url('create-listing') }}"
                    class="{{ $current_page == 'create-listing' ? 'active' : '' }}">
                    <span class="icon create-listing"></span> Create Listing
                </a>
            </li>
            <li>
                <a href="{{ url('manage-ads') }}"
                    class="{{ $current_page == 'manage-ads' || $current_page == 'edit-listing' || $current_page == 'view_ad'? 'active': '' }}">
                    <span class="icon manage-ads"></span> Manage Ads
                </a>
            </li>
            <li>
                <a href="{{ url('wishlist') }}" class="{{ $current_page == 'wishlist' ? 'active' : '' }}">
                    <span class="icon wishlist"></span> Wishlist
                </a>
            </li>
        </ul>
        <h3>Account</h3>
        <ul>
            <li>
                <a href="{{ url('my-profile') }}" class="{{ $current_page == 'my_profile' ? 'active' : '' }}">
                    <span class="icon profile"></span> My Profile
                </a>
            </li>
            <li>
                <a href="{{ url('logout') }}">
                  <span class="icon logout"></span> Logout
                </a>
            </li>
        </ul>
    </div>
</div>
<script>
    /*
    setTimeout(() => {
        getInboxCount();
        setInterval(() => {
            getInboxCount();
        }, (10000));
    }, 500);
    */
</script>
