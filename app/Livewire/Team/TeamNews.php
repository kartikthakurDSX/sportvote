<?php

namespace App\Livewire\Team;

use App\Models\Comp_news;
use App\Models\News;
use App\Models\User;
use App\Models\Team_member;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TeamNews extends Component
{
    public $team_id;
    public $news_description;
    public $news_id;
    public $news;
    public $is_save;
    public $msg;
    public $char_count;
    public $timezone;

    public $listeners = ['refreshData'];


	public function refresh()
    {
		$this->dispatch('$refresh');
        // Your logic to refresh data goes here
        // For example, you can fetch updated data and update public properties used in the component
    }
    public function refreshData()
    {
        // Your logic to refresh data goes here
        // For example, you can fetch updated data and update public properties used in the component
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }
    public function mount($team)
    {
        $this->team_id = $team;
    }

    public function render()
    {
        $team_news = News::where('type', 1)->where('type_id', $this->team_id)->where('is_active', 1)->latest()->get();
        $team_news_five = News::where('type', 1)->where('type_id', $this->team_id)->where('is_active', 1)->latest()->take(5)->get();
		$team_admins = Team_member::where('team_id',$this->team_id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
		$admins = $team_admins->toArray();
		$team = Team::find($this->team_id);
        $ip = $_SERVER['REMOTE_ADDR'];
            // $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
            // $ipInfo = json_decode($ipInfo);
            // $this->timezone = $ipInfo->timezone;
            $ch = curl_init ("");
            $url = 'http://ip-api.com/json/' . $ip;
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $exec = curl_exec ($ch);
            $ipInfo = json_decode($exec);
            //dd($ipInfo->timezone);
            curl_close($ch);

        if(Auth::check())
        {
            $auth_user = User::find(Auth::user()->id);

            return view('livewire.team.team-news', compact('team_news','admins','team','auth_user','team_news_five'));
        }
        else
        {
            return view('livewire.team.team-news', compact('team_news','admins','team','team_news_five'));
        }

    }

    public function addteam_news()
    {
        if($this->news_description)
        {
            $comp_news = new News();
            $comp_news->type = 1;
            $comp_news->type_id = $this->team_id;
            $comp_news->description = $this->news_description;
            $comp_news->user_id = Auth::user()->id;
            $comp_news->save();
        }

        $this->news_description = "";
        // $this->char_count = 300;
    }

    public function edit_news()
    {
        Comp_news::where('id', $this->news_id)
        ->update([
        'description' => $this->news_description
        ]);
        $this->dispatch('CloseeditcompetitionnewsModal');

    }

     public function open_addteam_news()
	{
		$this->dispatch('OpennewsModal');
	}

	public function close_addcompetition_news()
	{
		$this->dispatch('CloseaddcompetitionnewsModal');
	}

    public function open_edit_news()
	{
		$this->dispatch('OpeneditnewsModal');
	}

	public function close_edit_news()
	{
		$this->dispatch('CloseeditnewsModal');
	}

    public function open_editcompetition_news($id)
    {
        $this->news_id = $id;
        $compnews = Comp_news::where('id', $id)->first();
        $this->news_description = $compnews->description;
        $this->dispatch('OpeneditcompetitionnewsModal');
        $this->dispatch('CloseeditnewsModal');
    }

    public function close_editcompetition_news()
    {
        $this->dispatch('CloseeditcompetitionnewsModal');
    }

    public function delete_post($id)
    {
        $compnews = News::find($id)->delete();

    }
    public function desc_length()
    {
        // dd(strlen($this->news_description));
        if(strlen($this->news_description) < 300)
		{
			$this->is_save = 1;
            $this->char_count =   300 - strlen($this->news_description);
		}
		else
		{
			$this->is_save = 0;
			$this->msg = "You can not use more than 300 characters.";
            $this->char_count =   300 - strlen($this->news_description);
		}
    }
}
