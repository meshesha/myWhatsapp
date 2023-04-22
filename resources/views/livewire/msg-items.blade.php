{{-- wire:poll.3s="checkMsg" --}}
<div tabindex="-1" class="chat-container-region" data-tab="8" role="region">
    <!-- chat-items -->
    @if ($msg_items && $msg_items != null && $msg_items != '')
        @foreach ($msg_items as $msg)
            @php
                $in_or_out = 'message-in';
                $tail_data = 'tail-out';
                $elem_id = $msg['id'];
                $img_elem_ary1 = explode('@', $elem_id);
                $img_elem_ary2 = explode('_', $img_elem_ary1[1]);
                $img_elem_id = $img_elem_ary2[1];
            @endphp
            <!-- //var tail_class = "chat-item-tail" -->
            @if ($msg['fromMe'])
                @php
                    $in_or_out = 'message-out';
                    $tail_data = 'tail-in';
                @endphp
            @endif
            <div tabindex="-1" class="chat-item focusable-list-item {{ $in_or_out }} " data-id="{{ $elem_id }}"
                id="{{ $elem_id }}" data-serializedid="{{ $elem_id }}">
                <!-- <input type="hidden" class="chat-id" value="{{ $elem_id }}" > -->
                <!-- <span></span>  //? -->
                <div class="chat-item-content chat-item-wide chat-item-shape">
                    @if (!isset($msg['quotedMsg']))
                        <span data-testid="{{ $tail_data }}" data-icon="{{ $tail_data }}"
                            class="chat-item-tail"></span>
                    @endif
                    <div class="chat-msg-container chat-msg-container-shadow">
                        <div class="chat-msg-content">

                            <div class="msg-sender-details msg-sender-color " role="">
                                <span dir="auto" class="msg-sender-name msg-sender-cursor text-visibility">
                                    {{ $msg['sender'] ? $msg['sender']['formattedName'] : $msg['from'] }}
                                </span>
                            </div>
                            <div class="msg-text-container copyable-text" data-pre-plain-text="">

                                @if (isset($msg['quotedMsg']) && in_array($msg['quotedMsg']['type'], $types_arry))
                                    <!-- //msg.quotedParticipant
                                    //msg.quotedMsgId
                                    //msg.quotedMsg.type
                                    //msg.quotedMsg.body -->
                                    <div class="relay-container">
                                        <div class="relay-container-width">
                                            <div class="relay-container-btn-role" role="button"
                                                onclick="scrollToElem('{{ $msg['quotedMsgId']??'' }}')">
                                                <span class="relay-bg-color-1 relay-bg-flex"></span>
                                                <div class="relay-msg-wrapper">
                                                    <div class="relay-chat-msg-content">
                                                        <div class="msg-sender-details msg-sender-color" role="button">
                                                            <span dir="auto"
                                                                class="msg-sender-name text-visibility">
                                                                {{ $msg['quotedParticipant'] }}
                                                            </span>
                                                        </div>
                                                        @if ($msg['quotedMsg']['type'] == 'vcard')
                                                            @php
                                                                $rvcard = $this->vcardParser($msg['quotedMsg']['body']);
                                                            @endphp
                                                            <div class="vcard-msg-contect-wrp" data-testid="vcard-msg"
                                                                role="button">
                                                                <div class="vcard-msg-img-wrp">
                                                                    <div class="vcard-msg-img-cnt"
                                                                        style="height: 49px; width: 49px;">
                                                                        <!-- <img src="https://pps.whatsapp.net/v/t61.24694-24/183567018_757899728256074_8219042266324787625_n.jpg?stp=dst-jpg_s96x96&amp;ccb=11-4&amp;oh=01_AVx_vck9uhDq8Qw3OXebwR6KhuwlBEuI_l1lbQzcRNoeqg&amp;oe=62F3E44C"
                                                                        alt="" draggable="false"
                                                                        class=" user-real-img user-real-img-opcty-1 vsblty-vsbl"> -->
                                                                        <div class="default-avater-img-container">
                                                                            <span data-testid="default-user"
                                                                                data-icon="default-user">
                                                                                <svg viewBox="0 0 212 212"
                                                                                    width="212" height="212">
                                                                                    <path fill="#DFE5E7"
                                                                                        class="background"
                                                                                        d="M106.251.5C164.653.5 212 47.846 212 106.25S164.653 212 106.25 212C47.846 212 .5 164.654.5 106.25S47.846.5 106.251.5z">
                                                                                    </path>
                                                                                    <path fill="#FFF" class="primary"
                                                                                        d="M173.561 171.615a62.767 62.767 0 0 0-2.065-2.955 67.7 67.7 0 0 0-2.608-3.299 70.112 70.112 0 0 0-3.184-3.527 71.097 71.097 0 0 0-5.924-5.47 72.458 72.458 0 0 0-10.204-7.026 75.2 75.2 0 0 0-5.98-3.055c-.062-.028-.118-.059-.18-.087-9.792-4.44-22.106-7.529-37.416-7.529s-27.624 3.089-37.416 7.529c-.338.153-.653.318-.985.474a75.37 75.37 0 0 0-6.229 3.298 72.589 72.589 0 0 0-9.15 6.395 71.243 71.243 0 0 0-5.924 5.47 70.064 70.064 0 0 0-3.184 3.527 67.142 67.142 0 0 0-2.609 3.299 63.292 63.292 0 0 0-2.065 2.955 56.33 56.33 0 0 0-1.447 2.324c-.033.056-.073.119-.104.174a47.92 47.92 0 0 0-1.07 1.926c-.559 1.068-.818 1.678-.818 1.678v.398c18.285 17.927 43.322 28.985 70.945 28.985 27.678 0 52.761-11.103 71.055-29.095v-.289s-.619-1.45-1.992-3.778a58.346 58.346 0 0 0-1.446-2.322zM106.002 125.5c2.645 0 5.212-.253 7.68-.737a38.272 38.272 0 0 0 3.624-.896 37.124 37.124 0 0 0 5.12-1.958 36.307 36.307 0 0 0 6.15-3.67 35.923 35.923 0 0 0 9.489-10.48 36.558 36.558 0 0 0 2.422-4.84 37.051 37.051 0 0 0 1.716-5.25c.299-1.208.542-2.443.725-3.701.275-1.887.417-3.827.417-5.811s-.142-3.925-.417-5.811a38.734 38.734 0 0 0-1.215-5.494 36.68 36.68 0 0 0-3.648-8.298 35.923 35.923 0 0 0-9.489-10.48 36.347 36.347 0 0 0-6.15-3.67 37.124 37.124 0 0 0-5.12-1.958 37.67 37.67 0 0 0-3.624-.896 39.875 39.875 0 0 0-7.68-.737c-21.162 0-37.345 16.183-37.345 37.345 0 21.159 16.183 37.342 37.345 37.342z">
                                                                                    </path>
                                                                                </svg>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="vcard-msg-usr-name-cnt">
                                                                    <div dir="auto"
                                                                        class="vcard-msg-usr-name vsblty-vsbl selectable-text">
                                                                        {{ $rvcard->fullname }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @elseif($msg['quotedMsg']['type'] == 'location')
                                                            <div class="img-content"
                                                                style="background-image: url(&quot;data:image/png;base64,{{ $msg['quotedMsg']['body'] }}&quot;);">
                                                            </div>
                                                        @else
                                                            <div class="relay-msg-text-content" dir="rtl"
                                                                role="button">
                                                                <span dir="auto"
                                                                    class="quoted-mention text-visibility">
                                                                    {{ $msg['quotedMsg']['type'] == 'image' || $msg['quotedMsg']['type'] == 'video' ? $msg['quotedMsg']['caption'] : $msg['quotedMsg']['body'] }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if ($msg['quotedMsg']['type'] == 'image' || $msg['quotedMsg']['type'] == 'video')
                                                    <div class="replay-img-wrapper">
                                                        <div class="replay-img-content">
                                                            <div class="replay-img-row">
                                                                <div class="replay-img-container">
                                                                    <div class="img-content"
                                                                        style="background-image: url(&quot;data:{{ $msg['quotedMsg']['mimetype'] }};base64,{{-- $msg['quotedMsg']['body'] --}}&quot;);">
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

                                @if ($msg['type'] == 'image' ||
                                    $msg['type'] == 'video' ||
                                    $msg['type'] == 'audio' ||
                                    $msg['type'] == 'ptt' ||
                                    $msg['type'] == 'document' ||
                                    $msg['type'] == 'location')
                                    <div role="button" class="image-preview-area-btn"
                                        style="width:330px;height:330px;">
                                        <div class="image-preview-area-container">
                                            {{-- onclick="onMediaClick('{{$elem_id}}','{{$msg['mimetype']}}','{{$msg['type']}}')" --}}

                                            <div class="image-preview-wrapper">
                                                @if ($msg['type'] != 'location')
                                                    <img src="data:{{ $msg['mimetype'] ?? 'image/png' }};base64,{{ $msg['body'] ?? '' }}  "
                                                        class="image-preview-noloaded-img">
                                                @else
                                                    {{-- <img src="data:image/png;base64,{{ $msg['body'] ?? '' }}"
                                                        class="image-preview-noloaded-img"> --}}
                                                    <iframe style="width:100%;height:100%; "
                                                        src="https://maps.google.com/maps?q={{ $msg['lat'] }},{{ $msg['lng'] }}&hl=es;z=14&amp;output=embed"></iframe>
                                                @endif
                                            </div>
                                            <div class="image-preview-wrapper image-preview-loaded-img">
                                                @if ($msg['type'] == 'image')
                                                    {{-- onerror="getMsgMediaData('{{$elem_id}}','{{$msg['type']}}')" --}}
                                                    <img id="prev_img_{{ $img_elem_id }}" src="">
                                                @endif

                                                @if ($msg['type'] == 'video')
                                                    <!-- let vdo_src = getMsgMediaData({{ $elem_id }}) -->
                                                    <video id="prev_media_{{ $img_elem_id }}" controls>
                                                        <source src="{{-- vdo_src --}}">
                                                    </video>
                                                @endif

                                                @if ($msg['type'] == 'audio' || $msg['type'] == 'ptt')
                                                    <!-- let vdo_src = getMsgMediaData({{ $elem_id }}) -->
                                                    <audio id="prev_media_{{ $img_elem_id }}" controls>
                                                        <source src="">
                                                    </audio>
                                                @endif
                                                @if ($msg['type'] == 'document')
                                                    {{-- class="document-overly" --}}
                                                    <div>
                                                        <a id="prev_doc_{{ $img_elem_id }}" href="#"
                                                            target="_blink" class="icon">
                                                            <i class="fa fa-file"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                            <script>
                                                // setTimeout(function(elem_id, type, mimetype){
                                                //     getMsgMediaData(elem_id,type, mimetype);
                                                // },250, "{{-- $elem_id --}}","{{-- $msg['type'] --}}", "{{-- $msg['mimetype'] --}}")
                                                getMsgMediaData("{{ $elem_id }}", "{{ $msg['type'] }}", "{{ $msg['mimetype'] ?? 'image/png' }}");
                                            </script>
                                        </div>
                                    </div>
                                @elseif($msg['type'] == 'vcard')
                                    @php
                                        $vcard = $this->vcardParser($msg['body']);
                                    @endphp
                                    {{-- json_encode($vcard->phone) --}}

                                    <div class="vcard-msg-contect-wrp" data-testid="vcard-msg" role="button">
                                        <div class="vcard-msg-img-wrp">
                                            <div class="vcard-msg-img-cnt" style="height: 49px; width: 49px;">
                                                <!-- <img src="https://pps.whatsapp.net/v/t61.24694-24/183567018_757899728256074_8219042266324787625_n.jpg?stp=dst-jpg_s96x96&amp;ccb=11-4&amp;oh=01_AVx_vck9uhDq8Qw3OXebwR6KhuwlBEuI_l1lbQzcRNoeqg&amp;oe=62F3E44C"
                                                                        alt="" draggable="false"
                                                                        class=" user-real-img user-real-img-opcty-1 vsblty-vsbl"> -->
                                                <div class="default-avater-img-container">
                                                    <span data-testid="default-user" data-icon="default-user">
                                                        <svg viewBox="0 0 212 212" width="212" height="212">
                                                            <path fill="#DFE5E7" class="background"
                                                                d="M106.251.5C164.653.5 212 47.846 212 106.25S164.653 212 106.25 212C47.846 212 .5 164.654.5 106.25S47.846.5 106.251.5z">
                                                            </path>
                                                            <path fill="#FFF" class="primary"
                                                                d="M173.561 171.615a62.767 62.767 0 0 0-2.065-2.955 67.7 67.7 0 0 0-2.608-3.299 70.112 70.112 0 0 0-3.184-3.527 71.097 71.097 0 0 0-5.924-5.47 72.458 72.458 0 0 0-10.204-7.026 75.2 75.2 0 0 0-5.98-3.055c-.062-.028-.118-.059-.18-.087-9.792-4.44-22.106-7.529-37.416-7.529s-27.624 3.089-37.416 7.529c-.338.153-.653.318-.985.474a75.37 75.37 0 0 0-6.229 3.298 72.589 72.589 0 0 0-9.15 6.395 71.243 71.243 0 0 0-5.924 5.47 70.064 70.064 0 0 0-3.184 3.527 67.142 67.142 0 0 0-2.609 3.299 63.292 63.292 0 0 0-2.065 2.955 56.33 56.33 0 0 0-1.447 2.324c-.033.056-.073.119-.104.174a47.92 47.92 0 0 0-1.07 1.926c-.559 1.068-.818 1.678-.818 1.678v.398c18.285 17.927 43.322 28.985 70.945 28.985 27.678 0 52.761-11.103 71.055-29.095v-.289s-.619-1.45-1.992-3.778a58.346 58.346 0 0 0-1.446-2.322zM106.002 125.5c2.645 0 5.212-.253 7.68-.737a38.272 38.272 0 0 0 3.624-.896 37.124 37.124 0 0 0 5.12-1.958 36.307 36.307 0 0 0 6.15-3.67 35.923 35.923 0 0 0 9.489-10.48 36.558 36.558 0 0 0 2.422-4.84 37.051 37.051 0 0 0 1.716-5.25c.299-1.208.542-2.443.725-3.701.275-1.887.417-3.827.417-5.811s-.142-3.925-.417-5.811a38.734 38.734 0 0 0-1.215-5.494 36.68 36.68 0 0 0-3.648-8.298 35.923 35.923 0 0 0-9.489-10.48 36.347 36.347 0 0 0-6.15-3.67 37.124 37.124 0 0 0-5.12-1.958 37.67 37.67 0 0 0-3.624-.896 39.875 39.875 0 0 0-7.68-.737c-21.162 0-37.345 16.183-37.345 37.345 0 21.159 16.183 37.342 37.345 37.342z">
                                                            </path>
                                                        </svg>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="vcard-msg-usr-name-cnt">
                                            <div dir="auto"
                                                class="vcard-msg-usr-name vsblty-vsbl selectable-text">
                                                {{ $vcard->fullname }}
                                            </div>
                                        </div>
                                        {{-- <div class="vcard-msg-mata">
                                            <div class="msg-time-container" data-testid="msg-meta" role="button">
                                                <span class="msg-time-text" dir="auto">
                                                    {{ date('d-m-Y H:i:s', (int) $msg['t']) }}
                                                </span>
                                                <!-- <div class="msg-text-read-status">
                                                                        <span data-testid="msg-dblcheck" aria-label=" Delivered " data-icon="msg-dblcheck">
                                                                            <svg viewBox="0 0 16 15" width="16" height="15">
                                                                                <path fill="currentColor"
                                                                                    d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.879a.32.32 0 0 1-.484.033l-.358-.325a.319.319 0 0 0-.484.032l-.378.483a.418.418 0 0 0 .036.541l1.32 1.266c.143.14.361.125.484-.033l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.879a.32.32 0 0 1-.484.033L1.891 7.769a.366.366 0 0 0-.515.006l-.423.433a.364.364 0 0 0 .006.514l3.258 3.185c.143.14.361.125.484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z">
                                                                                </path>
                                                                            </svg>
                                                                        </span>
                                                                    </div> -->

                                            </div>
                                        </div> --}}
                                    </div>
                                    {{-- <div class="vcard-msg-action-cnt">
                                        <div class="vcard-msg-action-cols " role="button" tabindex="0"
                                            title="הודעה אל רונן חזן-תקשוב">הודעה</div>
                                        <div class="vcard-msg-action-cols " role="button" tabindex="0"
                                            title="לצרף לקבוצה">לצרף
                                            לקבוצה</div>
                                    </div> --}}
                                @else
                                    {{-- if ($msg['type'] != 'chat') --}}
                                        <script>
                                            console.log("TODO type:", "{{$msg['type']}}", {!! json_encode($msg) !!});
                                        </script>
                                    {{-- endif --}}
                                @endif
                                @if ($msg['type'] != 'vcard')
                                    <div class="msg-text-content">
                                        <span dir="auto" class="text-visibility selectable-text copyable-text">
                                            {{-- <span>  {{(($msg['type'] == "image" || $msg['type'] == "video" || $msg['type'] == "document")?((!isset($msg['caption']))?"":$msg['caption']):(($msg['type'] =="audio" || $msg['type'] =="ptt")?"":((!isset($msg['body']))?"":$msg['body'])  ))}}</span> --}}
                                            @if ($msg['type'] == 'image' || $msg['type'] == 'video' || $msg['type'] == 'document')
                                                <span>{{ $msg['caption'] ?? '' }}</span>
                                            @elseif($msg['type'] == 'audio' || $msg['type'] == 'ptt')
                                                <span></span>
                                            @elseif($msg['type'] == 'location')
                                                <span><a href="https://maps.google.com/?q={{ $msg['lat'] }},{{ $msg['lng'] }}"
                                                        target="_blink">{{ $msg['loc'] ?? '' }}</a></span>
                                            @else
                                                <span>{{ $msg['body'] ?? '' }}</span>
                                            @endif
                                        </span>
                                        <span class="msg-text-foot-spacer"></span>
                                    </div>
                                @endif
                            </div>
                            <div class="msg-text-foot">
                                <div class="msg-time-container" data-testid="msg-meta">
                                    <span class="msg-time-text" dir="auto">
                                        {{ date('d-m-Y H:i:s', (int) $msg['t']) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- <span>on hover item create arrow down button</span>   -->
                    </div>
                </div>
            </div>
        @endforeach
        <div id="scroll_down_pos"></div>
    @endif
    <script>
        //var all_msgs = htmlDecode('{{ json_encode($msg_items) }}');
        var msgs_json_obj;
        var msgIntervalId;
        // try{
        //     msgs_json_obj = JSON.parse(all_msgs); 
        // }catch(e){}

        // console.log("all_msgs: ", msgs_json_obj)

        function htmlDecode(value) {
            return $("<textarea/>").html(value).text();
        }

        window.addEventListener('msgs-loaded', event => {

            var old_hash = event.detail.hash;
            var user_id = event.detail.selected_user;
            var is_group = event.detail.is_group;

            // console.log('msg loaded with hash: ', old_hash, user_id, is_group);
            localforage.setItem('old_hash', old_hash, function() {
                setChatTimer(user_id, is_group);
                //reload_js("{{ url('emoji-mart-outside-react/dist/main.js') }}")
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

        function setMsgsTail() {
            var svg_tail_out_ltr =
                '<svg viewBox="0 0 8 13" width="8" height="13"><path opacity=".13" d="M5.188 1H0v11.193l6.467-8.625C7.526 2.156 6.958 1 5.188 1z"></path><path fill="currentColor" d="M5.188 0H0v11.193l6.467-8.625C7.526 1.156 6.958 0 5.188 0z"></path></svg>';
            var svg_tail_out_rtl =
                '<svg viewBox="0 0 8 13" width="8" height="13"><path opacity=".13" fill="#0000000" d="M1.533 3.568L8 12.193V1H2.812C1.042 1 .474 2.156 1.533 3.568z" ></path><path fill="currentColor" d="M1.533 2.568L8 11.193V0H2.812C1.042 0 .474 1.156 1.533 2.568z"></path></svg>';
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

        function msgLoadActions() {
            setMsgsTail();

            setTimeout(function() {
                scrollToElem("scroll_down_pos", {
                    block: "end"
                });
                $("body").removeClass("loading");
            }, 1000);
        }

        function setChatTimer(userSrializeId, isGroup) {
            if (msgIntervalId !== undefined) {
                clearInterval(msgIntervalId);
            }
            //getMessages(userSrializeId, isGroup);
            msgIntervalId = setInterval(function(user_id, is_group) {
                //console.log(user_id, is_group)
                getMessages(user_id, is_group);
            }, 1000, userSrializeId, isGroup);

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
                type: 'POST',
                url: '/wpp/chatmsg',
                data: {
                    user_id: userId,
                    is_group: isGroup
                },
                success: function(data) {
                    //$("#msg").html(data.msg);
                    //console.log(data);
                    if (data.status == "success") {
                        var new_hash = data.chats_md5;
                        localforage.getItem('old_hash', function(err, old_hash) {
                            if (old_hash != new_hash) {
                                window.Livewire.emit('checkChatMsgsHash', new_hash)
                                localforage.setItem('old_hash', new_hash, function() {
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

        function processAllMsgs(msgs_json_obj) {
            // console.log("msgs_json_obj:", msgs_json_obj)
            if (msgs_json_obj !== undefined && msgs_json_obj.length > 0) {
                msgs_json_obj.forEach(function(msg) {
                    //getMsgMediaData("{$elem_id}","{$msg['type']}", "{$msg['mimetype']}");
                    var elem_id = msg.id;
                    var type = msg.type;
                    var mimetype = msg.mimetype;
                    //console.log("elem_id:", elem_id, "type: ", type , "mimetype: ", mimetype);
                    //getMsgMediaData(elem_id, type, mimetype);
                })
            }
        }
    </script>
</div>


@section('above_livewire_foot_script')
    {{-- section('foot_script') --}}
    <script>
        //processAllMsgs();

        // function processAllMsgs(msgs_json_obj){
        //     console.log("msgs_json_obj:", msgs_json_obj)
        //     if(msgs_json_obj !== undefined && msgs_json_obj.length > 0){
        //         msgs_json_obj.forEach(function(msg){
        //             //getMsgMediaData("{$elem_id}","{$msg['type']}", "{$msg['mimetype']}");
        //             var elem_id = msg.id;
        //             var type = msg.type;
        //             var mimetype = msg.mimetype;
        //             //console.log("elem_id:", elem_id, "type: ", type , "mimetype: ", mimetype);
        //             //getMsgMediaData(elem_id, type, mimetype);
        //         })
        //     }
        // }

        // function reload_js(src) {
        //     $('script[src="' + src + '"]').remove();
        //     $('<script>').attr('src', src).appendTo('head');
        // }
    </script>
@endsection
