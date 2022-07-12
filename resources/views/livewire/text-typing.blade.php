<footer class="main-text-typing-area">
    <div class="vsblty-vsbl copyable-area">
        <div>
            <span>
                <div class="main-text-typing-container">
                    <div class="main-text-typing-smily-area main-text-typing-smily-area-view">
                        <div data-state="closed" role="button" class="smiley-btn btn-width">

                            <button tabindex="-1" class="smiley-close-btn"
                                aria-label="סגירת חלונית" data-tab="10">
                                <div>
                                    <span data-testid="x" data-icon="x" class="">
                                        <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                            <path fill="currentColor"
                                                d="m19.1 17.2-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.4-5.3-5.3-1.8 1.7 5.3 5.3-5.3 5.3L6.7 19l5.3-5.3 5.3 5.3 1.8-1.8z">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                            </button>

                            <button tabindex="-1" class="btn-width emojis-btn" id="smiley-btn-id"
                                aria-label="Open emojis panel" data-tab="9"
                                style="transform: translateX(0px);">
                                <div>
                                    <span data-testid="smiley" data-icon="smiley" class="">
                                        <svg viewBox="0 0 24 24" width="24" height="24">
                                            <path fill="currentColor"
                                                d="M9.153 11.603c.795 0 1.439-.879 1.439-1.962s-.644-1.962-1.439-1.962-1.439.879-1.439 1.962.644 1.962 1.439 1.962zm-3.204 1.362c-.026-.307-.131 5.218 6.063 5.551 6.066-.25 6.066-5.551 6.066-5.551-6.078 1.416-12.129 0-12.129 0zm11.363 1.108s-.669 1.959-5.051 1.959c-3.505 0-5.388-1.164-5.607-1.959 0 0 5.912 1.055 10.658 0zM11.804 1.011C5.609 1.011.978 6.033.978 12.228s4.826 10.761 11.021 10.761S23.02 18.423 23.02 12.228c.001-6.195-5.021-11.217-11.216-11.217zM12 21.354c-5.273 0-9.381-3.886-9.381-9.159s3.942-9.548 9.215-9.548 9.548 4.275 9.548 9.548c-.001 5.272-4.109 9.159-9.382 9.159zm3.108-9.751c.795 0 1.439-.879 1.439-1.962s-.644-1.962-1.439-1.962-1.439.879-1.439 1.962.644 1.962 1.439 1.962z">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                            </button>
                        </div>
                        <div class="file-attach-btn">
                            <div class="menu-btn-container">
                                <div id="attachment-btn" aria-disabled="false" role="button" tabindex="0"
                                    class="btns-content" data-tab="9" title="Attach"
                                    aria-label="Attach">
                                    <span data-testid="clip" data-icon="clip" class="">
                                        <svg viewBox="0 0 24 24" width="24" height="24"
                                            class="">
                                            <path fill="currentColor"
                                                d="M1.816 15.556v.002c0 1.502.584 2.912 1.646 3.972s2.472 1.647 3.974 1.647a5.58 5.58 0 0 0 3.972-1.645l9.547-9.548c.769-.768 1.147-1.767 1.058-2.817-.079-.968-.548-1.927-1.319-2.698-1.594-1.592-4.068-1.711-5.517-.262l-7.916 7.915c-.881.881-.792 2.25.214 3.261.959.958 2.423 1.053 3.263.215l5.511-5.512c.28-.28.267-.722.053-.936l-.244-.244c-.191-.191-.567-.349-.957.04l-5.506 5.506c-.18.18-.635.127-.976-.214-.098-.097-.576-.613-.213-.973l7.915-7.917c.818-.817 2.267-.699 3.23.262.5.501.802 1.1.849 1.685.051.573-.156 1.111-.589 1.543l-9.547 9.549a3.97 3.97 0 0 1-2.829 1.171 3.975 3.975 0 0 1-2.83-1.173 3.973 3.973 0 0 1-1.172-2.828c0-1.071.415-2.076 1.172-2.83l7.209-7.211c.157-.157.264-.579.028-.814L11.5 4.36a.572.572 0 0 0-.834.018l-7.205 7.207a5.577 5.577 0 0 0-1.645 3.971z">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- msg text write area -->
                    <div class="msg-text-write-area-wrapper">
                        <input type="hidden" id="slected_current_user_id" />
                        <input type="hidden" id="slected_current_is_group"  />
                        {{-- <textarea id="txt_hlder" style="display: none;" ></textarea> --}}
                        <div tabindex="-1" class="msg-text-write-area">
                            <div tabindex="-1" class="textbox-container textbox">
                                <div class="textbox-placeholder" id="textbox_placeholde" style="visibility: visible">
                                    Type a message </div>
                                <div id="main_msg_textbox" title="Type a message" role="textbox"
                                    class="textbox-input main-textbox-input copyable-text selectable-text"
                                    contenteditable="true" data-tab="9" dir="ltr"
                                    spellcheck="true">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Voice message button -->
                    <div class="voice-msg-btn-wrapper">
                        <button class="voice-msg-btn" aria-label="Voice message" data-tab="11">
                            <span data-testid="ptt" data-icon="ptt" class="">
                                <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                    <path fill="currentColor"
                                        d="M11.999 14.942c2.001 0 3.531-1.53 3.531-3.531V4.35c0-2.001-1.53-3.531-3.531-3.531S8.469 2.35 8.469 4.35v7.061c0 2.001 1.53 3.531 3.53 3.531zm6.238-3.53c0 3.531-2.942 6.002-6.237 6.002s-6.237-2.471-6.237-6.002H3.761c0 4.001 3.178 7.297 7.061 7.885v3.884h2.354v-3.884c3.884-.588 7.061-3.884 7.061-7.885h-2z">
                                    </path>
                                </svg>
                            </span>
                        </button>
                    </div>


                    <!-- Send message button -->
                    <div class="send-msg-btn-wrapper">
                        {{-- wire:click.stop="sendMessage('{{$send_to}}','{{$isgroup}}')" --}}
                        <button class="send-msg-btn" onclick="sendTextMsg()">
                            <span data-testid="send" data-icon="send" class="send-msg-btn-icon">
                                <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                    <path fill="currentColor"
                                        d="M1.101 21.757 23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z">
                                    </path>
                                </svg>
                            </span>
                        </button>
                    </div>


                </div>
            </span>
        </div>
    </div>


    <!-- text msg action area -->
    <div class="text_msg_action_area">
        <div class="text_msg_action_wrapper">

            <!-- emoji area -->
            <div class="wasap-emoji-area">
                <div class="wasap_emoji">
                    <emoji-picker></emoji-picker>
                </div>
            </div>

                <!-- replay msg preview area -->
            <div class="replay_msg_preview_area">
                <div style="transform: translateY(0px);" class="">
                    <div class="replay_msg_preview_wrapper">
                        <div class="replay_msg_preview_content">

                            <!-- get inner html of .relay-container-->
                                <!--                                                     
                            <div class="relay-container-width">
                            ...  
                            </div>
                            -->
                        </div>

                        <div class="close_replay_msg_btn">
                            <div role="button" class="close_replay_msg_btn_btn">
                                <span data-testid="x" data-icon="x" class="">
                                    <svg viewBox="0 0 24 24" width="24" height="24" class="">
                                        <path fill="currentColor"
                                            d="m19.1 17.2-5.3-5.3 5.3-5.3-1.8-1.8-5.3 5.4-5.3-5.3-1.8 1.7 5.3 5.3-5.3 5.3L6.7 19l5.3-5.3 5.3 5.3 1.8-1.8z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div style="display: none;" hidden=""></div>
                </div>
            </div>
        </div>
    </div>
    <script>   
        window.addEventListener('clean_send_msg_filesd', event => {
            // console.log("clean_send_msg_filesd", "{{url('emoji-mart-outside-react/dist/main.js')}}")
           // reload_js("{{url('emoji-mart-outside-react/dist/main.js')}}")

        });
        $("#main_msg_textbox").on("input", function(e){
            //console.log($(this).val())
            if($(this).html() != ""){
                //$(".msg-text-write-area .textbox-placeholder").hide();
                $("#textbox_placeholde").hide();
                //$(this).val(twemoji.parse($(this).val())) ;

            }else{
                $("#textbox_placeholde").show();
            }

        });
        
        $("#main_msg_textbox").keydown(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);
            //var dummy = "\xAD";

            if (keycode == 13 && event.altKey) {
                
                sendTextMsg();

                console.log("enter + alt - send msg")
                return true;
                //console.log("only enter")
                //return false;
            }
            
        });
        $(".close_replay_msg_btn_btn").on("click", function(){
            $(".replay_msg_preview_area").hide();
            $(".replay_msg_preview_content").html("");
            chat_replat_msg_serializedid = "";
        });

        
    function sendTextMsg(){
        //main_msg_textbox
        //let txtMsg = $("#main_msg_textbox").text();
        var current_user = $("#slected_current_user_id").val();
        var current_is_group = $("#slected_current_is_group").val();
        var repaly_msg_id = $("#repaly_msg_id").val();
        repaly_msg_id = (repaly_msg_id === undefined)?"":repaly_msg_id;
        let txtMsg = $("#main_msg_textbox").html();
        if(txtMsg == "" || current_user == "" || current_is_group == "" ){
            return false;
        }
        //var sendTo = currnt_chat_id;

        //console.log(txtMsg)

        //txtMsg = escapeHtml(txtMsg);
        //console.log("send to:", current_user , current_is_group);
        //console.log("repaly to:", repaly_msg_id);


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/wpp/sendmsg',
            data: {
                send_to : current_user.replace(/[@c.us,@g.us]/g, ""),
                is_group: current_is_group,
                repaly_msg_id: repaly_msg_id,
                msg_body: txtMsg
            },
            success:function(data) {
                //console.log("send status msg :", data);
                $("#main_msg_textbox").html("");
                if(repaly_msg_id != ""){
                    $(".close_replay_msg_btn_btn").click();
                }
                if(data != "" && data !== null && data !== undefined){
                    if(data.response && data.response.status && data.response.status == "success"){
                        // let msg = data.response.response[0];
                        // let isGroup = (is_current_group == "yes")?true:false;
                        // let html_data = createMsgHtml(msg, isGroup);
                        // $(".chat-container-region").append(html_data[0])
                        // setMsgsTail();
                        // scrollToElem(html_data[1]);
                    }
                }
                //createSendMsgHtml(msg, isGroup)
            },
            error: function(reponse){
                // $("#main_msg_textbox").html("");
                // if(repaly_msg_id != ""){
                //     $(".close_replay_msg_btn_btn").click();
                // }
            }
        });
    }

    </script>
</footer>
