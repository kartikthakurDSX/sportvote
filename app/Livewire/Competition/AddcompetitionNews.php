<?php

namespace App\Livewire\Competition;

use App\Models\Comp_member;
use App\Models\Competition;
use App\Models\Comp_news;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddcompetitionNews extends Component
{
    public $competition;
    public $news_title;
    public $news_description;
    public $news_id;
    public $news;
    public $is_save;
    public $msg;
    public $char_count;
    public $timezone;

    public function mount($competition)
    {
        $this->comp_id = $competition;
    }

    public function render()
    {
        // $competition_news = News::where('type', 2)->where('type_id', $this->comp_id)->where('is_active', 1)->latest()->get();
        // $competition_news_five = News::where('type', 2)->where('type_id', $this->comp_id)->where('is_active', 1)->with('user')->latest()->take(5)->get();
        // $comp_admins = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->pluck('member_id');
        // $admins = $comp_admins->toArray();
        // $comp = Competition::find($this->comp_id);
        // $ip = $_SERVER['REMOTE_ADDR'];
        // // $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
        // // $ipInfo = json_decode($ipInfo);
        // // $this->timezone = $ipInfo->timezone;
        // $ch = curl_init ("");
        // $url = 'http://ip-api.com/json/' . $ip;
        // curl_setopt ($ch, CURLOPT_URL, $url);
        // curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        // $exec = curl_exec ($ch);
        // $ipInfo = json_decode($exec);
        // //dd($ipInfo->timezone);
        // curl_close($ch);
        // if(Auth::check())
        // {
        //     $auth_user = User::find(Auth::user()->id);
        //     return view('livewire.competition.addcompetition-news', compact('competition_news','admins','comp','auth_user','competition_news_five'));
        // }
        // else
        // {
        //     return view('livewire.competition.addcompetition-news', compact('competition_news','admins','comp','competition_news_five'));
        // }

        $competition_news = News::where('type', 2)
            ->where('type_id', $this->comp_id)
            ->where('is_active', 1)
            ->latest()
            ->get();

        $competition_news_five = News::where('type', 2)
            ->where('type_id', $this->comp_id)
            ->where('is_active', 1)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $comp_admins = Comp_member::where('comp_id', $this->comp_id)
            ->where('member_position_id', 7)
            ->where('invitation_status', 1)
            ->where('is_active', 1)
            ->pluck('member_id');

        $admins = $comp_admins->toArray();

        $comp = Competition::find($this->comp_id);

        $ip = $_SERVER['REMOTE_ADDR'];
        $ch = curl_init("");
        $url = 'http://ip-api.com/json/' . $ip;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $exec = curl_exec($ch);
        $ipInfo = json_decode($exec);
        curl_close($ch);

        if (Auth::check()) {
            $auth_user = User::find(Auth::user()->id);
            return view('livewire.competition.addcompetition-news', compact('competition_news', 'admins', 'comp', 'auth_user', 'competition_news_five'));
        } else {
            return view('livewire.competition.addcompetition-news', compact('competition_news', 'admins', 'comp', 'competition_news_five'));
        }
    }

    public function addcomp_news()
    {
        //dd($this->news_description);
        if ($this->news_description) {
            $comp_news = new News();
            $comp_news->type = 2;
            $comp_news->type_id = $this->comp_id;
            $comp_news->description = $this->news_description;
            $comp_news->user_id = Auth::user()->id;
            $comp_news->save();
        }

        $this->news_description = "";
        $this->char_count = 300;
        // $this->dispatch('CloseaddcompetitionnewsModal');
        // return redirect(route('competition.show', $this->comp_id));
    }

    public function edit_news()
    {
        Comp_news::where('id', $this->news_id)
            ->update([
                'description' => $this->news_description
            ]);
        $this->dispatch('CloseeditcompetitionnewsModal');
        return redirect(route('competition.show', $this->comp_id));
    }

    public function open_addcompetition_news()
    {
        $this->dispatch('OpennewsModal');
        //$this->dispatch('CloseeditnewsModal');
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
        if (strlen($this->news_description) < 300) {
            $this->is_save = 1;
            $this->char_count =   300 - strlen($this->news_description);
        } else {
            $this->is_save = 0;
            $this->msg = "You can not use more than 300 characters.";
            $this->char_count =   300 - strlen($this->news_description);
        }
    }
}
