<?php

namespace App\Livewire\Playerprofile;

use App\Models\User_profile;
use App\Models\Team_member;
use App\Models\Youtube_video;
use Livewire\Component;

class AddEditYoutubevideo extends Component
{
    public $player_id;
    public $playervideo_id;
    public $addvideo_title;
    public $addvideo_link;
    public $editvideo_title;
    public $editvideo_link;
    public $user_email;
    public $user_address;
    public $user_phone_number;
    public $userid;
    public $team_member;

    protected function rules()
    {
        return [
            'addvideo_link' => 'required',
            'editvideo_link' => 'required',
        ];
    }
    protected $messages = [
        'addvideo_link.required' => 'Video link is required',
        'editvideo_link.required' => 'Video link is required',
        'user_email.email' => 'The email must be a valid email address.'
    ];

    public function mount($player)
    {
        $this->player_id = $player;
        $user = User_profile::select('id','user_phone_number','user_email','user_address')->where('user_id',$this->player_id)->first();
        if(!empty($user))
        {
            $this->user_email = $user->user_email;
            $this->user_phone_number = $user->user_phone_numebr;
            $this->user_address = $user->user_address;
            $this->userid = $user->id;
        }
        $this->team_member = Team_member::select('team_id')->where('member_id',$player)->where('invitation_status',1)->latest()->first();

    }

    public function render()
    {
        $playeryoutubevideos = Youtube_video::where('type', 3)->where('type_id', $this->player_id)->where('is_active', 1)->get();
        $user = User_profile::select('id','user_phone_number','user_email','user_address')->where('user_id',$this->player_id)->first();

        return view('livewire.playerprofile.add-edit-youtubevideo', compact('playeryoutubevideos','user'));
    }


    public function add_playervideo()
    {
        $youtubevideo = Youtube_video::create([
            'type'=> 3,
            'type_id'=> $this->player_id,
            'video_title'=> $this->addvideo_title,
            'video_link'=> $this->addvideo_link,
        ]);

        if($youtubevideo){
            $this->addvideo_title = "";
            $this->addvideo_link = "";
            $this->dispatch('CloseaddplayeryoutubevideoModal');
            $this->dispatch('OpenlistplayeryoutubevideoModal');
        }
    }

    public function editplayer_youtubevideo()
    {
        //$this->validate();
        $player_youtubevideo = Youtube_video::find($this->playervideo_id);
        $player_youtubevideo->video_title = $this->editvideo_title;
        $player_youtubevideo->video_link = $this->editvideo_link;
        $player_youtubevideo->save();

        if($player_youtubevideo){
            $this->dispatch('CloseeditplayeryoutubevideoModal');
            $this->dispatch('OpenlistplayeryoutubevideoModal');
        }
    }

    public function open_addplayer_youtubevideo()
	{
        $this->dispatch('CloselistplayeryoutubevideoModal');
		$this->dispatch('OpenaddplayeryoutubevideoModal');
	}
	public function close_addplayer_youtubevideo()
	{
		$this->dispatch('CloseaddplayeryoutubevideoModal');
	}
    public function open_listplayer_youtubevideo()
	{
		$this->dispatch('OpenlistplayeryoutubevideoModal');
	}
	public function close_listplayer_youtubevideo()
	{
		$this->dispatch('CloselistplayeryoutubevideoModal');
	}
    public function open_editplayer_youtubevideo($id)
	{
        $this->playervideo_id = $id;
        $player_youtube_video = Youtube_video::find($this->playervideo_id);
        $this->editvideo_title = $player_youtube_video->video_title;
        $this->editvideo_link = $player_youtube_video->video_link;
		$this->dispatch('OpeneditplayeryoutubevideoModal');
	}
	public function close_editplayer_youtubevideo()
	{
		$this->dispatch('CloseeditplayeryoutubevideoModal');
	}

    public function deleteplayer_video($id)
    {
        $video = Youtube_video::find($id);
        $video->is_active = 0;
        $video->save();
        if($video){
            $this->dispatch('OpenlistplayeryoutubevideoModal');
        }
    }
    public function open_contact_us_modal()
    {
        $this->dispatch('open_contact_us');
    }
    public function close_contact_us_modal()
    {
        $this->dispatch('close_contact_us');
    }
    public function save_comp_contact($user_profile_id)
    {
        $this->validate([
            'user_email'=>'email',
            'user_phone_number' => 'max:15',
            'user_address' => 'max:250',
        ]);
        $update_suser_profile = User_profile::find($user_profile_id);
        $update_suser_profile->user_email = $this->user_email;
        $update_suser_profile->user_phone_number = $this->user_phone_number;
        $update_suser_profile->user_address = $this->user_address;
        $update_suser_profile->save();
        if($update_suser_profile){
            $this->dispatch('close_contact_us');
        }
    }
}
