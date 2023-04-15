<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\lib\Wpp;
use Storage;
//use Wppconnect;
//use Session;

class WppconnectController extends Controller
{

    public $url;
    protected $key;
    protected $session;

    /**
     * __construct function
     */
    public function __construct()
    {

        $this->middleware('auth');

        $this->url = config('wppconnect.defaults.base_uri');
        $this->key = config('wppconnect.defaults.secret_key');
	    //$this->session = "mySession";
         Wpp::$url =  $this->url;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = auth()->user();

        Wpp::generateToken($this->key , $user);

        //dd($this->getQrCode());
        $conn_status = Wpp::checkWppSessionStatus();
        
        if($conn_status['status'] == true){
            //dd($conn_status);
            return redirect()->route("home");
        }
        return view('wpp.getqr');//->with('qrcode', $response['qrcode']);

    }
    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getQrCode()
    {
        $response = "";
        $conn_status = "";
        $qrcodehash = "";
        if(session('token') && session('session') && session('init')){
            $response = Wpp::startSession(session('session'), session('token'));//Wpp::startWppSession();
            $conn_status = Wpp::checkWppSessionStatus();
        }
        
        if($response != "" && $response["status"] == "QRCODE"){
            //$this->qrcode = $response["qrcode"];
            $qrcodehash = md5($response["qrcode"]);
        }
        return response()->json(array(
            'response'=> $response,
            'hash' => $qrcodehash,
            'conn_status' => $conn_status
        ), 200);
        //return json_encode($response);
    }



    /**
     * Show all sessions.
     * 
     */
    public function getAllSession()
    {
        $response = "";
        if($this->key != ""){
            $response = Wpp::getAllSession($this->key);
        }
        $good_sessions = array();
        $all_sessions = array();
        
        if($response != "" && $response != null && count($response) > 0){
            if(isset($response["response"]) && count($response["response"]) > 0){
                foreach($response["response"] as $session){
                    $sstt = "";
                    try{
                        $sstt = Wpp::checkWppSessionStatus($session["session"]);
                        //dump($sstt);
                        //$token = session('token');
                        //dump($token);
                    }catch(Exception $e){
                        
                    }
                    //$stt_ary = array();
                    $sstt["session"] =  $session["session"];
                    
                    $all_sessions[] = $sstt;

                    if($sstt != "" && $sstt != null){
                        if(!isset($sstt["error"])){
                            $good_sessions[] = $sstt;
                        }else{
                            //kill sestion
                        }
                    }
                    //dump($sstt);
                } 
            }
        }
        dd($all_sessions);
        if(count($good_sessions) > 0){
            $sstt = "";
            // try{
            //     $sstt = Wpp::startAllSession($session["session"]);
            // }catch(Exception $e){
                
            // }
            // dump($sstt);
            
            foreach($good_sessions as $session){
                if($session["status"] == false){
                    //reconnect $session["session"]
                    try{
                        $sstt = Wpp::startSession($session["session"]);
                    }catch(Exception $e){
                        
                    }
                }
            }
        }
        dd($sstt);

        $chats_md5 = md5(json_encode($response));

        return response()->json(array(
            'response'=> $response,
        ), 200);
    }


    /**
     * Start all sessions.
     * 
     */
    public function startAllSession()
    {
        $response = "";
        if($this->key != ""){
            $response = Wpp::startAllSession($this->key);
        }
        dd($response);

        return response()->json(array(
            'response'=> $response,
        ), 200);
    }


    /**
     * close all sessions.
     * 
     */
    public function startSession($session_id)
    {
        $response = "";
        if($this->key != ""){
            $response = Wpp::startSession($session_id);
        }
        dd($response);

        return response()->json(array(
            'response'=> $response,
        ), 200);
    }

    /**
     * close all sessions.
     * 
     */
    public function closeSession($session_id)
    {
        $response = "";
        if($this->key != ""){
            $response = Wpp::closeSession($session_id);
        }
        dd($response);

        return response()->json(array(
            'response'=> $response,
        ), 200);
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chat()
    {
        if(!session('token') && !session('session')){
            return $this->index();
        }
        $conn_status = Wpp::checkWppSessionStatus();
        
        if($conn_status['status'] != true){
            //return redirect()->route("home");
            session([
                'init' => false,
                'session' => '',
                'token' => ''
            ]);
            return $this->index();
        }
        //dd($conn_status);
        session(['init' => true]);
        // $all_chats = Wpp::getAllChats();
        // //dd($all_chats);
        // $chatsArr = [];
        // if($all_chats != "" && $all_chats['status'] == 'success'){
        //     $chatsArr = $all_chats['response'];
        // }
        
        // $all_contacts = Wpp::getAllContacts();
        // $contantsArr = [];
        // $myContant = "";
        // $myProfileImg = "";
        // if($all_contacts != "" && $all_contacts['status'] == 'success'){
        //     foreach ($all_contacts["response"] as $contact) {
        //         if (!$contact["isMe"] && $contact["isMyContact"] && $contact["id"]["user"] != null )
        //             $contantsArr[] = $contact;
        //         elseif($contact["isMe"])
        //             $myContant = $contact;
        //     }
        // }
        // if($myContant != ""){
        //     //$myContantData = Wpp::getContact($myContant["id"]["user"]);
        //     $profileImg = Wpp::getProfileImg($myContant["id"]["user"]);
        //     if($profileImg != "" && $profileImg['status'] == 'success'){
        //         $myProfileImg = $profileImg["response"]["eurl"];
        //     }
        //     //dd($myProfileImg);
        // }

        // $chats_md5 = md5(json_encode($all_chats));
        // $data = array(
        //     'title' => 'All Chats',
        //     'allChats' => $chatsArr,
        //     'chats_md5' => $chats_md5,
        //     'myProfileImg' =>$myProfileImg
        // );
        //get all sers/group list - TODO;;
        return view('wpp.chat');//->with($data);
    }

    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfileImgAjax($userid)
    {
        $response = "";
        $phone_num = $userid; //$request->input('user_id');
        if(session('token') && session('session') && session('init') && $phone_num != ""){
            $response = Wpp::getProfileImg($phone_num);
        }
        
        $chats_md5 = md5(json_encode($response));

        return response()->json(array(
            'response'=> $response,
            'chats_md5' => $chats_md5
        ), 200);
    }


    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function getAllChatsAjax()
    // {
    //     $response = "";
    //     $conn_status = "";
    //     if(session('token') && session('session') && session('init')){
    //         $response = Wpp::getAllChats();
    //         $conn_status = Wpp::checkWppSessionStatus();
    //     }
        
    //     $chats_md5 = md5(json_encode($response));

    //     return response()->json(array(
    //         'response'=> $response,
    //         'conn_status' => $conn_status,
    //         'chats_md5' => $chats_md5
    //     ), 200);
    //     //return json_encode($response);
    // }


    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function getAllMessagesInChat(Request $request)
    {
        $response = "";
        
        $session = session('session');
        $token = session('token');
        //?isGroup=false&includeMe=true&includeNotifications=false
        $userId = $request->input('user_id');
        $isgroup = ($request->input('is_group') == 'yes')?true:false;
        
        $phon_num = str_replace(array("@c.us","@g.us"), array("",""), $userId);
        
        $response = Wpp::getChatById($phon_num, $isgroup);
        
        $chats_md5 = md5(json_encode($response));

        return response()->json(array(
            'response'=> $response,
            'status' => ($response != "" && $response["status"])?$response["status"]:"fail",
            'chats_md5' => $chats_md5
        ), 200);
    }


    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    // public function earlierMessages(Request $request)
    // {
        
    //     //?isGroup=false&includeMe=true&includeNotifications=false
    //     $userId = $request->input('user_id');
    //     $isgroup = ($request->input('is_group') == 'yes')?'true':'false';
        
    //     $response = Wpp::getEarlierMessages($userId, $isgroup);
        
    //     $chats_md5 = md5(json_encode($response));

    //     return response()->json(array(
    //         'response'=> $response,
    //         'status' => ($response != "" && $response["status"])?$response["status"]:"fail",
    //         'chats_md5' => $chats_md5
    //     ), 200);
    // }

    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function messageById($id)
    {
        //id =? true_120363020803854156@g.us_0BBFBE9C87651496021EAA6782EA08E4
        

        $response = Wpp::getMessageById($id);

       // dd($response);
        return response()->json(array(
            'base64'=> $response,
            'status' => ($response != "")?"success":"fail"
        ), 200);
    }


    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function sendMessage(Request $request)
    {
        
        
        $send_to = $request->input('send_to');
        $isgroup = ($request->input('is_group') == "yes")?true:false;
        $msg_body = $request->input('msg_body');
        $repaly_msg_id = $request->input('repaly_msg_id');
        
        
        $msg_body = str_replace("<div>", "" , $msg_body);
        $msg_body = str_replace("</div>", "\r\n" , $msg_body);
        $msg_body = trim(strip_tags($msg_body));


        $bodyArr = [
            'phone' => $send_to,
            'message' => $msg_body,
            'isGroup' => $isgroup
        ];

        $endUrl = "send-message";
        if($repaly_msg_id != ""){
            $endUrl = "send-reply";
            $bodyArr["messageId"] = $repaly_msg_id;
        }

        $response = Wpp::sendCahtMessage($bodyArr , $endUrl);

        return response()->json(array(
            'response'=> $response
        ), 200);

    }

    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function sendFile(Request $request)
    {
        
        
        $send_to = $request->input('send_to');
        $isgroup = ($request->input('is_group') == "yes")?true:false;
        $msg_body = $request->input('msg_body');

        $serverId = $request->input('serverId');
        $fileName = $request->input('fileName');
        
        // $msg_body = str_replace("<div>", "" , $msg_body);
        // $msg_body = str_replace("</div>", "\r\n" , $msg_body);
        // $msg_body = trim(strip_tags($msg_body));

        // $filepond = app(\Sopamo\LaravelFilepond\Filepond::class);
        // $disk = config('filepond.temporary_files_disk');

        // $path = $filepond->getPathFromServerId($serverId);
        // $fullpath = Storage::disk($disk)->get($path);
        // $finalLocation = public_path('output.jpg');
        // \File::move($fullpath, $finalLocation);

        $finalLocation = public_path('storage/images/'.$serverId);
        $file_content = file_get_contents($finalLocation);
        $base64 = base64_encode($file_content);
        $mime_type = mime_content_type($finalLocation);
        $fullBase64 = 'data:' . $mime_type . ';base64,' . $base64;
        //dd($fullBase64);


        $user_id = str_replace(array("@c.us","@g.us"), array("",""), $send_to);

        $response = Wpp::SendBase64File($user_id , $fullBase64 ,$fileName, $msg_body , $isgroup);

        if($response["status"] == "success"){
            //delete file
              if(\File::exists($finalLocation)){
                \File::delete($finalLocation);
            }
        }

        return response()->json(array(
            'response'=> $response
        ), 200);

    }

    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function forwordMessage(Request $request)
    {
        $send_to_ary = json_decode($request->input('users'));
        $msg_id = $request->input('msgId');
        $send_to = implode(",", $send_to_ary);
        $response = Wpp::forwardMessages($send_to , $msg_id , false);

        return response()->json(array(
            'response'=> $response
        ), 200);

    }

    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    // public function setSeenMessage(Request $request)
    // {
        
    //     $userId = $request->input('user_id');

    //     $response = Wpp::setSeenMessage($userId);

    //     return response()->json(array(
    //         'response'=> $response,
    //     ), 200);
    // }


    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllContactsAjax()
    {
        $all_contacts = "";
        $conn_status = "";
        if(session('token') && session('session') && session('init')){
            $all_contacts = Wpp::getAllContacts();
            $conn_status = Wpp::checkWppSessionStatus();
        }
        
        $chats_md5 = md5(json_encode($all_contacts));

        return response()->json(array(
            'all_contacts'=> $all_contacts,
            'status' => $conn_status,
            'chats_md5' => $chats_md5
        ), 200);
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
