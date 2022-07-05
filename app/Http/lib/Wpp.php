<?php

namespace App\Http\lib;

use Wppconnect;

class Wpp //extends Component
{

    static public $url;
    //public $key;
    //public $session;
    
    static public function startWppSession()
    {
        $response = "";
        $session = session('session');
        $token = session('token');
        Wppconnect::make(Wpp::$url);
        $response = Wppconnect::to('/api/'.$session.'/start-session')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->asJson()->post();
        $response = json_decode($response->getBody()->getContents(),true);

        return $response;
    }
    static public function generateToken($key, $user)
    {
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
            }
        }

	    //# Function: Start Session 
	    //# /api/:session/start-session
		
        if(session('token') && session('session') && !session('init')){
            $response = Wpp::startWppSession();
            session(['init' => true]);
        }
    }

    static public function getWppQrcode()
    {
        $response = "";
        $session = session('session');
        $token = session('token');
        Wppconnect::make(Wpp::$url);//qrcode-session
        $response = Wppconnect::to('/api/'.$session.'/start-session')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->asJson()->get();
        $response = json_decode($response->getBody()->getContents(),true);
        return $response;
    }

    static public function checkWppSessionStatus()
    {
        $response = "";
        $session = session('session');
        $token = session('token');
        Wppconnect::make(Wpp::$url);
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

    static public function getEarlierMessages($userId, $isgroup)
    {

        $response = "";
        $session = session('session');
        $token = session('token');
        
        $to = "/api/$session/load-earlier-messages/$userId?isGroup=".$isgroup ;
        try{
            if($token && $session && session('init')){
                Wppconnect::make(Wpp::$url);
                $response = Wppconnect::to($to)->withHeaders([
                    'Authorization' => 'Bearer '.$token 
                ])->asJson()->get();

                //$response = json_decode($response->getBody()->getContents(),true);
            }
        }catch(Exception $e){

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

    
    static public function setSeenMessage($userId)
    {
        $response = "";
        $session = session('session');
        $token = session('token');

        $to = "/api/$session/send-seen";
        if($token && $session && session('init')){
            try{
                Wppconnect::make(Wpp::$url);
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
}
