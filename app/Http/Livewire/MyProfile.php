<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MyProfile extends Component
{
    
    public $myProfileImg;
    protected $listeners = ['update_my_profile_img' => 'updateMyProfileImg'];

    public function updateMyProfileImg($myImg)
    { 
        $this->myProfileImg = $myImg;
    }
    public function render()
    {
        return view('livewire.my-profile');
    }
}
