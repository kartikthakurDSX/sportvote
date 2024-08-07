<?php

namespace App\Livewire\Team;
use App\Models\Team_member;
use App\Models\Team;
use App\Models\Youtube_video;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddyoutubeVideo extends Component
{
    public $youtubevideo;
    public $video_title;
    public $video_description;
    public $video_link;
    public $video_id;

    protected function rules()
    {

        return [
            'video_link' => 'required'

        ];

    }
    protected $messages = [
        'video_description.required' => 'Select image for Sponsor',
    ];
    public function mount($team)
    {
        $this->team_id = $team;
    }

    public function render()
    {
        $youtube_video = Youtube_video::select('video_link','id')->where('type', 1)->where('type_id', $this->team_id)->where('is_active', 1)->get();
        $this->youtubevideo = $youtube_video;
        $video = Youtube_video::where('type', 1)->where('type_id', $this->team_id)->where('is_active', 1)->latest()->first();
		$team_admins = Team_member::where('team_id',$this->team_id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
		$admins = $team_admins->toArray();
		$team = Team::find($this->team_id);
        return view('livewire.team.addyoutube-video', compact('video','admins','team'));
    }

    public function addcomp_video()
    {
        $this->validate();
        $comp_video = new Youtube_video();
        $comp_video->type = 1;
        $comp_video->type_id = $this->team_id;
        $comp_video->video_link = $this->video_link;
        $comp_video->save();
        $this->video_title ="";
        $this->video_description ="";
        $this->video_link ="";
        $this->dispatch('Closecompyoutube_videoModal');
        $this->dispatch('OpeneditvideoModal');
    }

    public function editcomp_video()
    {
        $compyoutube_video = Youtube_video::find($this->video_id);
        $compyoutube_video->video_link = $this->video_link;
        $compyoutube_video->save();
        if($compyoutube_video){
            $this->dispatch('Closeeditcompyoutube_videoModal');
        }
    }

    public function open_compyoutube_video()
	{
        $this->dispatch('CloseeditvideoModal');
		$this->dispatch('Opencompyoutube_videoModal');
	}

	public function close_compyoutube_video()
	{
		$this->dispatch('Closecompyoutube_videoModal');
	}

    public function open_edityoutube_video()
	{
		$this->dispatch('OpeneditvideoModal');
	}

	public function close_edityoutube_video()
	{
		$this->dispatch('CloseeditvideoModal');
	}

    public function open_editcompyoutube_video($id)
	{
        $this->video_id = $id;
        $compyoutube_video = Youtube_video::find($id);
        $this->video_title = $compyoutube_video->video_title;
        $this->video_description = $compyoutube_video->description;
        $this->video_link = $compyoutube_video->video_link;
		$this->dispatch('Openeditcompyoutube_videoModal');
	}

	public function close_editcompyoutube_video()
	{
		$this->dispatch('Closeeditcompyoutube_videoModal');
	}

    public function deletecomp_video($id)
    {
        $compvideo = Youtube_video::find($id)->delete();

            $this->dispatch('Closeeditcompyoutube_videoModal');

    }
}
