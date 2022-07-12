<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\lib\Wpp;

class MsgItems extends Component
{
    public $chats_md5;
    public $current_user;
    public $current_is_goroup;
    public $msg_items = [];
    public $types_arry = ["chat", "image","video", "audio", "ptt"];
    protected $listeners = ['get_all_Messages' => 'getAllMessagesInChat','checkChatMsgsHash'];
    // protected $listeners = ['checkChatMsgsHash'];

    public function getAllMessagesInChat($userId, $is_group)
    { 
        //dd($userId, $is_group);
        // $startTime = microtime(true);
        $response = "";
        $session = session('session');
        $token = session('token');

        $this->current_user = $userId;
        $this->current_is_goroup = $is_group;

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
        //$this->setSeenMessage($phon_num);
        //$erlier_msg = $this->earlierMessages($userId, $is_group);
        //dd($erlier_msg);
        $hash = $this->chats_md5;
        $this->dispatchBrowserEvent('msgs-loaded',[
            'hash' => $hash,
            'selected_user' => $userId,
            'is_group' => $is_group
        ]);
        //$this->render();
    //    $runTime = number_format(microtime(true) - $startTime, 9);
    //     dd("Run Time: $runTime ms");
    }

    
    public function checkChatUsrsHash($new_md5){
        if($new_md5 != $this->chats_md5){
            $this->checkMsg();
        }
    }


    public function inint()
    {
        if(!session('token') && !session('session')){
            return redirect()->route('wpp.index');//return $this->index();
        }
        $conn_status = Wpp::checkWppSessionStatus();
        
        if($conn_status['status'] != true){
            //return redirect()->route("home");
            session([
                'init' => false,
                'session' => '',
                'token' => ''
            ]);

            return redirect()->route('wpp.index');//$this->index();
        }
        //dd($conn_status);
        session(['init' => true]);
        
        $this->getAllChatsUsers();
       
        $this->getContants();
        $this->getMyProfile();
    }



    public function earlierMessages($userId, $is_group)
    {
        //userId => userSrializeId, 
        //?isGroup=false&includeMe=true&includeNotifications=false
        $isgroup = ($is_group == 'yes')?'true':'false';
        try{
            $response = Wpp::getEarlierMessages($userId, $isgroup);
            
            $chats_md5 = md5(json_encode($response));

            return array(
                'response'=> $response,
                'status' => ($response != "" && $response["status"])?$response["status"]:"fail",
                'chats_md5' => $chats_md5
            );
        }catch(Exception $e){

            return array(
                'response'=> $e,
                'status' => 'fail',
                'chats_md5' => '-1'
            );

        }
    }

    public function setSeenMessage($userId)
    {
        //userId = userSrializeId.replace(/[@c.us,@c.us]/g, "");
        try{
            Wpp::setSeenMessage($userId);
        }catch(Exception $e){

        }
    }


    public function checkMsg(){

        $currentUserId = $this->current_user;
        $currentIsGroup = $this->current_is_goroup;
        if($currentUserId == "" || $currentUserId == null){
            return false;
        }
        $isgroup = ($currentIsGroup == 'yes')?true:false;
        //$incMe = 1;
        //$incNotif = 'true';
        
        $phon_num = str_replace(array("@c.us","@g.us"), array("",""), $currentUserId);
        
        $response = Wpp::getChatById($phon_num, $isgroup);
       
        $new_chats_md5 = md5(json_encode($response));

        // $this->dispatchBrowserEvent('check-msgs',
        //     ['new_hash' => $new_chats_md5,
        //     'current_user' => $currentUserId,
        //     'is_group' => $currentIsGroup
        // ]);
        
        if($this->chats_md5 != $new_chats_md5){
            //refreah
            //$this->getAllMessagesInChat($currentUserId , $currentIsGroup);
            $this->chats_md5 = $new_chats_md5;
            if($response && $response["status"] == "success"){
                $this->msg_items = $response["response"];
            }
            $this->dispatchBrowserEvent('msgs-loaded',[
                'hash' => $new_chats_md5,
                'selected_user' => $currentUserId,
                'is_group' => $currentIsGroup
            ]);
            //$this->render();
        }
    }

    public function render()
    {
        return view('livewire.msg-items');
    }
}
