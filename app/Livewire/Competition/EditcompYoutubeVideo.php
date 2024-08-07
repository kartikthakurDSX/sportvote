<?php

namespace App\Livewire\Competition;

use App\Models\Comp_youtube_video;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EditcompYoutubeVideo extends Component
{
    public $competition;
    public $video_id;
    public $video_title;
    public $video_description;
    public $video_link;

    public function mount($competition)
    {
        $this->comp_id = $competition;
        $competition_video = Comp_youtube_video::select('id','title','description','link')
                ->where('user_id', Auth::user()->id)->where('comp_id', $this->comp_id)
                ->first();
        $this->video_id = $competition_video->id;
        $this->video_title = $competition_video->title;
        $this->video_description = $competition_video->description;
        $this->video_link = $competition_video->link;
    }
    public function render()
    {
        return view('livewire.competition.editcomp-youtube-video');
    }

    public function editcompyoutube_video()
    {
        $compyoutube_video = Comp_youtube_video::find($this->video_id);
        $compyoutube_video->title = $this->video_title;
        $compyoutube_video->description = $this->video_description;
        $compyoutube_video->link = $this->video_link;
        $compyoutube_video->save();
        $this->dispatch('Closeeditcompyoutube_videoModal');
    }
    public function open_editcompyoutube_video()
	{
		$this->dispatch('Openeditcompyoutube_videoModal');
	}

	public function close_editcompyoutube_video()
	{
		$this->dispatch('Closeeditcompyoutube_videoModal');
	}
}
