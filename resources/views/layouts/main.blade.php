<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css" rel="stylesheet"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Styles -->
    <link href="{{ url('css/main.css') }}" rel="stylesheet">
    <link href="{{ url('jQuery-contextMenu/jquery.contextMenu.min.css') }}" rel="stylesheet">
    <link href="{{ url('popup-menu/popup.css') }}" rel="stylesheet">

    <link href="{{ url('Magnific-Popup-1.1.0/magnific-popup.css') }}" rel="stylesheet">
    <!-- <link href="{{ url('emojionearea/emojionearea.min.css') }}" rel="stylesheet"> -->
    <!-- <link href="https://rawgit.com/ellekasai/twemoji-awesome/gh-pages/twemoji-awesome.css" rel="stylesheet"> -->

    <!-- <link href="{{ url('wasap_emoji/wasap_emoji.css') }}" rel="stylesheet"> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  
    <script src="https://cdn.rawgit.com/mozilla/localForage/master/dist/localforage.js"></script>

    <script src="{{ url('jQuery-contextMenu/jquery.contextMenu.js') }}"></script>
    <script src="{{ url('jQuery-contextMenu/jquery.ui.position.min.js') }}"></script>
    <script src="{{ url('popup-menu/popup.js') }}"></script>
    <!-- <script src="{{ url('emojionearea/emojionearea.min.js') }}"></script> -->
    <script src="https://twemoji.maxcdn.com/v/latest/twemoji.min.js" crossorigin="anonymous"></script>
    <!-- <script src="//twemoji.maxcdn.com/twemoji.min.js"></script> -->
    <!-- <script src="{{ url('emoji_picker/vanillaEmojiPicker.js') }}"></script> -->
    <!-- <script src="{{ url('wasap_emoji/wasap_emoji.js') }}"></script> -->
    <script src="{{ url('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ url('Magnific-Popup-1.1.0/jquery.magnific-popup.min.js') }}"></script>

    <link href="{{ url('emoji-mart-outside-react/emoji-mart/css/emoji-mart.css') }}" rel="stylesheet">
    @livewireStyles

    @yield('head_style')
    @yield('head_script')    
    <script src="{{ url('emoji-mart-outside-react/dist/main.js') }}" type="text/javascript"></script>

</head>
<body>
<div id="app">

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <div tabindex="-1" class="app-wrapper app-wrapper-web font-fix os-win">
            <div tabindex="-1" class="main-container two">
                <!-- <div class="_3DJrq"></div> -->
                <div class="column-container side-bar side-bar-min-width">
                    @livewire('side-bar')
                </div>
                <!-- main -->
                <div class="column-container main-content-wrapper">
                    <div id="main" class="main-content-area" style="transform: scaleX(1);">
                        <!-- main background -->
                        <div class="main-content-area-bg" data-asset-chat-background-light="true"
                            style="opacity: 0.06;"></div>
                        <!-- main head -->
                        <header class="main-head-area">
                            <!-- user img -->
                            <div class="main-head-img-wrapper" role="button">
                                <div class="avater-img-container" style="height: 40px; width: 40px;">
                                    <div class="default-avater-img-container">
                                        <span data-testid="default-group"
                                            data-icon="default-group" class="">
                                            <svg width="212" height="212"
                                                viewBox="0 0 212 212" fill="none" class="">
                                                <path class="background"
                                                    d="M105.946.25C164.318.25 211.64 47.596 211.64 106s-47.322 105.75-105.695 105.75C47.571 211.75.25 164.404.25 106S47.571.25 105.946.25z"
                                                    fill="#DFE5E7">
                                                </path>
                                                <path class="primary" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M102.282 77.286c0 10.671-8.425 19.285-18.94 19.285s-19.003-8.614-19.003-19.285C64.339 66.614 72.827 58 83.342 58s18.94 8.614 18.94 19.286zm48.068 2.857c0 9.802-7.738 17.714-17.396 17.714-9.658 0-17.454-7.912-17.454-17.714s7.796-17.715 17.454-17.715c9.658 0 17.396 7.913 17.396 17.715zm-67.01 29.285c-14.759 0-44.34 7.522-44.34 22.5v11.786c0 3.536 2.85 4.286 6.334 4.286h76.012c3.484 0 6.334-.75 6.334-4.286v-11.786c0-14.978-29.58-22.5-44.34-22.5zm43.464 1.425c.903.018 1.681.033 2.196.033 14.759 0 45 6.064 45 21.043v9.642c0 3.536-2.85 6.429-6.334 6.429h-32.812c.697-1.993 1.141-4.179 1.141-6.429l-.245-10.5c0-9.561-5.614-13.213-11.588-17.1-1.39-.904-2.799-1.821-4.162-2.828a.843.843 0 0 1-.059-.073.594.594 0 0 0-.194-.184c1.596-.139 4.738-.078 7.057-.033z">
                                                </path>
                                            </svg>
                                        </span>
                                    </div>
                                    <!-- <img
                                        src="https://web.whatsapp.com/pp?e=https%3A%2F%2Fpps.whatsapp.net%2Fv%2Ft61.24694-24%2F157350221_347781573489889_7142572979777296550_n.jpg%3Fccb%3D11-4%26oh%3Dd47d5b0b09ccef210eb3a7ce065d3dd5%26oe%3D61DE4355&amp;t=s&amp;u=120363020803854156%40g.us&amp;i=1641567924&amp;n=h5DPqsWXvl1i5HmGoEHfPyJbVQzhXPsUH7%2F%2BM%2FTMi%2FE%3D"
                                        alt="" draggable="false" class="user-real-img user-real-img-opcty-1 vsblty-vsbl" style="visibility: visible;"> -->
                                </div>

                            </div>
                            <!-- user name -->
                            <div class="main-head-user-name-area" role="button">
                                <div class="main-head-user-name-cont">
                                    <div class="main-head-user-name">
                                        <!-- <span dir="auto" title="קבוצה אמיר בדיקה" class="user-name-txt">קבוצה
                                            אמיר בדיקה</span> -->
                                    </div>
                                </div>
                            </div>
                            <!-- settings -->
                            <div class="main-head-menu-area">
                                <div class="menu-area-container menu-area-color">
                                    {{-- <div class="menu-btn-container">
                                        <div aria-disabled="false" role="button" tabindex="0" class="btns-content"
                                            data-tab="6" title="Search…" aria-label="Search…">
                                            <span data-testid="search-alt" data-icon="search-alt" class="">
                                                <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                                    <path fill="currentColor"
                                                        d="M15.9 14.3H15l-.3-.3c1-1.1 1.6-2.7 1.6-4.3 0-3.7-3-6.7-6.7-6.7S3 6 3 9.7s3 6.7 6.7 6.7c1.6 0 3.2-.6 4.3-1.6l.3.3v.8l5.1 5.1 1.5-1.5-5-5.2zm-6.2 0c-2.6 0-4.6-2.1-4.6-4.6s2.1-4.6 4.6-4.6 4.6 2.1 4.6 4.6-2 4.6-4.6 4.6z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </div>
                                    </div> --}}
                                    <div class="menu-btn-container open-all-chat-users" data-isshow="false">
                                        <div aria-disabled="false" role="button" tabindex="0" class="btns-content"
                                            data-tab="6" title="Users" aria-label="Users">
                                            <span data-testid="users" data-icon="users" width="24" height="24">
                                                {{-- <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                                    <path fill="currentColor"
                                                        d="M15.9 14.3H15l-.3-.3c1-1.1 1.6-2.7 1.6-4.3 0-3.7-3-6.7-6.7-6.7S3 6 3 9.7s3 6.7 6.7 6.7c1.6 0 3.2-.6 4.3-1.6l.3.3v.8l5.1 5.1 1.5-1.5-5-5.2zm-6.2 0c-2.6 0-4.6-2.1-4.6-4.6s2.1-4.6 4.6-4.6 4.6 2.1 4.6 4.6-2 4.6-4.6 4.6z">
                                                    </path>
                                                </svg> --}}
                                                <i class="fas fa-users"></i>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="menu-btn-container">
                                            <div aria-disabled="false" role="button" tabindex="0" class="btns-content"
                                                data-tab="6" title="Menu" aria-label="Menu">
                                                <span data-testid="menu" data-icon="menu" class="">
                                                    <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                                        <path fill="currentColor"
                                                            d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z">
                                                        </path>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>
                        <!-- <span class="_2K2u4"></span>
                        <div class="_2K2u4"></div> -->

                        <!-- main msg area -->
                        <div class="main-text-msg-area">
                            <div class="vsblty-vsbl copyable-area">
                                <!-- page down button -->
                                <div class="page_down">
                                    <span>
                                        <div role="button" tabindex="0" id = "page_down_btn"
                                            class="page_down_btn_gray page_down_btn_geen" data-tab="7"
                                            style="transform: scaleX(1) scaleY(1); opacity: 1;">
                                            <!-- <span class="_38VQ8"></span> -->
                                            <span data-testid="down" data-icon="down">
                                                <svg viewBox="0 0 19 20" width="19" height="20" class="">
                                                    <path fill="currentColor"
                                                        d="M3.8 6.7l5.7 5.7 5.7-5.7 1.6 1.6-7.3 7.2-7.3-7.2 1.6-1.6z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </div>
                                    </span>
                                </div>
                                <div class="chat-container" tabindex="0">
                                    <div class="chat-container-spacer"></div>

                                    <!-- yield('chat_items') -->
                                    @livewire('msg-items')
                                    
                                    <div style="display: none;" ></div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="VjtCX" style="height: 0px;"></div> -->
                        <!-- main foot area - text writer area -->
                        @livewire('text-typing')
                        <div hidden="" style="display: none;"></div>
                    </div>
                    <div hidden="" style="display: none;"></div>
                </div>
            </div>
            <div hidden="" style="display: none;"></div>
        </div>
        <div hidden="" style="display: none;"></div>
        <div class="loadin-spinng"></div>
    @yield('above_livewire_foot_script')
    @livewireScripts
    @yield('foot_script')
</body>
</html>