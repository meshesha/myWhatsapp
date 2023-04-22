<?php

namespace App\Http\lib;
use App\Models\SessionTokens;
use Wppconnect;

class Wpp //extends Component
{

    static public $url;
    //public $key;
    //public $session;
    
    // static public function startWppSession()
    // {
    //     $response = "";
    //     $session = session('session');
    //     $token = session('token');
    //     Wppconnect::make(Wpp::$url);
    //     $response = Wppconnect::to('/api/'.$session.'/start-session')->withHeaders([
    //         'Authorization' => 'Bearer '.$token
    //     ])->asJson()->post();
    //     $response = json_decode($response->getBody()->getContents(),true);

    //     return $response;
    // }

    static public function generateToken($key, $user)
    {
        if($user->wpp_session != "" && $user->wpp_token != ""){
           $stt = Wpp::startSession($user->wpp_session,$user->wpp_token);
           //$stt = Wpp::restartService($user->wpp_session,$user->wpp_token);
           if($stt["status"] == "CONNECTED"){
                session(['token' => $user->wpp_token]);
                session(['session' => $user->wpp_session]);
                session(['init' => true]);
                //dd($stt);
           }
        }
        if((!session('token') && !session('session')) || ($user->wpp_token == "")){
            $session = md5(uniqid($user->email));
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to('/api/'.$session.'/'.$key.'/generate-token')->asJson()->post();
            $response = json_decode($response->getBody()->getContents(),true);
            if($response['status'] == 'success'){
                //Session::put('token', $response['token']);
                session(['token' => $response['token']]);
                $user->wpp_token = $response['token'];
                //Session::put('session', $response['session']);
                session(['session' => $response['session']]);
                $user->wpp_session = $response['session'];
                $user->save();

                $sessiontoken = SessionTokens::where("user_id", $user->id)->first();
                if($sessiontoken == null){
                    $sessiontoken = new SessionTokens;
                    $sessiontoken->user_id = $user->id;
                }
                $sessiontoken->session = $response['session'];
                $sessiontoken->token = $response['token'];
                $sessiontoken->save();
            }
        }

	    //# Function: Start Session 
	    //# /api/:session/start-session
		
        if(session('token') && session('session') && !session('init')){
            $response = Wpp::startSession(session('session'), session('token'));//startWppSession();
            session(['init' => true]);
        }
    }

    // static public function getWppQrcode()
    // {
    //     $response = "";
    //     $session = session('session');
    //     $token = session('token');
    //     Wppconnect::make(Wpp::$url);//qrcode-session
    //     $response = Wppconnect::to('/api/'.$session.'/start-session')->withHeaders([
    //         'Authorization' => 'Bearer '.$token
    //     ])->asJson()->get();
    //     $response = json_decode($response->getBody()->getContents(),true);
    //     return $response;
    // }

    
    static public function getAllSession($key)
    {
        $response = "";
        //$token = session('token');
        Wppconnect::make(Wpp::$url);//qrcode-session
        $response = Wppconnect::to('/api/'.$key.'/show-all-sessions')->asJson()->get();
        $response = json_decode($response->getBody()->getContents(),true);
        return $response;
    }
    
    static public function startAllSession($key)
    {
        $response = "";
        //$token = session('token');
        Wppconnect::make(Wpp::$url, false);//qrcode-session
        $response = Wppconnect::to('/api/'.$key.'/start-all')->asJson()->post();
        $response = json_decode($response->getBody()->getContents(),true);
        return $response;
    }
    
    
    static public function closeSession($session_id)
    {
        $response = "";
        $token = session('token');
        Wppconnect::make(Wpp::$url, false);//qrcode-session
        $response = Wppconnect::to('/api/'.$session_id.'/close-session')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->asJson()->post();
        $response = json_decode($response->getBody()->getContents(),true);
        return $response;
    }

    
    static public function restartService($session, $token)
    {
        $response = "";
        //$token = session('token');
        Wppconnect::make(Wpp::$url, false);//qrcode-session
        $response = Wppconnect::to('/api/'.$session.'/restart-service')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->asJson()->post();
        $response = json_decode($response->getBody()->getContents(),true);
        return $response;
    }

    
    static public function startSession($session, $token)
    {
        $response = "";
        //$token = session('token');
        Wppconnect::make(Wpp::$url, false);//qrcode-session
        $response = Wppconnect::to('/api/'.$session.'/start-session')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->asJson()->post();
        $response = json_decode($response->getBody()->getContents(),true);
        return $response;
    }



    static public function checkWppSessionStatus($session = null)
    {
        $response = "";
        if($session == null){
            $session = session('session');
        }
        $token = session('token');
        Wppconnect::make(Wpp::$url, false);
        $response = Wppconnect::to('/api/'.$session.'/check-connection-session')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->asJson()->get();
        $response = json_decode($response->getBody()->getContents(),true);

        return $response;
    }

    
    static public function getAllChats()
    {
        
        $response = "";
        $session = session('session');
        $token = session('token');
        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to('/api/'.$session.'/all-chats')->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->get();
            $response = json_decode($response->getBody()->getContents(),true);
        }
        
        return $response;
    }


    static public function getAllContacts()
    {
        $response = "";
        $session = session('session');
        $token = session('token');
        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to('/api/'.$session.'/all-contacts')->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->get();
            $response = json_decode($response->getBody()->getContents(),true);
        }
        
        return $response;
    }

    
    static public function getContact($phone_num)
    {
        $response = "";
        $session = session('session');
        $token = session('token');
        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to('/api/'.$session.'/contact/'.$phone_num)->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->get();
            $response = json_decode($response->getBody()->getContents(),true);
        }
        
        return $response;
    }

    
    static public function getProfileImg($phone_num)
    {
        $response = "";
        $session = session('session');
        $token = session('token');
        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to('/api/'.$session.'/profile-pic/'.$phone_num)->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->get();
            $response = json_decode($response->getBody()->getContents(),true);
        }
        
        return $response;
    }

    static public function getChatById($phone_num, $isgroup)
    {
        $response = "";
        $session = session('session');
        $token = session('token');
        $to = "/api/$session/chat-by-id/$phone_num?isGroup=$isgroup" ;
        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to($to)->withHeaders([
                'Authorization' => 'Bearer '.$token 
            ])->asJson()->get();
            
            $response = json_decode($response->getBody()->getContents(),true);
        }

        return $response;
    }


    static public function getEarlierMessages($userId, $isgroup, $last_msg_id)
    {

        $response = "";
        $session = session('session');
        $token = session('token');
        
        $to = "/api/$session/get-messages/$userId?isGroup=".$isgroup."&count=-1" ;
        
        if($last_msg_id != ""){
            $to .= "&id=$last_msg_id&direction=before"; 
            // $to .= "&id=$last_msg_id&direction=after"; 
        }

        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url , false);
            try{
                $response = Wppconnect::to($to)->withHeaders([
                    'Authorization' => 'Bearer '.$token 
                ])->asJson()->get();    
            }catch(Exception $e){

            }

            //$response = json_decode($response->getBody()->getContents(),true);
        }
        if($response != "" && $response != null){
            $response = json_decode($response->getBody()->getContents(),true);
        }
        return $response;
    }

    static public function getReaction($msg_id)
    {

        $response = "";
        $session = session('session');
        $token = session('token');
        
        $to = "/api/$session/reactions/$msg_id";
        

        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url , false);
            try{
                $response = Wppconnect::to($to)->withHeaders([
                    'Authorization' => 'Bearer '.$token 
                ])->asJson()->get();    
            }catch(Exception $e){

            }

            //$response = json_decode($response->getBody()->getContents(),true);
        }
        if($response != "" && $response != null){
            $response = json_decode($response->getBody()->getContents(),true);
        }

        return $response;
    }

    static public function getVotes($msg_id)
    {

        $response = "";
        $session = session('session');
        $token = session('token');
        
        $to = "/api/$session/votes/$msg_id";
        

        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url , false);
            try{
                $response = Wppconnect::to($to)->withHeaders([
                    'Authorization' => 'Bearer '.$token 
                ])->asJson()->get();    
            }catch(Exception $e){

            }

            //$response = json_decode($response->getBody()->getContents(),true);
        }
        if($response != "" && $response != null){
            $response = json_decode($response->getBody()->getContents(),true);
        }

        return $response;
    }

    
    static public function getMessageById($id)
    {
        
        $response = "";
        $session = session('session');
        $token = session('token');

        $to = "/api/$session/get-media-by-message/$id"; 
        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to($to)->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asFormParams()->get();//->get(); //asJson(); //asString() //asFormParams()
            $response = $response->getBody()->getContents();//json_decode($response->getBody(),true);
        }

        return $response;
    }



    ///SEND methods

    
    static public function sendCahtMessage($bodyArr , $endUrl)
    {
        $response = "";
        $session = session('session');
        $token = session('token');

        $to = "/api/$session/$endUrl";
        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to($to)->withBody($bodyArr)->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->post();
            $response = json_decode($response->getBody()->getContents(),true);
        }

        return $response;
    }

    
    static public function forwardMessages($user_id , $msgId , $isGroup)
    {
        $response = "";
        $session = session('session');
        $token = session('token');
        $bodyArr = [
            "phone" => $user_id,
            "messageId" => $msgId
        ];

        $to = "/api/$session/forward-messages";
        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to($to)->withBody($bodyArr)->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->post();
            $response = json_decode($response->getBody()->getContents(),true);
        }

        return $response;
    }

    static public function setSeenMessage($userId)
    {
        $response = "";
        $session = session('session');
        $token = session('token');

        $to = "/api/$session/send-seen";
        if($token && $session && session('init')){
            try{
                Wppconnect::make(Wpp::$url, false);
                $response = Wppconnect::to($to)->withBody([
                    "phone" => $userId 
                ])->withHeaders([
                    'Authorization' => 'Bearer '.$token
                ])->asJson()->post();
            }catch(Exception $e){

            }
        }
        if($response != "" && $response != null){
            $response = json_decode($response->getBody()->getContents(),true);
        }
        return $response;
    }


    static public function SendBase64File($user_id , $base64 ,$fileName, $msg , $isGroup)
    {
        $response = "";
        $session = session('session');
        $token = session('token');
        $bodyArr = [
            "phone" => $user_id,
            "base64" => $base64,
            "filename" => $fileName,
            "message" => $msg,
            "isGroup" => $isGroup,
        ];

        $to = "/api/$session/send-file-base64";
        if($token && $session && session('init')){
            Wppconnect::make(Wpp::$url);
            $response = Wppconnect::to($to)->withBody($bodyArr)->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->post();
            $response = json_decode($response->getBody()->getContents(),true);
        }

        return $response;
    }

}
