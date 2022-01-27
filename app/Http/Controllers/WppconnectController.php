<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Wppconnect;
//use Session;

class WppconnectController extends Controller
{

    protected $url;
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user = auth()->user();
        //$user_session = $user->wpp_session;
        //$user_token = $user->wpp_token;

	    //# Function: Generated Token
	    //# /api/:session/generate-token
	
        //Session::flush();
        //session(['key' => 'value']);
        //$val = session('key');
        if((!session('token') && !session('session')) || ($user->wpp_token == "")){
            $this->session = base64_encode(md5($user->email));
            Wppconnect::make($this->url);
            $response = Wppconnect::to('/api/'.$this->session.'/'.$this->key.'/generate-token')->asJson()->post();
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
            $response = $this->startWppSession($this->url, session('session') , session('token'));
            session(['init' => true]);
        }

        // Wppconnect::make($this->url);
        // $response = Wppconnect::to('/api/'.session('session').'/qrcode-session')->withHeaders([
        //     'Authorization' => 'Bearer '.session('token')
        // ])->asJson()->post();
        // $response = json_decode($response->getBody()->getContents(),true);

        //dd($this->getQrCode());
        $conn_status = $this->checkWppSessionStatus($this->url, session('session') , session('token'));
        
        if($conn_status['status'] == true){
            //dd($conn_status);
            return redirect()->route("home");
        }
        return view('wpp.getqr');//->with('qrcode', $response['qrcode']);

    }

    public function startWppSession($url, $session, $token)
    {
        Wppconnect::make($url);
        $response = Wppconnect::to('/api/'.$session.'/start-session')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->asJson()->post();
        $response = json_decode($response->getBody()->getContents(),true);

        return $response;
    }

    public function getWppQrcode($url, $session, $token)
    {
        Wppconnect::make($url);//qrcode-session
        $response = Wppconnect::to('/api/'.$session.'/start-session')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->asJson()->get();
        $response = json_decode($response->getBody()->getContents(),true);

        return $response;
    }

    public function checkWppSessionStatus($url, $session, $token)
    {
        Wppconnect::make($url);
        $response = Wppconnect::to('/api/'.$session.'/check-connection-session')->withHeaders([
            'Authorization' => 'Bearer '.$token
        ])->asJson()->get();
        $response = json_decode($response->getBody()->getContents(),true);

        return $response;
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
        if(session('token') && session('session') && session('init')){
            $response = $this->startWppSession($this->url, session('session') , session('token'));
            $conn_status = $this->checkWppSessionStatus($this->url, session('session') , session('token'));
        }
        
        return response()->json(array(
            'response'=> $response,
            'conn_status' => $conn_status
        ), 200);
        //return json_encode($response);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function chat()
    {
        $conn_status = $this->checkWppSessionStatus($this->url, session('session') , session('token'));
        
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
        $all_chats = $this->getAllChats();
        //dd($all_chats);
        $chatsArr = [];
        if($all_chats != "" && $all_chats['status'] == 'success'){
            $chatsArr = $all_chats['response'];
        }
        $chats_md5 = md5(json_encode($all_chats));
        $data = array(
            'title' => 'All Chats',
            'allChats' => $chatsArr,
            'chats_md5' => $chats_md5
        );
        //get all sers/group list - TODO;;
        return view('wpp.chat')->with($data);
    }

    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllChats()
    {
        $response = "";
        $url = $this->url;
        $session = session('session');
        $token = session('token');
        if($token && $session && session('init')){
            Wppconnect::make($url);
            $response = Wppconnect::to('/api/'.$session.'/all-chats')->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->get();
            $response = json_decode($response->getBody()->getContents(),true);
        }
        
        return $response;
    }
    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllChatsAjax()
    {
        $response = "";
        $conn_status = "";
        if(session('token') && session('session') && session('init')){
            $response = $this->getAllChats();
            $conn_status = $this->checkWppSessionStatus($this->url, session('session') , session('token'));
        }
        
        $chats_md5 = md5(json_encode($response));

        return response()->json(array(
            'response'=> $response,
            'conn_status' => $conn_status,
            'chats_md5' => $chats_md5
        ), 200);
        //return json_encode($response);
    }
    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllContacts()
    {
        $response = "";
        $url = $this->url;
        $session = session('session');
        $token = session('token');
        if($token && $session && session('init')){
            Wppconnect::make($url);
            $response = Wppconnect::to('/api/'.$session.'/all-contacts')->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->get();
            $response = json_decode($response->getBody()->getContents(),true);
        }
        
        return $response;
    }
    /**
     * Show the qr code for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getContact($contactNum)
    {
        $response = "";
        $url = $this->url;
        $session = session('session');
        $token = session('token');
        if($token && $session && session('init')){
            Wppconnect::make($url);
            $response = Wppconnect::to('/api/'.$session.'/contact/'.$contactNum)->withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->asJson()->get();
            $response = json_decode($response->getBody()->getContents(),true);
        }
        
        return $response;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        dd("hi");
        //return view('wpp.contact');
        return view('wpp.contact');
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