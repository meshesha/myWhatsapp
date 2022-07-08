
<div class="column-container side-bar side-bar-min-width">
    <div id="side" class="side-container">
        <!-- livewire('side-head') -->
                
        <header class="side-head-wrapper">
            <!-- user(my) avatar area -->

            <div class="side-head-avater-area">
                <div class="avater-img-container" style="height: 40px; width: 40px; cursor: pointer;">
                    <div class="default-avater-img-container">
                        <span data-testid="default-user" data-icon="default-user" class="">
                            <svg viewBox="0 0 212 212" width="212" height="212" class="">
                                <path fill="#DFE5E7" class="background"
                                    d="M106.251.5C164.653.5 212 47.846 212 106.25S164.653 212 106.25 212C47.846 212 .5 164.654.5 106.25S47.846.5 106.251.5z">
                                </path>
                                <path fill="#FFF" class="primary"
                                    d="M173.561 171.615a62.767 62.767 0 0 0-2.065-2.955 67.7 67.7 0 0 0-2.608-3.299 70.112 70.112 0 0 0-3.184-3.527 71.097 71.097 0 0 0-5.924-5.47 72.458 72.458 0 0 0-10.204-7.026 75.2 75.2 0 0 0-5.98-3.055c-.062-.028-.118-.059-.18-.087-9.792-4.44-22.106-7.529-37.416-7.529s-27.624 3.089-37.416 7.529c-.338.153-.653.318-.985.474a75.37 75.37 0 0 0-6.229 3.298 72.589 72.589 0 0 0-9.15 6.395 71.243 71.243 0 0 0-5.924 5.47 70.064 70.064 0 0 0-3.184 3.527 67.142 67.142 0 0 0-2.609 3.299 63.292 63.292 0 0 0-2.065 2.955 56.33 56.33 0 0 0-1.447 2.324c-.033.056-.073.119-.104.174a47.92 47.92 0 0 0-1.07 1.926c-.559 1.068-.818 1.678-.818 1.678v.398c18.285 17.927 43.322 28.985 70.945 28.985 27.678 0 52.761-11.103 71.055-29.095v-.289s-.619-1.45-1.992-3.778a58.346 58.346 0 0 0-1.446-2.322zM106.002 125.5c2.645 0 5.212-.253 7.68-.737a38.272 38.272 0 0 0 3.624-.896 37.124 37.124 0 0 0 5.12-1.958 36.307 36.307 0 0 0 6.15-3.67 35.923 35.923 0 0 0 9.489-10.48 36.558 36.558 0 0 0 2.422-4.84 37.051 37.051 0 0 0 1.716-5.25c.299-1.208.542-2.443.725-3.701.275-1.887.417-3.827.417-5.811s-.142-3.925-.417-5.811a38.734 38.734 0 0 0-1.215-5.494 36.68 36.68 0 0 0-3.648-8.298 35.923 35.923 0 0 0-9.489-10.48 36.347 36.347 0 0 0-6.15-3.67 37.124 37.124 0 0 0-5.12-1.958 37.67 37.67 0 0 0-3.624-.896 39.875 39.875 0 0 0-7.68-.737c-21.162 0-37.345 16.183-37.345 37.345 0 21.159 16.183 37.342 37.345 37.342z">
                                </path>
                            </svg>
                        </span>
                    </div>
                    
                    @if($myProfileImg && $myProfileImg != "")
                        <img src="{{ $myProfileImg }}"
                            id = "my_profile_image"
                            alt="" draggable="false" class="user-real-img user-real-img-opcty-1 vsblty-vsbl" style="visibility: visible;">
                    @endif
                    <!-- <img src="https://web.whatsapp.com/pp?e=https%3A%2F%2Fpps.whatsapp.net%2Fv%2Ft61.24694-24%2F158668199_505194764150172_6062118462735220070_n.jpg%3Fccb%3D11-4%26oh%3D185b38bda79bad5767e043cd43af17ca%26oe%3D61DDC2FB&amp;t=s&amp;u=972509399533%40c.us&amp;i=1641600704&amp;n=r9mSIfu5BCeBBZplXN4s2hWcdiQqor2xVHXFCGjEepI%3D"
                        alt="" draggable="false" class="user-real-img user-real-img-opcty-1 vsblty-vsbl" style="visibility: visible;"> -->
                </div>
            </div>
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
                <button class="side-search-btn-container" aria-label="Search or start new chat">
                    <!-- back button -->
                    <!-- <div class="side-search-btn _2nifA">
                        <span data-testid="back" data-icon="back" class="">
                            <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                <path fill="currentColor" d="M12 4l1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z"></path>
                            </svg>
                        </span>
                    </div> -->

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

                </button>
                <!-- <span></span> -->
                <!-- search text paceholder -->
                <div class="side-search-placeholder">Search or start new chat</div>
                <!-- search text field -->
                <label class="side-search-label">
                    <div tabindex="-1" class="textbox-container">
                        <div class="textbox-placeholder" style="visibility: visible;"></div>
                        <div role="textbox" class="textbox-input copyable-text selectable-text"
                            contenteditable="true" data-tab="3" dir="ltr">
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <!-- users/groups list -->
        <div class="users-group-list-wrapper-pos users-group-list-wrapper" id="pane-side">
            <div tabindex="-1" data-tab="4">
                <div class="">
                    <!--yield('users_list')-->
                                        
                    <div aria-label="Chat list"  class="users-group-list-container users-group-list-container-mrg" role="grid"
                        aria-rowcount="{{count($allChats)}}" style="height: 216px;">
                        <input type="hidden" id="chat-data-hash" value="{{$chats_md5}}" />
                        <div class="users-group-list-item"
                                    style="z-index: 0; transition: none 0s ease 0s; height: 72px; transform: translateY(0px);">

                        @if(count($allChats) > 0)
                            @foreach($allChats as $chat)
                                <!-- user/groups item 1-->
                                <div tabindex="0" aria-selected="true" role="row">
                                    <!-- wire:click="getAllMessages('{{$chat['id']['_serialized']}}', '{{($chat['isGroup'])?'yes':'no'}}')" -->
                                    <div data-testid="cell-frame-container"
                                        id = "user_{{$chat['id']['user']}}"
                                        data-userid="{{$chat['id']['user']}}"
                                        data-isgroup="{{($chat['isGroup'])?'yes':'no'}}" 
                                        data-userserialized="{{$chat['id']['_serialized']}}"
                                        wire:click="getAllMessages('{{$chat['id']['_serialized']}}', '{{($chat['isGroup'])?'yes':'no'}}')"
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
                                                    @if($chat['contact']['profilePicThumbObj']['eurl'] != '')
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
    </div>
</div>


@section('foot_script_side_bar')

<script type="text/javascript">
    
    var all_chat_hash = "{!! $chats_md5 !!}";
    var intervalusersId;
    sessionStorage.setItem("is_all_user_check", "true");

    $(document).ready(function () {
         setAllChatTimer();

    });
    
    function setAllChatTimer(){
        //console.log("setAllChatTimer:")
        if(intervalusersId !== undefined){
            clearInterval(intervalusersId);
        }
        getAllChats();
        intervalusersId = setInterval(function(){
            getAllChats();

            let is_check_users = sessionStorage.getItem("is_all_user_check");
            //console.log("is_check_users:", is_check_users)
            if(is_check_users == "false"){
                clearInterval(intervalusersId);
            }
        },3000);
    }
    
    //user list and new msg count
    function getAllChats() {
        //console.log("old hash", all_chat_hash)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/wpp/chatajax',
            // data: {
            //     user_id : userId,
            //     is_group: isGroup
            // },
            success:function(data) {
                //console.log("all chats:" , data);
                if(data.conn_status && data.conn_status.message == "Connected"){

                    //console.log("new hash", data.chats_md5)
                    
                    Livewire.emit('checkChatUsrsHash', data.chats_md5)
                    /*
                    if(data.response.status == "success" && data.chats_md5 != all_chat_hash){
                        all_chat_hash = data.chats_md5; 
                        //setUsers(data.response.response);
                        //Livewire listner hear to update chat user list - TODO
                        Livewire.emit('checkChatUsrsHash', all_chat_hash)
                        console.log("new hash", all_chat_hash)
                    }
                    */
                }
                
            },
            error: function(response){
                console.log(response);
            }
        });
    }



    function setUsers(chatUsersAry){
        console.log("chatUsersAry" , chatUsersAry)
        if(chatUsersAry.length && chatUsersAry.length > 0){ 
            chatUsersAry.forEach(function(usr){
                let user_Id = usr.id.user;
                //console.log("user dom: " , $("#user_" + user_Id))
                if($("#user_" + user_Id).length > 0){
                    //check user name
                    let userName = $("#user_name_" + user_Id).html();
                    if(userName != usr.contact.formattedName){
                        $("#user_name_" + user_Id).html(usr.contact.formattedName);
                        $("#user_name_" + user_Id).attr("title", usr.contact.formattedName)
                    }
                    //check user image
                    if($("#user_img_" + user_Id).length > 0){
                        let userImg = $("#user_img_" + user_Id).attr("src");
                        if(userImg != usr.contact.profilePicThumbObj.eurl){
                            $("#user_img_" + user_Id).attr("src", usr.contact.profilePicThumbObj.eurl)
                        }
                    }else{
                        //add imgae - TODO
                    }
                    //check user unread
                    let unread_count = $("#unread_msg_" + user_Id).html();
                    if(unread_count != usr.unreadCount){
                        //Add sound new msg - TODO
                        $("#unread_msg_" + user_Id).html(usr.unreadCount)
                    }

                }else{
                    addNewUser(usr);
                }
            })
        }
    }

    function addNewUser(user){
        console.log("add(append) new user - TODO" , user)
    }

</script>
@endsection