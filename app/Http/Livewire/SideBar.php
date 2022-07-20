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

    public $searchUser;

    protected $listeners = ['checkChatUsrsHash'];

    private function getAllChatsUsers(){
        $all_chats = Wpp::getAllChats();
        $chatsArr = [];
        if($all_chats != "" && $all_chats['status'] == 'success'){
            $chatsArr = $all_chats['response'];
        }
        if($this->searchUser != null){
            //dd($chatsArr);
            $search = $this->searchUser;
            
            $chatsArr = array_filter($chatsArr, function($item) use($search){
                if(strpos($item["contact"]["formattedName"],$search) !== false){
                    return true;
                }
                return false;
            }) ;
        }

        if(!empty($chatsArr)){
            $this->chats_md5 = md5(json_encode($all_chats));
        }
        
        $this->allChats = $chatsArr;
    }

    public function checkChatUsrsHash($new_md5){
        if($new_md5 != $this->chats_md5){
            $this->inint();
        }
    }


    public function checkUsersChat()
    {
        $all_chats = Wpp::getAllChats();
        $chatsArr = [];
        if($all_chats != "" && $all_chats['status'] == 'success'){
            $chatsArr = $all_chats['response'];
        }

        if(!empty($chatsArr)){
            $newchats_md5 = md5(json_encode($all_chats));
            $this->checkChatUsrsHash($newchats_md5);
        }

    }


    private function getContants(){
        $all_contacts = Wpp::getAllContacts();
        $contantsArr = [];
        $myContant = "";
        //$myProfileImg = "";
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
        $myProfileImg = "";
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
            $this->emit('update_my_profile_img',$myProfileImg);
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

    public function render()
    {
        $this->inint();
        return view('livewire.side-bar');
    }

    public function getAllMessages($userId, $is_group ,$userName, $user_avater)
    {
       
        $this->dispatchBrowserEvent('selected_user_avatar',[
            'user_name' => $userName,
            'user_img' => $user_avater
        ]);
        $this->emit('get_all_Messages',$userId, $is_group);
    }
}
