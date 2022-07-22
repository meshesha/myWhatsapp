@extends('layouts.main')

@section('head_style')
    <style>
        .loadin-spinng {
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.8) url("/images/loader.gif") center no-repeat;
        }

        body.loading {
            overflow: hidden;
        }

        /* Make spinner image visible when body element has the loading class */
        body.loading .loadin-spinng {
            display: block;
        }


        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0.8;
            transition: .3s ease;
            background-color: black;
        }  

        .container:hover .overlay {
            opacity: 0.9;
        }

        .icon {
            color: white;
            font-size: 100px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        /* .fa-user:hover {
            color: #eee;
        } */
        
        .document-overly {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            opacity: 0.1;
            transition: .3s ease;
            background-color: black;
        }

        .media-loading {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100%;
            width: 100%;
            background: rgba(255, 255, 255) url("/images/loader.gif") center no-repeat;
        }
.swal-footer{
	overflow: auto;
}

.swal-button-container{
	float: right;
}
.swal2-actions{
    position: absolute;
    width: 100%;
    bottom: 0;
    padding-top: 5px;
    background: rgb(203, 203, 203);
	/* box-sizing: border-box;
	flex: none;
	transition: box-shadow .18s ease-out, background-color .25s ease-out; */
}
/* .side-search-container {
	position: relative;
	z-index: 100;
	height: 49px;
} */
/* 

.swal2-actions .textbox-input {
	position: relative;
	width: 50%;
	min-height: 20px;
	font-size: 17px;
	line-height: 20px;
	color: #4a4a4a;
	word-wrap: break-word;
	white-space: pre-wrap;
	-webkit-user-select: text;
	-moz-user-select: text;
	-ms-user-select: text;
	user-select: text;
} */
    </style>
@endsection

@section('foot_script')
    <script type="text/javascript">
        var types_arry = ["chat", "image", "video", "audio", "ptt"];
        var currnt_chat_id = "";
        var is_current_group = "no";
        var currnet_chat_hash = "";
        //var intervalusersId;
        var chat_replat_msg_serializedid = "";
        //sessionStorage.setItem("is_all_user_check", "true");
        var msg_ary = [];
        var intervalId;
        var last_elem_id = "";
        var users_contants;
        sessionStorage.setItem("users_contants_html", "");
        
        // Register the plugin
        var pond = null;
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginMediaPreview);
        FilePond.setOptions({
            server: {
                url: '/filepond/api',
                process: '/process',
                revert: '/process',
                patch: "?patch=",
                headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        });
        //FilePond.registerPlugin(FilePondPluginImageCrop);

        const Toast = Swal.mixin({
            toast: true,
            position: 'center-center',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        $(document).ready(function() {

            var sent_msg_clock_stt =
                '<span data-testid="msg-time" aria-label=" Pending " data-icon="msg-time" class=""><svg viewBox="0 0 16 15" width="16" height="15" class=""><path fill="currentColor" d="M9.75 7.713H8.244V5.359a.5.5 0 0 0-.5-.5H7.65a.5.5 0 0 0-.5.5v2.947a.5.5 0 0 0 .5.5h.094l.003-.001.003.002h2a.5.5 0 0 0 .5-.5v-.094a.5.5 0 0 0-.5-.5zm0-5.263h-3.5c-1.82 0-3.3 1.48-3.3 3.3v3.5c0 1.82 1.48 3.3 3.3 3.3h3.5c1.82 0 3.3-1.48 3.3-3.3v-3.5c0-1.82-1.48-3.3-3.3-3.3zm2 6.8a2 2 0 0 1-2 2h-3.5a2 2 0 0 1-2-2v-3.5a2 2 0 0 1 2-2h3.5a2 2 0 0 1 2 2v3.5z"></path></svg></span>';
            var read_stt_check_elm =
                '<span data-testid="msg-check" aria-label=" Sent " data-icon="msg-check" class=""><svg viewBox="0 0 16 15" width="16" height="15" class=""><path fill="currentColor" d="M10.91 3.316l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.879a.32.32 0 0 1-.484.033L1.891 7.769a.366.366 0 0 0-.515.006l-.423.433a.364.364 0 0 0 .006.514l3.258 3.185c.143.14.361.125.484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z"></path></svg></span>';
            var read_stt_dblcheck_elm =
                '<span data-testid="msg-dblcheck" aria-label=" Delivered " data-icon="msg-dblcheck" class=""><svg viewBox="0 0 16 15" width="16" height="15" class=""><path fill="currentColor" d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.879a.32.32 0 0 1-.484.033l-.358-.325a.319.319 0 0 0-.484.032l-.378.483a.418.418 0 0 0 .036.541l1.32 1.266c.143.14.361.125.484-.033l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.879a.32.32 0 0 1-.484.033L1.891 7.769a.366.366 0 0 0-.515.006l-.423.433a.364.364 0 0 0 .006.514l3.258 3.185c.143.14.361.125.484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z"></path></svg></span>';

            
            //$.fn.filepond.registerPlugin(FilePondPluginImagePreview);
            
            //
            $(".chat-container").on("scroll", function() {
                //console.log("heigth: ", $(this).scrollTop() , this.scrollHeight - $(this).height())
                var crrPos = $(this).scrollTop();
                var botPos = this.scrollHeight - $(this).height();
                //console.log("chat-container scroll: ", (botPos - crrPos))
                if ((botPos - crrPos) < 10) {
                    $(".page_down").hide();
                } else {
                    $(".page_down").show();
                }
            })

            $(".open-all-chat-users").on("click", function(){
                var is_show = $(this).attr("data-isshow");
                if(is_show == "false"){
                    $(".two .side-bar-min-width").show();
                    $(this).attr("data-isshow","true");
                }else{
                    $(".two .side-bar-min-width").hide();
                    $(this).attr("data-isshow","false");
                }
            })

            $("#page_down_btn").on("click", function() {
                scrollToElem("scroll_down_pos");
            });

            // $(".close_replay_msg_btn_btn").on("click", function(){
            //     $(".replay_msg_preview_area").hide();
            //     $(".replay_msg_preview_content").html("");
            //     chat_replat_msg_serializedid = "";
            // });


            $.contextMenu({
                selector: '.chat-item',
                callback: function(key, options) {
                    let chatItem = $(options.$trigger[0])
                    var m = "clicked: " + key;
                    //data-serializedid
                    //data-id
                    let chat_msg_id = chatItem.data("id");
                    let chat_msg_serializedid = chatItem.data("serializedid");

                    console.log(m, chat_msg_id, chat_msg_serializedid);
                    if (key == "replay") {
                        //console.log(chatItem );
                        chat_replat_msg_serializedid = chat_msg_serializedid;
                        let replay_msg_content = getReplayMsgContent(chatItem);
                        $(".replay_msg_preview_content").html(replay_msg_content)
                        //let chat_msg_content = $("#" + chat_msg_id).html();

                        $(".replay_msg_preview_area").show();
                    } else if (key == "forword") {
                        console.log("forword msg");
                        usersContant("forword-msg", chat_msg_id);
                    }
                },
                items: {
                    //     "edit": {name: "Edit", icon: "edit"},
                    //     "cut": {name: "Cut", icon: "cut"},
                    //    copy: {name: "Copy", icon: "copy"},
                    //     "paste": {name: "Paste", icon: "paste"},
                    //     "delete": {name: "Delete", icon: "delete"},
                    //     "sep1": "---------",
                    //     "quit": {name: "Quit", icon: function(){
                    //         return 'context-menu-icon context-menu-icon-quit';
                    //     }}
                    "replay": {
                        name: "Replay",
                        icon: "fa-reply-all"
                    },
                    "forword": {
                        name: "Forword",
                        icon: "fa-share"
                    },
                    "sep1": "---------",
                    "delete": {
                        name: "Delete",
                        icon: "delete"
                    }
                }
            });

            // $('.context-menu-one').on('click', function(e){
            //     console.log('clicked', this, e);
            // })  
            var side_main_menu = `<div>
                <a href="#" id="file"><i id="file" class="far fa-file"></i></a>
                <a href="#" id="user-card"><i class="far fa-id-card"></i></a>
                <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();" 
                    id="logout"><i class="fas fa-sign-out-alt"></i>
                </a>
            </div>`;

            $(".menu-btn-btn").popup({
                content: side_main_menu,
                position: "bottom",
                theme: "",
                style: "",
                animation: "grow",
                event: "click",
                hideOnClick: true,
                zIndex: 1000,
                popItemClick: function(e) {
                    let menu_type = $(this).attr("id");
                    console.log("menu", menu_type);
                }
            });

            //attachment-btn
            var attachment_Menu = '<div>\
                    <a href="#" id="file"><i id="file" class="far fa-file"></i></a>\
                    <a href="#" id="user-card"><i class="far fa-id-card"></i></a>\
                    <a href="#" id="media"><i class="fas fa-photo-video"></i></a>\
                    </div>';

            $("#attachment-btn").popup({
                content: attachment_Menu,
                // Where the popup will show by default- top. 
                // Other options: right, bottom, or left
                position: "top",
                // Menu Element theme. Defaults to popupTheme, but custom class can be set instead
                theme: "",

                // Default no style, will revert to default colours. 
                // Other options: blue, red, green, custom
                style: "",

                // Standard animation by default. 
                // Other options: flip, grow, bounce , standard
                animation: "grow",

                // Default set to "click".
                // Can also be set to hover
                event: "click",

                // When true, clicking off the menu closes it. When false, only clicking on the menu closes it.
                hideOnClick: true,

                // z-index can be set for each menu for layering if necessary
                zIndex: 1000,
                popItemClick: function(e) {
                    let menu_type = $(this).attr("id");
                    
                    console.log("selected menu:", menu_type)
                    if (menu_type == "media") {
                        const file = Swal.fire({
                            // title: 'Select image',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            customClass: {
                                popup: 'contact-list-swel'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'שלח',
                            // input: 'file',
                            // inputAttributes: {
                            //     'accept': 'video/*,image/*',
                            //     'aria-label': 'Upload yours picture'
                            // },
                            // inputValidator: (result) => {
                            //     console.log("upload-img-preview: ", result)
                            // },
                            html: '<div class="upload-img-preview" ><input type="file" class="pond-file" /></div>',
                            //html: '<div class="upload-img-preview" ></div>',
                            //footer: "<h3>Test</h3>",
                            didRender: () => {

                                // Create a FilePond instance
                                pond = FilePond.create( document.querySelector('.pond-file'), {
                                    instantUpload: false,
                                    allowProcess: false
                                });

                                //$(".swal2-actions").append("<input type='text' class='textbox-input' id='imge_msg_text_msg' />");
                                //$('.pond-file').filepond();
                            },
                            preConfirm: () => {
                                
                                pond.processFiles().then((files) => {
                                    // files have been processed
                                    console.log("pond.processFiles:", files)
                                    if(files.length > 0){
                                        Swal.close();
                                        Toast.fire({
                                            icon: 'success',
                                            title: 'uploaded in successfully'                 
                                        })

                                        return true;

                                    }
                                });
                                
                                 return false; // Prevent confirmed
                                
                            }
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                //Swal.fire('Changes are not saved', '', 'info')
                            } else if (result.isDenied) {
                                Swal.fire('Changes are not saved', '', 'info')
                            }
                        })
                        // $(".swal2-file").on("change", function(result) {
                        //     console.log("file result: ", result.target.files[0])
                        //     if (result.target.files[0]) {
                        //         const reader = new FileReader()
                        //         reader.onload = (e) => {
                        //             // Swal.fire({
                        //             // title: 'Your uploaded picture',
                        //             // imageUrl: e.target.result,
                        //             // imageAlt: 'The uploaded picture'
                        //             // })
                        //             let htmlImg = "<img src='" + e.target.result +
                        //                 "' height='200' >";
                        //             $(".upload-img-preview").html(htmlImg);
                        //         }
                        //         reader.readAsDataURL(result.target.files[0])
                        //     }
                        // })

                    }
                }
            });


            // $(".image-preview-area-btn").on("click", function(){
            //     var serialize_id = $(this).attr("data-serializedid");
            //     console.log("serialize_id:" , serialize_id);
            // });

            // $("#smiley-btn-id").on("click", function(){
            //     console.log("smiley-btn-id")
            // });


            // $(".msg-text-write-area .textbox-input");

            $("#new-chat-btn").on("click", function() {
                console.log("new chat");
                usersContant("new-chat", "");

            });

        })

        function usersContant(type, chat_msg_id) {
            $("body").addClass("loading");
            if (type === undefined) {
                console.log("usersContant type undefined");
                $("body").removeClass("loading");
                return false;
            }
            var title, isCheckbox = false;
            if (type == "new-chat") {
                title = "צ'אט חדש";
            } else if (type == "forword-msg") {
                title = "העברת הודעה אל"
                isCheckbox = true;
            } else {
                console.log("usersContant type unknown");
                $("body").removeClass("loading");
                return false;
            }
            //var;
            //console.time("usersContant");
            if (users_contants === undefined) {
                getUsersContants("usersContant('" + type + "', '" +chat_msg_id+"')");
                return false;
            }

            //console.log("users_contants", users_contants)
            var conent_html = getConentHtml(users_contants, title, true, isCheckbox);

            var slct_name;


            Swal.fire({
                title: title,
                html: conent_html,
                heightAuto: false,
                showConfirmButton: isCheckbox,
                showCloseButton: true,
                showDenyButton: isCheckbox,
                showCancelButton: false,
                confirmButtonText: 'שלח הודעה',
                denyButtonText: 'בטל',
                allowOutsideClick: false,
                customClass: {
                    popup: 'contact-list-swel'
                },
                // willOpen: () => {
                //     Swal.showLoading()
                // },
                didRender: () => {
                    $("body").removeClass("loading");
                    //console.timeEnd("usersContant");

                    $(".contact-item-wrapper-btn").on("click", function() {
                        var self_ = $(this);
                        var slct_user_id = self_.attr("data-userid");
                        console.log("contact-item-wrapper-btn", slct_user_id);
                        if (!isCheckbox) {
                            $(".users-group-cell-frame").each(function(i, userItem) {
                                var sidebar_user = $(userItem).attr("data-userid");
                                //console.log("sidebar_user : ", sidebar_user)
                                if (sidebar_user == slct_user_id) {
                                    $(this).click();
                                    Swal.close();
                                    return;
                                }
                            });
                            //not found => add to top
                            var slct_name = self_.parent().find(".contact-user-name-txt").text()
                            var slct_userserialized = self_.attr("data-userserialized");
                            var slct_isuser = self_.attr("data-isuser");
                            var slct_isgroup = (slct_isuser == "true") ? "no" : "yes";
                            var slct_img = self_.parent().find(".contact-user-img")[0];
                            var slct_img_src = (slct_img === undefined) ? "" : $(slct_img).attr("src");
                            console.log("slct_userserialized:", slct_userserialized, "slct_isgroup:",
                                slct_isgroup);
                            console.log("slcted_img:", slct_img_src);
                            //var slct_html = createUserChatHtml(slct_name, slct_user_id, slct_userserialized, slct_isgroup, slct_img);
                            //$(".users-group-list-item").prepend(slct_html);
                            //$(".users-group-list-item").find("#user_" + slct_user_id).click();


                            var user_id = event.detail.selected_user;
                            var is_group = event.detail.is_group;

                            $("#slected_current_user_id").val(slct_userserialized);
                            $("#slected_current_is_group").val(slct_isgroup);
                            $(".main-text-typing-area").show();

                            if (slct_img_src == "" || slct_img_src === undefined || slct_img_src ==
                                null) {
                                if ($(".main-head-img-wrapper .avater-img-container img").length > 0) {
                                    $(".main-head-img-wrapper .avater-img-container img").remove();
                                }
                            } else {
                                if ($(".main-head-img-wrapper .avater-img-container img").length > 0) {
                                    $(".main-head-img-wrapper .avater-img-container img").attr("src",slct_img_src);
                                } else {
                                    $("<img>", {
                                        src: slct_img_src,
                                        draggable: false,
                                        class: "user-real-img user-real-img-opcty-1 vsblty-vsbl"
                                    }).appendTo(".main-head-img-wrapper .avater-img-container");
                                }
                            }

                            //main-head-user-name
                            $(".main-head-user-name").html("<span class='user-name-txt'>" + slct_name +
                                "</span>");

                            Swal.close();

                        } else {
                            var chebox_el = self_.parent().find(".contact-item-checkbox");
                            var is_checked = chebox_el.is(":checked")
                            if (is_checked) {
                                chebox_el.prop("checked", false);
                                self_.parent().find(".contact-item-visual-checkbox-0-unchecked").show();
                                self_.parent().find(".contact-item-visual-checkbox-0-checked").hide();
                            } else {
                                chebox_el.prop("checked", true);
                                self_.parent().find(".contact-item-visual-checkbox-0-unchecked").hide();
                                self_.parent().find(".contact-item-visual-checkbox-0-checked").show();
                            }
                        }
                    });
                },


            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    var checked = $(".contact-item-checkbox:checkbox:checked");
                    var users_ary = [];
                    var users_obj = [];
                    $.each(checked, function(idx, usr){
                        var is_user = $(usr).data("isuser");
                        console.log("is_user: ", is_user)
                        var obj_ = {
                            id : $(usr).val(),
                            isGroup: ((is_user == true)?"no":"yes")
                        }
                        users_ary.push($(usr).val());
                        users_obj.push(obj_);
                    })

                    console.log("chat_msg_id: ", chat_msg_id , checked, users_ary)
                    forwordMsg(chat_msg_id , users_obj , users_ary);
                    /*
                    Swal.fire({
                        title: '<strong>HTML <u>example</u></strong>',
                        icon: 'info',
                        html: 'You can use <b>bold text</b>, ' +
                            '<a href="//sweetalert2.github.io">links</a> ' +
                            'and other HTML tags',
                        showCloseButton: true,
                        showCancelButton: true,
                        focusConfirm: false,
                        confirmButtonText: '<i class="fa fa-thumbs-up"></i> Great!',
                        confirmButtonAriaLabel: 'Thumbs up, great!',
                        cancelButtonText: '<i class="fa fa-thumbs-down"></i>',
                        cancelButtonAriaLabel: 'Thumbs down'
                    });
                    */
                } else if (result.isDenied) {
                    //Swal.fire('Changes are not saved', '', 'info')
                    Swal.close();
                }
            });
        }

        function forwordMsg(msg_id , users_obj , users_ary) {
            //console.log("getUsersContants")

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                data: {
                    msgId : msg_id,
                    users: JSON.stringify(users_ary)
                },
                url: '/wpp/forwordmsg',
                success: function(data) {
                    console.log("forwordMsg: ", data)
                    // if (data.all_contacts && data.all_contacts.status == "success") {
                    //     var all_contacts = data.all_contacts.response
                    //     //console.log("getUsersContants: ", all_contacts);
                        
                    // }
                }
            });
        }

        function createContentHtml(users_contants, showCheckBox) {
            if (users_contants === undefined) {
                return "";
            }
            if (showCheckBox === undefined) {
                showCheckBox = false;
            }
            var html = `
            <div class="contact-list-wrapper" tabindex="0">
            <div style="pointer-events: auto;">
            <div class="contact-list-container">
        `;
            var len = users_contants.length;
            var i = 0;
            while (len--) {
                var contact = users_contants[i];
                var user_img_url = ((contact.profilePic != "") ? contact.profilePic : sessionStorage.getItem("userpic_" +
                    contact.user_id))
                html += `
                <div class="contact-item-wrapper">
                    <button class="contact-item-wrapper-btn" type="button" 
                        data-isShowCheckbox="${showCheckBox}"
                        data-userid="${contact.user_id}"
                        data-userserialized="${contact.user_serialized}"
                        data-isuser="${contact.isUser}"
                    >`;
                if (showCheckBox) {
                    html += `<div class="contact-item-checkbox-wrapper">
                            <input class="contact-item-checkbox" type="checkbox" tabindex="-1" data-isuser="${contact.isUser}" value="${contact.user_id}">
                            <div class="contact-item-visual-checkbox" tabindex="-1" aria-hidden="true"
                                data-testid="visual-checkbox">
                                <!-- unchecked -->
                                <div class="contact-item-visual-checkbox-0 contact-item-visual-checkbox-0-unchecked ">
                                    <div class="contact-item-visual-checkbox-v contact-item-visual-checkbox-v-unchecked">
                                    </div>
                                </div> 
                                
                                <!-- checked -->
                                <div style="display:none;" class="contact-item-visual-checkbox-0 contact-item-visual-checkbox-0-checked">
                                    <div
                                        class="contact-item-visual-checkbox-v contact-item-visual-checkbox-v-checked">
                                    </div>
                                </div>
                            </div>
                        </div>`;
                }
                html += `<div tabindex="-1" aria-selected="true" role="row">
                            <div data-testid="cell-frame-container" class="contact-tem-container">

                                <div class="contact-avatar-area">
                                    <div class="contact-avatar-wrapper" style="height: 49px; width: 49px;">
                                        <div class="contact-default-user-avatar">
                                            <span data-testid="default-user" data-icon="default-user">
                                                <svg viewBox="0 0 212 212" width="212" height="212">
                                                    <path fill="#DFE5E7" class="background"
                                                        d="M106.251.5C164.653.5 212 47.846 212 106.25S164.653 212 106.25 212C47.846 212 .5 164.654.5 106.25S47.846.5 106.251.5z">
                                                    </path>
                                                    <g fill="#FFF">
                                                        <path class="primary"
                                                            d="M173.561 171.615a62.767 62.767 0 0 0-2.065-2.955 67.7 67.7 0 0 0-2.608-3.299 70.112 70.112 0 0 0-3.184-3.527 71.097 71.097 0 0 0-5.924-5.47 72.458 72.458 0 0 0-10.204-7.026 75.2 75.2 0 0 0-5.98-3.055c-.062-.028-.118-.059-.18-.087-9.792-4.44-22.106-7.529-37.416-7.529s-27.624 3.089-37.416 7.529c-.338.153-.653.318-.985.474a75.37 75.37 0 0 0-6.229 3.298 72.589 72.589 0 0 0-9.15 6.395 71.243 71.243 0 0 0-5.924 5.47 70.064 70.064 0 0 0-3.184 3.527 67.142 67.142 0 0 0-2.609 3.299 63.292 63.292 0 0 0-2.065 2.955 56.33 56.33 0 0 0-1.447 2.324c-.033.056-.073.119-.104.174a47.92 47.92 0 0 0-1.07 1.926c-.559 1.068-.818 1.678-.818 1.678v.398c18.285 17.927 43.322 28.985 70.945 28.985 27.678 0 52.761-11.103 71.055-29.095v-.289s-.619-1.45-1.992-3.778a58.346 58.346 0 0 0-1.446-2.322zM106.002 125.5c2.645 0 5.212-.253 7.68-.737a38.272 38.272 0 0 0 3.624-.896 37.124 37.124 0 0 0 5.12-1.958 36.307 36.307 0 0 0 6.15-3.67 35.923 35.923 0 0 0 9.489-10.48 36.558 36.558 0 0 0 2.422-4.84 37.051 37.051 0 0 0 1.716-5.25c.299-1.208.542-2.443.725-3.701.275-1.887.417-3.827.417-5.811s-.142-3.925-.417-5.811a38.734 38.734 0 0 0-1.215-5.494 36.68 36.68 0 0 0-3.648-8.298 35.923 35.923 0 0 0-9.489-10.48 36.347 36.347 0 0 0-6.15-3.67 37.124 37.124 0 0 0-5.12-1.958 37.67 37.67 0 0 0-3.624-.896 39.875 39.875 0 0 0-7.68-.737c-21.162 0-37.345 16.183-37.345 37.345 0 21.159 16.183 37.342 37.345 37.342z">
                                                        </path>
                                                    </g>
                                                </svg>
                                            </span>
                                        </div>`;
                if (user_img_url !== "" && user_img_url !== null && user_img_url !== undefined) {
                    html += `<img src="${user_img_url}"
                                            alt="" draggable="false" class="contact-user-img">
                                        `;
                }
                html += `</div>
                                </div>

                                <div class="contact-user-name-area">
                                    <div role="gridcell" aria-colindex="2" class="contact-user-name-wrap">
                                        <div class="contact-user-name-container">
                                            <span dir="auto" title="Yes-watsapp"
                                                class="contact-user-name-txt">${contact.name}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </button>
                </div>
            `;

                i++;
            }

            html += `
                        </div>
                    </div>
                </div>`;
            return html;
        }

        function getConentHtml(users_contants, title, toUpdate, isCheckbox) {
            var conent_html;
            var old_conent_html = sessionStorage.getItem("users_contants_html");
            if (!toUpdate && old_conent_html != "") {
                return old_conent_html;
            }
            conent_html = `
            <div class="chat-modal-wrapper  copyable-area" data-testid="chat-modal">
                <header class="chat-modal-header">
                    <!--
                    <div class="chat-modal-close">
                        <button class="chat-modal-close-btn" aria-label="סגירה">
                            <span data-testid="x" data-icon="x">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="currentColor"
                                        d="m19.1 17.2-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.4-5.3-5.3-1.8 1.7 5.3 5.3-5.3 5.3L6.7 19l5.3-5.3 5.3 5.3 1.8-1.8z">
                                    </path>
                                </svg>
                            </span>
                        </button>
                    </div>
                    -->
                    <div class="chat-modal-header-title">
                        <h1 style="font-size: inherit;">${title}</h1>
                    </div>
                </header>
                <!-- search area -->
                <div class="chat-modal-search" tabindex="-1">
                    <button class="chat-modal-search-btn" aria-label="חיפוש צ'אט או התחלת צ'אט חדש">
                        <div class="chat-modal-search-btn-icons chat-modal-search-btn-icon-back">
                            <span data-testid="back" data-icon="back">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="currentColor" d="m12 4 1.4 1.4L7.8 11H20v2H7.8l5.6 5.6L12 20l-8-8 8-8z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                        <div class="chat-modal-search-btn-icons chat-modal-search-btn-icon-search">
                            <span data-testid="search" data-icon="search">
                                <svg viewBox="0 0 24 24" width="24" height="24">
                                    <path fill="currentColor"
                                        d="M15.009 13.805h-.636l-.22-.219a5.184 5.184 0 0 0 1.256-3.386 5.207 5.207 0 1 0-5.207 5.208 5.183 5.183 0 0 0 3.385-1.255l.221.22v.635l4.004 3.999 1.194-1.195-3.997-4.007zm-4.808 0a3.605 3.605 0 1 1 0-7.21 3.605 3.605 0 0 1 0 7.21z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </button>
                    <span></span>
                    <div class="search-input-placeholder">חיפוש...</div>
                    <label class="search-input-label">
                        <div tabindex="-1" class="search-input-wrapper search-input-space">
                            <div title="תיבת טקסט להזנת החיפוש" role="textbox"
                                class="search-textbox-input copyable-text selectable-text" contenteditable="true"
                                oninput="searchChatUser(this)"
                                data-tab="3" dir="rtl">
                            </div>
                        </div>
                    </label>
                </div>`;
            conent_html += createContentHtml(users_contants, isCheckbox);
            conent_html += `
            <!-- footer -->
                
                <span class="send-to-footer">
                    <div class="send-to-wrapper" style="transform: translateY(0%);">
                        <span class="send-to-names-list">
                            <span dir="auto" class="send-to-name-txt">Yes-watsapp</span>
                        </span>
                        <div data-animate-btn="true" class="send-to-btn-con" style="opacity: 1; transform: scale(1);">
                            
                                <!--
                            <div role="button" tabindex="0" class="send-to-btn">
                                <span data-testid="send" data-icon="send" class="send-to-btn-icon">
                                    <svg viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="currentColor"
                                            d="M1.101 21.757 23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                                -->
                        </div>
                    </div>
                </span>
                
            </div>
        `;
            sessionStorage.setItem("users_contants_html", conent_html);
            return conent_html;
        }

        function getUsersContants(ret_func) {
            //console.log("getUsersContants")

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: '/wpp/contact',
                success: function(data) {
                    //console.log("getUsersContants: ", data)
                    if (data.all_contacts && data.all_contacts.status == "success") {
                        var all_contacts = data.all_contacts.response
                        //console.log("getUsersContants: ", all_contacts);
                        if (all_contacts.length > 0) {
                            var tmp_ary = [];
                            $.each(all_contacts, function(idx, contact) {
                                if (contact.isMe == false) {
                                    var contantObj = {
                                        name: contact.formattedName,
                                        user_id: contact.id.user,
                                        user_serialized: contact.id._serialized,
                                        isUser: contact.isUser,
                                        profilePic: (contact.profilePicThumbObj.eurl) ? contact
                                            .profilePicThumbObj.eurl : ""
                                    }
                                    getUserProfilePic(contact.id.user);
                                    tmp_ary.push(contantObj)
                                }
                            });
                            users_contants = tmp_ary;
                            eval(ret_func)
                            //console.log("getUsersContants: ", tmp_ary);
                        }
                    }
                }
            });
        }


        function getUserProfilePic(user_id) {
            //return "";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: '/wpp/contactpic/' + user_id,
                success: function(data) {
                    if (data.response && data.response.status == "success") {
                        //console.log("getUserProfilePic: ", data.response.response.eurl)
                        if (data.response.response.eurl) {
                            sessionStorage.setItem("userpic_" + user_id, data.response.response.eurl);
                            //return data.response.response.eurl
                        }
                    }
                }
            });
            return "";
        }


        function searchChatUser(obj) {
            var srchStr = $(obj).text();
            if (srchStr != "") {
                $(".search-input-placeholder").hide();
            } else {
                $(".search-input-placeholder").show();
            }
            //console.log($(obj).text())
            $(".contact-item-wrapper").each(function(idx, userItem) {
                var user_name = $(userItem).find(".contact-user-name-txt").text();
                //console.log("user_name: ", user_name)
                if (user_name.indexOf(srchStr) == -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        }








        function getReplayMsgContent(chatItem) {
            let chat_msg_serializedid = chatItem.data("serializedid");
            let sender_name = chatItem.find(".chat-msg-content .msg-sender-name").html();
            let msg_body = chatItem.find(".msg-text-content .copyable-text span").html();
            let image_preview = chatItem.find(".image-preview-wrapper");
            let image_preview_data = "";
            if (image_preview.length > 0) {
                //console.log("image_preview:", image_preview)
                image_preview_data = $(image_preview[0]).find("img").attr("src");
            }
            html = `<div class="relay-container-width">
                    <!--wire:model="repaly_msg_id"-->
                    <input type="hidden" id="repaly_msg_id" value="${chat_msg_serializedid}">
                    <div class="relay-container-btn-role" > 
                        <span class="relay-bg-color-1 relay-bg-flex"></span> 
                        <div class="relay-msg-wrapper">
                            <div class="relay-chat-msg-content">
                                <div class="msg-sender-details msg-sender-color" role="button"> 
                                    <span dir="auto" class="msg-sender-name text-visibility"> 
                                        ${sender_name} 
                                    </span> 
                                </div> 
                                <div class="relay-msg-text-content" dir="rtl" role="button"> 
                                    <span dir="auto" class="quoted-mention text-visibility">
                                        ${msg_body}
                                    </span> 
                                </div>
                            </div> 
                        </div>`;
            if (image_preview_data != "") {
                html += `<div class="replay-img-wrapper">
                                <div class="replay-img-content">
                                    <div class="replay-img-row">
                                        <div class="replay-img-container">
                                            <div class="img-content"
                                                style="background-image: url(&quot;${image_preview_data}&quot;);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
            }
            html += '</div>' +
                '</div>';

            return html;
        }

        function getMsgMediaData(msg_serialized_id, type, mimetype) {
            let elem_id = msg_serialized_id.split("@")[1].split("_")[1];
            //let imagBase64 = sessionStorage.getItem(msg_serialized_id);
            //console.log("msg_serialized_id:",msg_serialized_id,"imagBase64: " , imagBase64)
            //localforage.setItem(serialize_id, imagBase64);
            localforage.getItem(msg_serialized_id, function(err, imagBase64) {
                // if err is non-null, we got an error. otherwise, value is the value
                if (err == null) {

                    //console.log("getMsgMediaData: ", type, elem_id, imagBase64);
                    if (imagBase64 != null) {
                        if (type == "image") {
                            //'<img src="data:' + msg.mimetype + ';base64,' + msg.body + '" class="image-preview-noloaded-img" >' 
                            //$("#prev_img_" + elem_id).attr("src",imagBase64).css("zIndex", "9999");
                            //prev_img_FB0F2C048774C20C5B65137462FB312D
                            setTimeout(function(elem_id, imagBase64) {
                                //console.log("getMsgMediaData setTimeout:", elem_id, imagBase64)
                                $("#prev_img_" + elem_id).attr("src", imagBase64);
                                $("#prev_img_" + elem_id).attr("onclick", `magnificImage('${imagBase64}')`);
                                $("#prev_img_" + elem_id).parent().find(".overlay").remove();
                                //$("#prev_img_" + elem_id).parent().parent().removeAttr("onclick");
                            }, 1000, elem_id, imagBase64);
                        } else if (type == "video" || type == "audio" || type == "ptt" || type == "document") {
                            //$("#prev_media_" + media_dom_id + " source").attr("src", objectURL);
                            //sessionStorage.setItem(serialize_id, objectURL)
                            //$("#prev_media_" + elem_id + " source").prop("src",imagBase64);
                            //$("#prev_media_" + elem_id )[0].load();
                            fetch(imagBase64)
                                .then(function(res) {
                                    return res.blob();
                                })
                                .then(function(imgBlob) {
                                    var objectURL = URL.createObjectURL(imgBlob);
                                    if(type != "document"){
                                        //audio, ptt, video
                                        $("#prev_media_" + elem_id + " source").attr("src", objectURL);
                                        //sessionStorage.setItem(serialize_id, objectURL)
                                        $("#prev_media_" + elem_id).parent().find(".overlay").remove();
                                        //$("#prev_media_" + elem_id).parent().parent().parent().removeAttr("onclick");
                                        $("#prev_media_" + elem_id)[0].load();
                                    }else{
                                        //document
                                        console.log("document: ", elem_id , objectURL)
                                        setTimeout(function(elem_id, objectURL) {
                                            $("#prev_doc_" + elem_id).attr("href", objectURL);//[0].click();
                                            $("#prev_doc_" + elem_id).parent().addClass('document-overly');
                                            $("#prev_doc_" + elem_id).parent().parent().attr("onclick", "openDocument(this)")
                                            $("#prev_doc_" + elem_id).parent().find(".overlay").remove();
                                        }, 500, elem_id, objectURL);
                                    }
                                });
                        }
                    }else{
                        setTimeout(function(serialized_id, elem_id, type,mimetype) {
                                //onclick
                            var overlay = `<div class="overlay" onclick="onMediaClick(this, '${serialized_id}', '${mimetype}', '${type}')">
                                                <span class="icon">
                                                    <i class="fa fa-arrow-circle-down"></i>
                                                </span>
                                            </div>`;
                            if(type == "image"){
                                $("#prev_img_" + elem_id).after(overlay);
                            }else if(type == "video" || type == "audio" || type == "ptt"){
                                $("#prev_media_" + elem_id).after(overlay);
                            }else if(type == "document"){
                                $("#prev_doc_" + elem_id).after(overlay);
                            }
                        }, 1000,msg_serialized_id, elem_id, type,mimetype);
                        
                    }
                }
            });

            return "";
        }

        function magnificImage(img_src){
            //console.log("magnificImage")
            $.magnificPopup.open({
                items: {
                    src: img_src
                },
                type: 'image'
            });
        }

        function openDocument(obj){
            //console.log("openDocument: ", obj)
            $(obj).find("a")[0].click();
        }

        function onMediaClick(obj, serialize_id, mimetype, type) {
            //$(obj).removeClass("overlay")
            $(obj).html("")
            $(obj).addClass("media-loading")
            //let sessionImg = "";
            //let elem_id = serialize_id.split("@")[1].split("_")[1];
            //if (type != "video" && type != "audio" && type != "ptt") {
            // if (type == "image") {
            //     sessionImg = getMsgMediaData(serialize_id, type, mimetype);
            // }

            // let prev_img = (type != "video" && type != "audio" && type != "ptt") ? $("#prev_img_" + elem_id).attr(
            //     "src") : "";
            // let prev_img = (type == "image") ? $("#prev_img_" + elem_id).attr("src") : "";
            // console.log("prev_img:", prev_img, type, sessionImg);
            // if (sessionImg != "" && sessionImg !== undefined && prev_img == "") {
            //     $("#prev_img_" + elem_id).attr("src", sessionImg);
            //     $("#prev_img_" + elem_id).parent().find(".overlay").remove();
            //     return true;
            // }
            // if (prev_img != "") {
            //     $.magnificPopup.open({
            //         items: {
            //             src: prev_img
            //         },
            //         type: 'image'
            //     });

            //     return true;
            // }

            getImgAjax(serialize_id, mimetype, type);
            //console.log("sessionImg:", sessionImg);

        }

        function getImgAjax(serialize_id, mimetype, type) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'GET',
                url: '/wpp/msg/' + serialize_id,
                // data: {
                //     user_id : userId,
                //     is_group: isGroup
                // },
                success: function(data) {
                    //$("#msg").html(data.msg);
                    console.log("getImgAjax:", serialize_id);
                    if (data.status && data.status == "success") {
                        var jsonObj = JSON.parse(data.base64);
                        //console.log("jsonObj:", jsonObj.base64);
                        let imageDataURL = "data:" + mimetype + ";base64," + jsonObj.base64.replace(/"/g, "");
                        //$("#prev_img_" + serialize_id.split("@")[1].split("_")[1]).attr("src", imageDataURL);
                        // console.log( blob);
                        //sessionStorage.setItem(serialize_id, imageDataURL);
                        localforage.setItem(serialize_id, imageDataURL, function (err) {
                            if(err == null){
                                getMsgMediaData(serialize_id, type, mimetype);
                            }else{
                                //show error - TODO
                            }
                        });


                        // if (type == "image") {
                        //     var img_prev_id = serialize_id.split("@")[1].split("_")[1]; 
                        //     $("#prev_img_" + img_prev_id).attr("src", imageDataURL);
                        //     $("#prev_img_" + img_prev_id).parent().find(".overlay").remove();
                                
                        //     //sessionStorage.setItem(serialize_id, imageDataURL)
                        // } else {
                        //     fetch(imageDataURL)
                        //         .then(function(res) {
                        //             return res.blob();
                        //         })
                        //         .then(function(imgBlob) {
                        //             var objectURL = URL.createObjectURL(imgBlob);
                        //             let media_dom_id = serialize_id.split("@")[1].split("_")[1];
                        //             if(type != "document"){
                        //                 $("#prev_media_" + media_dom_id + " source").attr("src", objectURL);
                        //                 //sessionStorage.setItem(serialize_id, objectURL)
                        //                 $("#prev_media_" + media_dom_id)[0].load();
                        //                 $("#prev_media_" + media_dom_id).parent().find(".overlay").remove();
                        //             }else{

                        //                 $("#prev_doc_" + media_dom_id).attr("href", objectURL);//[0].click();
                        //                 $("#prev_doc_" + media_dom_id).parent().addClass('document-overly');
                        //                 $("#prev_doc_" + media_dom_id).parent().parent().attr("onclick", "openDocument(this)")
                        //                 $("#prev_doc_" + media_dom_id).parent().find(".overlay").remove();
                        //             }
                        //         })
                        // }
                    }

                },
                error: function(response) {
                    //show error - TODO
                    console.log("getImgAjax (ajax error):", serialize_id, response.responseText);
                }
            });
        }

        function scrollToElem(elem_id, option) {
            let defaultOptions = {
                behavior: "smooth",
                block: "end"
            }

            if (option !== null && option !== undefined) {
                defaultOptions = option;
            }

            if (elem_id != "" && elem_id !== null && elem_id !== undefined) {
                var element = document.getElementById(elem_id);
                if (element !== null)
                    element.scrollIntoView(defaultOptions); //, block: "end", inline: "nearest"
                else
                    console.log(`elemnet with id ${elem_id}: no found`)
            }

        }

        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        function un_escapeHtml(safe) {
            if (safe === null) return "";
            return safe
                .replace(/&amp;/g, "&")
                .replace(/&lt;/g, "<")
                .replace(/&gt;/g, ">")
                .replace(/&quot;/g, '"')
                .replace(/&#039;/g, "'");
        }
        //twemoji.parse(document.body);
    </script>
@endsection
