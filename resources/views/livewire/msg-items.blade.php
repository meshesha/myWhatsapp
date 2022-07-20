{{-- wire:poll.3s="checkMsg" --}}
<div tabindex="-1" class="chat-container-region" data-tab="8" role="region"  >
    <!-- chat-items -->
    {{--dump($msg_items)--}}
    @if($msg_items && $msg_items != null && $msg_items != "")
        @foreach($msg_items as $msg)
            @php
                $in_or_out = 'message-in';
                $tail_data = "tail-out";
                $elem_id = $msg['id'];
                $img_elem_ary1 = explode("@", $elem_id);
                $img_elem_ary2 = explode("_", $img_elem_ary1[1]);
                $img_elem_id = $img_elem_ary2[1];
            @endphp
            <!-- //var tail_class = "chat-item-tail" -->
            @if($msg['fromMe'])
                @php
                    $in_or_out = 'message-out';
                    $tail_data = 'tail-in';
                @endphp
            @endif
            <div tabindex="-1" class="chat-item focusable-list-item {{$in_or_out}} " data-id="{{$elem_id}}" id="{{$elem_id}}" data-serializedid="{{$elem_id}}">
                <!-- <input type="hidden" class="chat-id" value="{{$elem_id}}" > -->
                <!-- <span></span>  //? -->
                <div class="chat-item-content chat-item-wide chat-item-shape"> 
                    @if(!isset($msg['quotedMsg']))
                        <span data-testid="{{$tail_data}}" data-icon="{{$tail_data}}" class="chat-item-tail"></span> 
                    @endif
                    <div class="chat-msg-container chat-msg-container-shadow">  
                        <div class="chat-msg-content">  
                            <div class="msg-sender-details msg-sender-color " role=""> 
                                <span dir="auto" class="msg-sender-name msg-sender-cursor text-visibility">  
                                    {{(($msg['sender'])?$msg['sender']['formattedName']:$msg['from'])}}  
                                </span>  
                            </div>  
                            <div class="msg-text-container copyable-text" data-pre-plain-text="">
                            
                                @if(isset($msg['quotedMsg']) && in_array($msg['quotedMsg']['type'] , $types_arry))
                                    <!-- //msg.quotedParticipant
                                    //msg.quotedMsgId
                                    //msg.quotedMsg.type
                                    //msg.quotedMsg.body -->
                                    <div class="relay-container"> 
                                        <div class="relay-container-width">  
                                            <div class="relay-container-btn-role" role="button" onclick="scrollToElem('{{$msg['quotedMsgId']}}')">  
                                                <span class="relay-bg-color-1 relay-bg-flex"></span>  
                                                <div class="relay-msg-wrapper">  
                                                    <div class="relay-chat-msg-content">  
                                                        <div class="msg-sender-details msg-sender-color" role="button">  
                                                            <span dir="auto" class="msg-sender-name text-visibility">  
                                                                {{$msg['quotedParticipant']}}  
                                                            </span>  
                                                        </div>  
                                                        <div class="relay-msg-text-content" dir="rtl" role="button">  
                                                            <span dir="auto" class="quoted-mention text-visibility">  
                                                                {{ (($msg['quotedMsg']['type'] == "image" || $msg['quotedMsg']['type'] == "video")?$msg['quotedMsg']['caption']:$msg['quotedMsg']['body']) }} 
                                                            </span>  
                                                        </div> 
                                                    </div>  
                                                </div>
                                                @if($msg['quotedMsg']['type'] == "image" || $msg['quotedMsg']['type'] == "video")
                                                    <div class="replay-img-wrapper"> 
                                                        <div class="replay-img-content"> 
                                                            <div class="replay-img-row"> 
                                                                <div class="replay-img-container"> 
                                                                    <div class="img-content" 
                                                                        style="background-image: url(&quot;data:{{$msg['quotedMsg']['mimetype']}};base64,{{--$msg['quotedMsg']['body']--}}&quot;);">  
                                                                    </div> 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div> 
                                        </div> 
                                    </div>
                                @endif
                                @if($msg['type'] == "image" ||  $msg['type'] == "video" || $msg['type'] == "audio" || $msg['type'] == "ptt" || $msg['type'] == "document")
                                    
                                    <div role="button" class="image-preview-area-btn"  style="width:330px;height:330px;"> 
                                        <div class="image-preview-area-container">
                                            {{-- onclick="onMediaClick('{{$elem_id}}','{{$msg['mimetype']}}','{{$msg['type']}}')" --}}
                                            <div class="image-preview-wrapper" >
                                                <img src="data:{{$msg['mimetype']}};base64,{{($msg['body'] ??'')}}  " class="image-preview-noloaded-img" >  
                                            </div>
                                            <div class="image-preview-wrapper image-preview-loaded-img">
                                                @if($msg['type'] == "image")
                                                    {{-- onerror="getMsgMediaData('{{$elem_id}}','{{$msg['type']}}')" --}}
                                                    <img id="prev_img_{{$img_elem_id}}"  src="" >
                                                @endif

                                                @if($msg['type'] == "video")
                                                    <!-- let vdo_src = getMsgMediaData({{$elem_id}}) -->
                                                    <video id="prev_media_{{$img_elem_id}}" controls>  
                                                        <source  src="{{--vdo_src--}}" >  
                                                    </video>
                                                @endif

                                                @if($msg['type'] == "audio" || $msg['type'] == "ptt")
                                                    <!-- let vdo_src = getMsgMediaData({{$elem_id}}) -->
                                                    <audio id="prev_media_{{$img_elem_id}}" controls >  
                                                        <source  src="" >  
                                                    </audio>
                                                @endif
                                                @if($msg['type'] == "document")
                                                    {{-- class="document-overly" --}}
                                                    <div>
                                                        <a id="prev_doc_{{$img_elem_id}}"  href="#" target="_blink"  class="icon">
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                            <script>
                                                // setTimeout(function(elem_id, type, mimetype){
                                                //     getMsgMediaData(elem_id,type, mimetype);
                                                // },250, "{{$elem_id}}","{{$msg['type']}}", "{{$msg['mimetype']}}")
                                                getMsgMediaData("{{$elem_id}}","{{$msg['type']}}", "{{$msg['mimetype']}}");
                                            </script>
                                        </div>
                                    </div>
                                @endif
                                <div class="msg-text-content">  
                                    <span dir="auto" class="text-visibility selectable-text copyable-text">  
                                        <span>  {{(($msg['type'] == "image" || $msg['type'] == "video" || $msg['type'] == "document")?((!isset($msg['caption']))?"":$msg['caption']):(($msg['type'] =="audio" || $msg['type'] =="ptt")?"":((!isset($msg['body']))?"":$msg['body'])  ))}}</span>
                                    </span>
                                    <span class="msg-text-foot-spacer"></span>  
                                </div> 
                            </div>  
                            <div class="msg-text-foot">  
                                <div class="msg-time-container" data-testid="msg-meta">  
                                    <span class="msg-time-text" dir="auto">  
                                        {{ date('d-m-Y H:i:s', (int)$msg['t']) }}  
                                    </span>  
                                </div>  
                            </div> 
                        </div>  
                        <!-- <span>on hover item create arrow down button</span>   -->
                    </div>  
                </div> 
            </div>
        @endforeach
        <div  id="scroll_down_pos"></div>
    @endif
    <script>
        var all_msgs = htmlDecode('{{ json_encode($msg_items??'') }}');
        var msgs_json_obj;
        var msgIntervalId;
        try{
            msgs_json_obj = JSON.parse(all_msgs); 
        }catch(e){}

        function htmlDecode(value) {
            return $("<textarea/>").html(value).text();
        }

        window.addEventListener('msgs-loaded', event => {

            var old_hash = event.detail.hash;
            var user_id = event.detail.selected_user;
            var is_group = event.detail.is_group;
            
            console.log('msg loaded with hash: ' , old_hash , user_id , is_group);
            localforage.setItem('old_hash', old_hash, function(){
                setChatTimer(user_id, is_group);
                //reload_js("{{url('emoji-mart-outside-react/dist/main.js')}}")
                $("#slected_current_user_id").val(user_id);
                //document.getElementById("slected_current_user_id").dispatchEvent(new Event('input'));
                $("#slected_current_is_group").val(is_group);
                //document.getElementById("slected_current_is_group").dispatchEvent(new Event('input'));

                $(".main-text-typing-area").show();
                msgLoadActions();
                //processAllMsgs(msgs_json_obj);

            })
        });

        // window.addEventListener('new-msgs-loaded', event => {

        //     var old_hash = event.detail.hash;
        //     var user_id = event.detail.selected_user;
        //     var is_group = event.detail.is_group;
            
        //     console.log('new-msgs-loaded: ' , old_hash , user_id , is_group);
        //     msgLoadActions();
        //     processAllMsgs(msgs_json_obj);
        // })

        // window.addEventListener('check-msgs', event => {
        //     var hash = event.detail.new_hash;
        //     var user = event.detail.current_user;
        //     var is_group = event.detail.is_group;
        //     console.log('new_hash: ' + hash , "current_user: " + user, "is_group: " + is_group);
            
        // });

        function setMsgsTail(){
            var svg_tail_out_ltr = '<svg viewBox="0 0 8 13" width="8" height="13"><path opacity=".13" d="M5.188 1H0v11.193l6.467-8.625C7.526 2.156 6.958 1 5.188 1z"></path><path fill="currentColor" d="M5.188 0H0v11.193l6.467-8.625C7.526 1.156 6.958 0 5.188 0z"></path></svg>';
            var svg_tail_out_rtl = '<svg viewBox="0 0 8 13" width="8" height="13"><path opacity=".13" fill="#0000000" d="M1.533 3.568L8 12.193V1H2.812C1.042 1 .474 2.156 1.533 3.568z" ></path><path fill="currentColor" d="M1.533 2.568L8 11.193V0H2.812C1.042 0 .474 1.156 1.533 2.568z"></path></svg>';
            //var svg_tail_in_ltr =   '<svg viewBox="0 0 8 13" width="8" height="13"><path opacity=".13" fill="#0000000" d="M1.533 3.568L8 12.193V1H2.812C1.042 1 .474 2.156 1.533 3.568z"></path><path fill="currentColor" d="M1.533 2.568L8 11.193V0H2.812C1.042 0 .474 1.156 1.533 2.568z"></path></svg>';
            //var svg_tail_in_rtl =   '<svg viewBox="0 0 8 13" width="8" height="13"><path opacity=".13" d="M5.188 1H0v11.193l6.467-8.625C7.526 2.156 6.958 1 5.188 1z"></path><path fill="currentColor" d="M5.188 0H0v11.193l6.467-8.625C7.526 1.156 6.958 0 5.188 0z"></path></svg >';

            var doc_dir = $("html").attr("dir");
            if (doc_dir == "rtl" || doc_dir == "RTL") {
                $(".message-out .chat-item-content .chat-item-tail").html(svg_tail_out_rtl);
                $(".message-in .chat-item-content .chat-item-tail").html(svg_tail_out_ltr);
            } else {
                $(".message-out .chat-item-content .chat-item-tail").html(svg_tail_out_ltr);
                $(".message-in .chat-item-content .chat-item-tail").html(svg_tail_out_rtl);
            }
        }

        function msgLoadActions(){
            setMsgsTail();

            setTimeout(function() {    
                scrollToElem("scroll_down_pos",{
                    block: "end"
                });
                $("body").removeClass("loading");
            }, 500);
        }

        function setChatTimer(userSrializeId, isGroup){
            if(msgIntervalId !== undefined){
                clearInterval(msgIntervalId);
            }
            //getMessages(userSrializeId, isGroup);
            msgIntervalId = setInterval(function(user_id, is_group){
                //console.log(user_id, is_group)
                getMessages(user_id, is_group);
            },1000, userSrializeId, isGroup);

            //$(".msg-text-content").emojioneArea()
        }

        function getMessages(userId, isGroup) {
            //console.log(userId)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/wpp/chatmsg',
                data: {
                    user_id : userId,
                    is_group: isGroup
                },
                success:function(data) {
                    //$("#msg").html(data.msg);
                    //console.log(data);
                    if(data.status == "success"){
                        var new_hash = data.chats_md5;
                        localforage.getItem('old_hash', function(err,  old_hash){
                            if(old_hash != new_hash){
                                window.Livewire.emit('checkChatMsgsHash', new_hash)
                                localforage.setItem('old_hash', new_hash, function(){
                                    //processAllMsgs(data.response.response);
                                    msgLoadActions();
                                });
                            }
                        });
                    }
                    //getMoreMsgs(userId,isGroup);

                    
                }
            });
        }
    </script>
</div>


@section('above_livewire_foot_script')
{{-- section('foot_script') --}}
    <script>
        

        //processAllMsgs();

        function processAllMsgs(msgs_json_obj){
            console.log("msgs_json_obj:", msgs_json_obj)
            if(msgs_json_obj !== undefined && msgs_json_obj.length > 0){
                msgs_json_obj.forEach(function(msg){
                    //getMsgMediaData("{$elem_id}","{$msg['type']}", "{$msg['mimetype']}");
                    var elem_id = msg.id;
                    var type = msg.type;
                    var mimetype = msg.mimetype;
                    //console.log("elem_id:", elem_id, "type: ", type , "mimetype: ", mimetype);
                    getMsgMediaData(elem_id, type, mimetype);
                })
            }
        }

        // function reload_js(src) {
        //     $('script[src="' + src + '"]').remove();
        //     $('<script>').attr('src', src).appendTo('head');
        // }


    </script>
@endsection
