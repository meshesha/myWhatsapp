<div tabindex="-1" class="chat-container-region" data-tab="8" role="region">
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
        window.addEventListener('msgs-loaded', event => {
            console.log('msg loaded with hash: ' + event.detail.hash);
            setMsgsTail();
            $(".main-text-typing-area").show();
            scrollToElem("scroll_down_pos",{
                block: "end"
            });
        });
        
    </script>
</div>


@section('foot_script_side_bar')

<script type="text/javascript">
    // $(".chat-item").on("load", function(){
    //     console.log("chat item loaded");
    // });
    
    // function scrollToElem(elem_id, option){
    //     console.log("scrollToElem: ", elem_id)
    //     let defaultOptions = {
    //         behavior: "smooth",
    //         block: "end"
    //     }

    //     if(option !== null && option !== undefined){
    //         defaultOptions = option;
    //     }

    //     if(elem_id != "" && elem_id !== null && elem_id !== undefined){
    //         var element = document.getElementById(elem_id);
    //         if(element  !== null )
    //             element.scrollIntoView(defaultOptions); //, block: "end", inline: "nearest"
    //         else
    //             console.log(`elemnet with id ${elem_id}: no found`)
    //     }

    // }
</script>

@endsection
