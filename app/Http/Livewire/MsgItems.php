<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\lib\Wpp;

class MsgItems extends Component
{
    public $chats_md5;
    public $msg_items = [];
    public $types_arry = ["chat", "image","video", "audio", "ptt"];
    protected $listeners = ['get_all_Messages' => 'getAllMessagesInChat'];

    public function getAllMessagesInChat($userId, $is_group)
    { 
        //dd($userId, $is_group);
        // $startTime = microtime(true);
        $response = "";
        $session = session('session');
        $token = session('token');
        //?isGroup=false&includeMe=true&includeNotifications=false
        $isgroup = ($is_group == 'yes')?true:false;
        $incMe = 1;
        $incNotif = 'true';

        
        $phon_num = str_replace(array("@c.us","@g.us"), array("",""), $userId);
        
        $response = Wpp::getChatById($phon_num, $isgroup);
        
        $this->chats_md5 = md5(json_encode($response));
        if($response && $response["status"] == "success"){
            $this->msg_items = $response["response"];
        }

        $value = $this->chats_md5;
        $this->dispatchBrowserEvent('msgs-loaded',['hash' => $value]);
        //$this->render();
    //    $runTime = number_format(microtime(true) - $startTime, 9);
    //     dd("Run Time: $runTime ms");
    }
    
    public function render()
    {
        return view('livewire.msg-items');
    }
}
