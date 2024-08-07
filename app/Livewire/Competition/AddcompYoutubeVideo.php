<?php

namespace App\Livewire\Competition;
use App\Models\Competition;
use App\Models\Comp_member;
use App\Models\Youtube_video;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddcompYoutubeVideo extends Component
{
    public $youtube_video;
    public $compvideo;
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
		'video_link' =>  'Enter Video link',
    ];

    public function mount($competition)
    {
        $this->comp_id = $competition;
        // $competition_video = Youtube_video::where('comp_id', $this->comp_id)->where('is_active', 1)->get();
        // $this->compvideo = $competition_video;
    }

    public function render()
    {
        $competition_video = Youtube_video::where('type', 2)->where('type_id', $this->comp_id)->where('is_active', 1)->orderBy('id','DESC')->get();
        // $competition_video = Youtube_video::where('comp_id', $this->comp_id)->where('is_active', 1)->latest()->first();
        $this->youtubevideo = $competition_video;
        $video = Youtube_video::where('type', 2)->where('type_id', $this->comp_id)->where('is_active', 1)->latest()->first();
        $comp_admins = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->pluck('member_id');
		$admins = $comp_admins->toArray();
		$competition = Competition::find($this->comp_id);
        return view('livewire.competition.addcomp-youtube-video',compact('competition_video','admins','video','competition'));
    }

    public function addcomp_video()
    {
        $this->validate();
        $comp_video = new Youtube_video();
        $comp_video->type = 2;
        $comp_video->type_id = $this->comp_id;
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
