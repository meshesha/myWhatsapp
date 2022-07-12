<?php

namespace App\Http\Livewire;

use Livewire\Component;
//use App\Http\lib\Wpp;

class TextTyping extends Component
{
    // public $msgText;
    // public $send_to;
    // public $isgroup;// = ($request->input('is_group') == "yes")?true:false;
    // public $repaly_msg_id;

    // public function sendMessage($to , $is_grp)
    // {
    //     $send_to = $this->send_to;
    //     $isgroup = ($this->isgroup == "yes")?true:false;
    //     $msg_body = $this->msgText;
    //     $repaly_msg_id = $this->repaly_msg_id;
        
    //     $msg_body = str_replace("<div>", "" , $msg_body);
    //     $msg_body = str_replace("</div>", "\r\n" , $msg_body);
        
    //     $bodyArr = [
    //         'phone' => $send_to,
    //         'message' => trim(strip_tags($msg_body)),
    //         'isGroup' => $isgroup
    //     ];
    //     //dd($bodyArr);
    //     $endUrl = "send-message";
    //     if($repaly_msg_id != "" && $repaly_msg_id != null){
    //         $endUrl = "send-reply";
    //         $bodyArr["messageId"] = $repaly_msg_id;
    //     }

    //     $response = Wpp::sendCahtMessage($bodyArr , $endUrl);
    //     //dd($response);
    //     $this->cleanFields();

    // }


    // public function cleanFields()
    // {
    //     $this->msgText = "";
    //     $this->repaly_msg_id = "";
        
    //     $this->dispatchBrowserEvent('clean_send_msg_filesd');
    // }

    public function render()
    {
        return view('livewire.text-typing');
    }
}
