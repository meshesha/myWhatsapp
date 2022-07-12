<div tabindex="-1" class="chat-container-region" data-tab="8" role="region"  wire:poll.1s="checkMsg">
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
                                @if($msg['type'] == "image" ||  $msg['type'] == "video" || $msg['type'] == "audio"|| $msg['type'] == "ptt")
                                    <div role="button" class="image-preview-area-btn" onclick="onImageClick(this,'{{$elem_id}}','{{$msg['mimetype']}}','{{$msg['type']}}')" style="width:330px;height:330px;"> 
                                        <div class="image-preview-area-container">  
                                            <div class="image-preview-wrapper">
                                                
                                                <img src="data:{{$msg['mimetype']}};base64,{{($msg['body'] ??'')}}  " class="image-preview-noloaded-img" >  
                                            </div>
                                            <div class="image-preview-wrapper image-preview-loaded-img">
                                                @if($msg['type'] == "image")
                                                    <img id="prev_img_{{$img_elem_id}}" src="  getMsgImageBlob({{$elem_id}})  " >
                                                @endif

                                                @if($msg['type'] == "video")
                                                    <!-- let vdo_src = getMsgImageBlob({{$elem_id}}) -->
                                                    <video id="prev_media_{{$img_elem_id}}" controls>  
                                                        <source  src="{{--vdo_src--}} " >  
                                                    </video>
                                                @endif

                                                @if($msg['type'] == "audio" || $msg['type'] == "ptt")
                                                    <!-- let vdo_src = getMsgImageBlob({{$elem_id}}) -->
                                                    <audio id="prev_media_{{$img_elem_id}}" controls>  
                                                        <source  src="  vdo_src  " >  
                                                    </audio>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="msg-text-content">  
                                    <span dir="auto" class="text-visibility selectable-text copyable-text">  
                                        <span>  {{(($msg['type'] == "image" || $msg['type'] == "video")?((!isset($msg['caption']))?"":$msg['caption']):(($msg['type'] =="audio" || $msg['type'] =="ptt")?"":((!isset($msg['body']))?"":$msg['body'])  ))}}</span>
                                    </span>
                                    <span class="msg-text-foot-spacer"></span>  
                                </div> 
                            </div>  
                            <div class="msg-text-foot">  
                                <div class="msg-time-container" data-testid="msg-meta">  
                                    <span class="msg-time-text" dir="auto">  
                                        {{$msg['t']}}  
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
        function reload_js(src) {
            $('script[src="' + src + '"]').remove();
            $('<script>').attr('src', src).appendTo('head');
        }

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

        window.addEventListener('msgs-loaded', event => {
            //console.log('msg loaded with hash: ' + event.detail.hash);

            var user_id = event.detail.selected_user;
            var is_group = event.detail.is_group;

            //reload_js("{{url('emoji-mart-outside-react/dist/main.js')}}")
            $("#slected_current_user_id").val(user_id);
            //document.getElementById("slected_current_user_id").dispatchEvent(new Event('input'));
            $("#slected_current_is_group").val(is_group);
            //document.getElementById("slected_current_is_group").dispatchEvent(new Event('input'));

            $(".main-text-typing-area").show();

            scrollToElem("scroll_down_pos",{
                block: "end"
            });
            $("body").removeClass("loading");
        });
        // window.addEventListener('check-msgs', event => {
        //     var hash = event.detail.new_hash;
        //     var user = event.detail.current_user;
        //     var is_group = event.detail.is_group;
        //     console.log('new_hash: ' + hash , "current_user: " + user, "is_group: " + is_group);
            
        // });
        
    </script>
</div>
