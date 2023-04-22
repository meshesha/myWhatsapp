<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Http\lib\Wpp;

//use App\Http\lib\VCardParser;

class MsgItems extends Component
{
    public $chats_md5;
    public $current_user;
    public $current_is_goroup;
    public $msg_items = [];
    public $types_arry = ["chat", "image","video", "audio", "ptt","location","vcard"];
    protected $listeners = ['get_all_Messages' => 'getAllMessagesInChat','checkChatMsgsHash'];
    // protected $listeners = ['checkChatMsgsHash'];protected $guzzleHelper;
    // protected $vcardParser;
    // public function mount() //VCardParser $vcardParser
    // {
    //     $this->vcardParser = new VCardParser("hello");
    // }
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
        // $isgroup = ($is_group == 'yes')?true:false;
        $isgroup = ($is_group == 'yes')?'true':'false';
        $incMe = 1;
        $incNotif = 'true';

        
        $phon_num = str_replace(array("@c.us","@g.us"), array("",""), $userId);
        
        // $response = Wpp::getChatById($phon_num, $isgroup);
        // $this->chats_md5 = md5(json_encode($response));
        
        
        $response = $this->earlierMessages($userId, $is_group, "");
        
        // dd($response);
        $this->chats_md5 = md5(json_encode($response));

        // dd($response);
        // && isset($response["status"])
        $last_msg_id = "";
        if($response != "" && isset($response["status"]) && $response["status"] == "success"){ 
            if(count($response["response"]) > 0){
                $last_msg_id = $response["response"][0]["id"]??"";
                // if($last_msg_id != ""){
                //     $last_msg_id_ary = explode("_", $last_msg_id);
                //     $last_msg_id = $last_msg_id_ary[2];
                // }
            }

            foreach($response["response"] as &$msg){
                if($msg["hasReaction"]){
                    //get Reaction
                    $msg_id = $msg["id"];
                    $reaction = $this->getReaction($msg_id);
                    if($reaction && $reaction["status"] == "success"){
                        // dump($reaction["response"]["response"]["reactions"]);
                        $msg["reactions"] = $reaction["response"]["response"]["reactions"];
                    }
                }
            }


            $this->msg_items = $response["response"];
        }

        // dd($last_msg_id);
        
        // $erlier_msg = $this->earlierMessages($userId, $is_group, $last_msg_id);
        // dd($erlier_msg);

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

    
    public function checkChatMsgsHash($new_md5){
        //dd($new_md5 .",". $this->chats_md5);
        if($new_md5 != $this->chats_md5){
            $this->checkMsg();
        }
    }

    public function getReaction($msg_id)
    {
        try{
            $response = Wpp::getReaction($msg_id);

            return array(
                'response'=> $response,
                'status' => ($response != "" && $response["status"])?$response["status"]:"fail"
            );
        }catch(Exception $e){

            return array(
                'response'=> $e,
                'status' => 'fail'
            );

        }
    }

    public function getVotes($msg_id)
    {
        try{
            $response = Wpp::getVotes($msg_id);

            return array(
                'response'=> $response,
                'status' => ($response != "" && $response["status"])?$response["status"]:"fail"
            );
        }catch(Exception $e){

            return array(
                'response'=> $e,
                'status' => 'fail'
            );

        }
    }


    public function earlierMessages($userId, $is_group, $last_msg_id)
    {
        //userId => userSrializeId, 
        //?isGroup=false&includeMe=true&includeNotifications=false
        $isgroup = ($is_group == 'yes')?'true':'false';
        $response = "";
        try{
            $response = Wpp::getEarlierMessages($userId, $isgroup, $last_msg_id);
        }catch(Exception $e){
        }
        return $response;
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
        
        // $response = Wpp::getChatById($phon_num, $isgroup);
        $response = $this->earlierMessages($currentUserId, $isgroup, "");
       
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

            $this->dispatchBrowserEvent('new-msgs-loaded',[
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









    
    protected function vcardParser($content)
    {
        
        // Normalize new lines.
        $content = str_replace(["\r\n", "\r"], "\n", $content);

        // RFC2425 5.8.1. Line delimiting and folding
        // Unfolding is accomplished by regarding CRLF immediately followed by
        // a white space character (namely HTAB ASCII decimal 9 or. SPACE ASCII
        // decimal 32) as equivalent to no characters at all (i.e., the CRLF
        // and single white space character are removed).
        $content = preg_replace("/\n(?:[ \t])/", "", $content);
        $lines = explode("\n", $content);
        //dd($lines);
        // Parse the VCard, line by line.
        foreach ($lines as $line) {
            $line = trim($line);

            if (strtoupper($line) == "BEGIN:VCARD") {
                $cardData = new \stdClass();
            } elseif (strtoupper($line) == "END:VCARD") {
                //$this->vcardObjects[] = $cardData;
                return $cardData;
            } elseif (!empty($line)) {
                // Strip grouping information. We don't use the group names. We
                // simply use a list for entries that have multiple values.
                // As per RFC, group names are alphanumerical, and end with a
                // period (.).
                $line = preg_replace('/^\w+\./', '', $line);

                $type = '';
                $value = '';
                @list($type, $value) = explode(':', $line, 2);

                $types = explode(';', $type);
                $element = strtoupper($types[0]);

                array_shift($types);

                // Normalize types. A type can either be a type-param directly,
                // or can be prefixed with "type=". E.g.: "INTERNET" or
                // "type=INTERNET".
                if (!empty($types)) {
                    $types = array_map(function($type) {
                        return preg_replace('/^type=/i', '', $type);
                    }, $types);
                }

                $i = 0;
                $rawValue = false;
                foreach ($types as $type) {
                    if (preg_match('/base64/', strtolower($type))) {
                        $value = base64_decode($value);
                        unset($types[$i]);
                        $rawValue = true;
                    } elseif (preg_match('/encoding=b/', strtolower($type))) {
                        $value = base64_decode($value);
                        unset($types[$i]);
                        $rawValue = true;
                    } elseif (preg_match('/quoted-printable/', strtolower($type))) {
                        $value = quoted_printable_decode($value);
                        unset($types[$i]);
                        $rawValue = true;
                    } elseif (strpos(strtolower($type), 'charset=') === 0) {
                        try {
                            $value = mb_convert_encoding($value, "UTF-8", substr($type, 8));
                        } catch (\Exception $e) {
                        }
                        unset($types[$i]);
                    }
                    $i++;
                }
                //dump($element);
                switch (strtoupper($element)) {
                    case 'FN':
                        $cardData->fullname = $value;
                        break;
                    case 'N':
                        foreach ($this->parseName($value) as $key => $val) {
                            $cardData->{$key} = $val;
                        }
                        break;
                    case 'BDAY':
                        $cardData->birthday = $this->parseBirthday($value);
                        break;
                    case 'ADR':
                        if (!isset($cardData->address)) {
                            $cardData->address = [];
                        }
                        $key = !empty($types) ? implode(';', $types) : 'WORK;POSTAL';
                        $cardData->address[$key][] = $this->parseAddress($value);
                        break;
                    case 'TEL':
                        if (!isset($cardData->phone)) {
                            $cardData->phone = [];
                        }
                        
                        foreach ($types as $type_) {
                            if(strpos($type_,"waid") !== false){
                                @list(, $waid) = explode('=', $type_);
                                $cardData->waid = $waid;
                            }
                        }
                        //dump($types);
                        $types = array_filter($types, function($val){
                            if(strpos($val,"waid") !== false){
                               return false;
                            }
                        });
                        //dump($types);
                        $key = (!empty($types))? implode(';', $types) : 'default';
                        $cardData->phone[$key][] = $value;
                        break;
                    case 'EMAIL':
                        if (!isset($cardData->email)) {
                            $cardData->email = [];
                        }
                        $key = !empty($types) ? implode(';', $types) : 'default';
                        $cardData->email[$key][] = $value;
                        break;
                    case 'REV':
                        $cardData->revision = $value;
                        break;
                    case 'VERSION':
                        $cardData->version = $value;
                        break;
                    case 'ORG':
                        $cardData->organization = $value;
                        break;
                    case 'URL':
                        if (!isset($cardData->url)) {
                            $cardData->url = [];
                        }
                        $key = !empty($types) ? implode(';', $types) : 'default';
                        $cardData->url[$key][] = $value;
                        break;
                    case 'TITLE':
                        $cardData->title = $value;
                        break;
                    case 'PHOTO':
                        if ($rawValue) {
                            $cardData->rawPhoto = $value;
                        } else {
                            $cardData->photo = $value;
                        }
                        break;
                    case 'LOGO':
                        if ($rawValue) {
                            $cardData->rawLogo = $value;
                        } else {
                            $cardData->logo = $value;
                        }
                        break;
                    case 'NOTE':
                        $cardData->note = $this->unescape($value);
                        break;
                    case 'CATEGORIES':
                        $cardData->categories = array_map('trim', explode(',', $value));
                        break;
                    case 'LABEL':
                        $cardData->label = $value;
                        break;
                }
            }
        }
    }
    protected function parseName($value)
    {
        @list(
            $lastname,
            $firstname,
            $additional,
            $prefix,
            $suffix
        ) = explode(';', $value);
        return (object) [
            'lastname' => $lastname,
            'firstname' => $firstname,
            'additional' => $additional,
            'prefix' => $prefix,
            'suffix' => $suffix,
        ];
    }
    protected function parseBirthday($value)
    {
        return new \DateTime($value);
    }
    protected function parseAddress($value)
    {
        @list(
            $name,
            $extended,
            $street,
            $city,
            $region,
            $zip,
            $country,
        ) = explode(';', $value);
        return (object) [
            'name' => $name,
            'extended' => $extended,
            'street' => $street,
            'city' => $city,
            'region' => $region,
            'zip' => $zip,
            'country' => $country,
        ];
    }

    
    /**
     * Unescape newline characters according to RFC2425 section 5.8.4.
     * This function will replace escaped line breaks with PHP_EOL.
     *
     * @link http://tools.ietf.org/html/rfc2425#section-5.8.4
     * @param  string $text
     * @return string
     */
    protected function unescape($text)
    {
        return str_replace("\\n", PHP_EOL, $text);
    }


}
