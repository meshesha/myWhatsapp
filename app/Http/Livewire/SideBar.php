<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\lib\Wpp;

class SideBar extends Component
{
    public $allChats;
    public $myProfileImg;
    public $chats_md5;
    public $profile_md5;

    public $all_contants;
    public $myContant;

    protected $listeners = ['checkChatUsrsHash'];

    private function getAllChatsUsers(){
        $all_chats = Wpp::getAllChats();
        $chatsArr = [];
        if($all_chats != "" && $all_chats['status'] == 'success'){
            $chatsArr = $all_chats['response'];
        }

        if(!empty($chatsArr)){
            $this->chats_md5 = md5(json_encode($all_chats));
        }
        
        $this->allChats = $chatsArr;
    }

    public function checkChatUsrsHash($new_md5){
        if($new_md5 != $this->chats_md5){
            $this->render();
        }
    }

    private function getContants(){
        $all_contacts = Wpp::getAllContacts();
        $contantsArr = [];
        $myContant = "";
        $myProfileImg = "";
        if($all_contacts != "" && $all_contacts['status'] == 'success'){
            foreach ($all_contacts["response"] as $contact) {
                if (!$contact["isMe"] && $contact["isMyContact"] && $contact["id"]["user"] != null )
                    $contantsArr[] = $contact;
                elseif($contact["isMe"])
                    $myContant = $contact;
            }
        }
        $this->all_contants = $contantsArr;
        $this->myContant = $myContant;

    }

    private function getMyProfile(){
        $myContant = $this->myContant;
        if($myContant != ""){
            //$myContantData = Wpp::getContact($myContant["id"]["user"]);
            $profileImg = Wpp::getProfileImg($myContant["id"]["user"]);
            if($profileImg != "" && $profileImg['status'] == 'success'){
                $myProfileImg = $profileImg["response"]["eurl"];
            }
            $this->myProfileImg = $myProfileImg;
            if($myProfileImg != ""){
                $this->profile_md5 = md5(json_encode($profileImg));
            }
        }
    }

    public function render()
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

        //$this->emitUp('checkChatUsrsHash');

        return view('livewire.side-bar');
    }
}
