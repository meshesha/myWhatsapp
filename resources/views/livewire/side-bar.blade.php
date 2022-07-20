
<div id="side" class="side-container">
    <!-- livewire('side-head') -->
            
    <header class="side-head-wrapper">
        <!-- user(my) avatar area -->
        @livewire('my-profile')
        
        <!-- side head menu area -->
        <div class="side-head-menu-area">
            <div class="menu-area-container menu-area-color">
                <span>
                    <!-- status button -->
                    <!-- <div class="menu-btn-container">
                        <div aria-disabled="false" role="button" tabindex="0" class="btns-content" title="Status" aria-label="Status">
                            <span data-testid="status-v3" data-icon="status-v3" class=""><svg
                                    id="ee51d023-7db6-4950-baf7-c34874b80976" viewBox="0 0 24 24" width="24" height="24"
                                    class="">
                                    <path fill="currentColor"
                                        d="M12 20.664a9.163 9.163 0 0 1-6.521-2.702.977.977 0 0 1 1.381-1.381 7.269 7.269 0 0 0 10.024.244.977.977 0 0 1 1.313 1.445A9.192 9.192 0 0 1 12 20.664zm7.965-6.112a.977.977 0 0 1-.944-1.229 7.26 7.26 0 0 0-4.8-8.804.977.977 0 0 1 .594-1.86 9.212 9.212 0 0 1 6.092 11.169.976.976 0 0 1-.942.724zm-16.025-.39a.977.977 0 0 1-.953-.769 9.21 9.21 0 0 1 6.626-10.86.975.975 0 1 1 .52 1.882l-.015.004a7.259 7.259 0 0 0-5.223 8.558.978.978 0 0 1-.955 1.185z">
                                    </path>
                                </svg></span></div><span></span>
                    </div> -->
                    <!-- chat button -->
                    <div class="menu-btn-container">
                        <div aria-disabled="false" role="button" tabindex="0" class="btns-content"
                            title="New chat" id="new-chat-btn">
                            <span data-testid="chat" data-icon="chat" class="">
                                <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                    <path fill="currentColor"
                                        d="M19.005 3.175H4.674C3.642 3.175 3 3.789 3 4.821V21.02l3.544-3.514h12.461c1.033 0 2.064-1.06 2.064-2.093V4.821c-.001-1.032-1.032-1.646-2.064-1.646zm-4.989 9.869H7.041V11.1h6.975v1.944zm3-4H7.041V7.1h9.975v1.944z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    <!-- menu button -->
                    <div class="menu-btn-container">
                        <div aria-disabled="false" role="button" tabindex="0" class="btns-content menu-btn-btn"
                            title="Menu" aria-label="Menu">
                            <span data-testid="menu" data-icon="menu" class="">
                                <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                    <path fill="currentColor"
                                        d="M12 7a2 2 0 1 0-.001-4.001A2 2 0 0 0 12 7zm0 2a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 9zm0 6a2 2 0 1 0-.001 3.999A2 2 0 0 0 12 15z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </span>
            </div>
        </div>
    </header>
    <!-- search -->
    <div tabindex="-1" class="side-search-wraper">
        <div class="side-search-container">
            <div class="side-search-btn-container" aria-label="Search or start new chat">
                <!-- back button -->
                @if($searchUser != null)
                    <button class="side-search-btn _2nifA" wire:click="$set('searchUser', null)">
                        <span data-testid="back" data-icon="back" class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                <path fill="currentColor" d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                            </svg>
                        </span>
                    </button> 
                @else
                <!-- search icon -->
                
                    <div class="side-search-btn side-search-icon">
                        <span data-testid="search" data-icon="search" class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                <path fill="currentColor"
                                    d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.808 0a3.605 3.605 0 1 1 0-7.21 3.605 3.605 0 0 1 0 7.21z">
                                </path>
                            </svg>
                        </span>
                    </div>
                @endif
            </div>
            <!-- <span></span> -->
            @if($searchUser == null)
                <div class="side-search-placeholder">Search or start new chat</div>
            @endif
            <!-- search text field -->
            <label class="side-search-label">
                <div tabindex="-1" class="textbox-container">
                    {{-- <div class="textbox-placeholder" style="visibility: visible;"></div> --}}
                    {{-- <div role="textbox" class="textbox-input copyable-text selectable-text"
                        oninput="searchSideUser(this)"
                        contenteditable="true" data-tab="3" dir="ltr">
                    </div> --}}
                    <input type="text" role="textbox" 
                        class="textbox-input copyable-text selectable-text" 
                        id="chat-user-search"
                        wire:model="searchUser" />
                </div>
            </label>
        </div>
    </div>
    
            
                    

    <!-- users/groups list -->
    <div class="users-group-list-wrapper-pos users-group-list-wrapper" id="pane-side" wire:poll.5s="checkUsersChat">
        <div tabindex="-1" data-tab="4">
            <div class="">
                <!--yield('users_list')-->
                                    
                <div aria-label="Chat list"  class="users-group-list-container users-group-list-container-mrg" role="grid"
                    aria-rowcount="{{count($allChats)}}" style="height: 70vh;">
                    <input type="hidden" id="chat-data-hash" value="{{$chats_md5}}" />
                    <div class="users-group-list-item"
                                style="z-index: 0; transition: none 0s ease 0s; height: 72px; transform: translateY(0px);">

                    @if(count($allChats) > 0)
                        @foreach($allChats as $chat)
                            <!-- user/groups item 1-->
                            <div tabindex="0" aria-selected="true" role="row" class="shat-user-item-wrapper">
                                <div data-testid="cell-frame-container"
                                    id = "user_{{$chat['id']['user']}}"
                                    data-userid="{{$chat['id']['user']}}"
                                    data-isgroup="{{($chat['isGroup'])?'yes':'no'}}" 
                                    data-userserialized="{{$chat['id']['_serialized']}}"
                                    onclick="$('body').addClass('loading')"
                                    wire:click="getAllMessages('{{$chat['id']['_serialized']}}', '{{($chat['isGroup'])?'yes':'no'}}','{{$chat['contact']['formattedName']}}','{{$chat['contact']['profilePicThumbObj']['eurl']??''}}')"
                                    class="users-group-cell-frame cell-frame">
                                    <div class="users-group-img-wrapper">
                                        <div class="users-group-img-container">
                                            <div class="avater-img-container"
                                                style="height: 49px; width: 49px;">
                                                <div class="default-avater-img-container">
                                                    <span data-testid="default-group"
                                                        data-icon="default-group" class="">
                                                        <svg width="212" height="212"
                                                            viewBox="0 0 212 212" fill="none" class="">
                                                            <path class="background"
                                                                d="M105.946.25C164.318.25 211.64 47.596 211.64 106s-47.322 105.75-105.695 105.75C47.571 211.75.25 164.404.25 106S47.571.25 105.946.25z"
                                                                fill="#DFE5E7">
                                                            </path>
                                                            <path class="primary" fill-rule="evenodd"
                                                                clip-rule="evenodd"
                                                                d="M102.282 77.286c0 10.671-8.425 19.285-18.94 19.285s-19.003-8.614-19.003-19.285C64.339 66.614 72.827 58 83.342 58s18.94 8.614 18.94 19.286zm48.068 2.857c0 9.802-7.738 17.714-17.396 17.714-9.658 0-17.454-7.912-17.454-17.714s7.796-17.715 17.454-17.715c9.658 0 17.396 7.913 17.396 17.715zm-67.01 29.285c-14.759 0-44.34 7.522-44.34 22.5v11.786c0 3.536 2.85 4.286 6.334 4.286h76.012c3.484 0 6.334-.75 6.334-4.286v-11.786c0-14.978-29.58-22.5-44.34-22.5zm43.464 1.425c.903.018 1.681.033 2.196.033 14.759 0 45 6.064 45 21.043v9.642c0 3.536-2.85 6.429-6.334 6.429h-32.812c.697-1.993 1.141-4.179 1.141-6.429l-.245-10.5c0-9.561-5.614-13.213-11.588-17.1-1.39-.904-2.799-1.821-4.162-2.828a.843.843 0 0 1-.059-.073.594.594 0 0 0-.194-.184c1.596-.139 4.738-.078 7.057-.033z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </div>
                                                @if(isset($chat['contact']['profilePicThumbObj']['eurl']) && $chat['contact']['profilePicThumbObj']['eurl'] != '')
                                                <img
                                                    id = "user_img_{{$chat['id']['user']}}" 
                                                    src="{{$chat['contact']['profilePicThumbObj']['eurl']}}"
                                                    alt="" draggable="false" class="user-real-img user-real-img-opcty-1 vsblty-vsbl"
                                                    style="visibility: visible;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <!-- user/groups name status -->
                                    <div class="users-group-name-wrapper">
                                        <div role="gridcell" aria-colindex="2"
                                            class="users-group-name-time-grid">
                                            <div class="users-group-name-content">
                                                <span dir="auto" id="user_name_{{$chat['id']['user']}}" title="{{$chat['contact']['formattedName']}}"
                                                    class="user-name-txt">{{$chat['contact']['formattedName']}}
                                                </span>
                                            </div>
                                            <div class="users-group-counter-content"><!--yesterday--></div>
                                        </div>

                                        <div class="users-group-second-grid">
                                            <div class="users-group-new-msg-txt">
                                                <!-- <span class="Hy9nV" title="‪Ffff‬">
                                                    <span dir="auto" class="dsply-inlyn-blok vsblty-vsbl">אמיר</span>
                                                    <span>:&nbsp;</span>
                                                    <span dir="ltr"
                                                        class="user-name-txt">
                                                        Ffff
                                                    </span>
                                                </span> -->
                                            </div>
                                            <div role="gridcell" aria-colindex="1"
                                                class="users-group-counter-content">
                                                <span>
                                                    @if($chat['unreadCount'] > 0)
                                                    <div class="users-group-unread-msg-counter"
                                                        style="transform: scaleX(1) scaleY(1); opacity: 1;">
                                                        <span class="unread-msg-counter"
                                                            id = "unread_msg_{{$chat['id']['user']}}">{{$chat['unreadCount']}}</span>
                                                    </div>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    </div>
                </div>
            </div>
        </div>

        <div hidden="" style="display: none;"></div>
        <!-- <div class="_1lRek"></div> -->
    </div>
    
    <script>
        
        window.addEventListener('selected_user_avatar', event => {
            //console.log('msg loaded with hash: ' + event.detail.hash);
            
            var userImg = event.detail.user_img;
            var userName = event.detail.user_name;
            //is_current_group = isGroup;
            
            if(userImg == "" || userImg === undefined || userImg == null){
                if($(".main-head-img-wrapper .avater-img-container img").length > 0){
                    $(".main-head-img-wrapper .avater-img-container img").remove();
                }
            }else{
                if($(".main-head-img-wrapper .avater-img-container img").length > 0){
                    $(".main-head-img-wrapper .avater-img-container img").attr("src", userImg);
                }else{
                    $("<img>",{
                        src : userImg,
                        draggable: false,
                        class: "user-real-img user-real-img-opcty-1 vsblty-vsbl"
                    }).appendTo(".main-head-img-wrapper .avater-img-container");
                }
            }
            
            //main-head-user-name
            $(".main-head-user-name").html("<span class='user-name-txt'>" + userName + "</span>");
            //$("body").removeClass("loading");

        });
    </script>
</div>

@section('above_livewire_foot_script')
    <script type="text/javascript">
        function searchSideUser(obj){

            var srchStr = $(obj).val();
            if (srchStr != "") {
                $(".side-search-placeholder").hide();
            } else {
                $(".side-search-placeholder").show();
            }
            //console.log($(obj).text())
            // $(".shat-user-item-wrapper").each(function(idx, userItem) {
            //     var user_name = $(userItem).find(".user-name-txt").text();
            //     //console.log("user_name: ", user_name)
            //     if (user_name.indexOf(srchStr) == -1) {
            //         $(this).hide();
            //     } else {
            //         $(this).show();
            //     }
            // });
        }
    </script>
@endsection