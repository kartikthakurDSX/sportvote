<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Competition_team_request;
use Illuminate\Support\Facades\Auth;

class CompetitionRequests extends Component
{
    public $team_member;
    public $comp_request_id;
    public $comp_attendees;
    public $competition;
    public $attendee_ids = [];
    public $selected_comp;
    public function render()
    {
        if(Auth::check())
        {
            $user_id = Auth::user()->id;
        }
        else
        {
            $user_id = "";
        }
        $competition_request = Competition_team_request::where('user_id',$user_id)->with('competition','team')->latest()->get();
        $pending_competition_request = Competition_team_request::where('user_id',$user_id)->where('request_status',0)->with('competition','team')->latest()->get();
        return view('livewire.competition-requests',compact('competition_request','pending_competition_request'));
    }

    public function select_player($id)
    {
        $players_type_ids = Member_position::where('member_type',1)->pluck('id');
        $players_type_ids_array = $players_type_ids->toArray();

        $competition_team_request = Competition_team_request::find($id);
        $competition_team_request->request_status = 1;
        $competition_team_request->accepted_by = Auth::user()->id;
        $competition_team_request->save();
        $notification = Notification::where('notify_module_id',3)->where('type_id',$id)->update(['is_seen' => 1]);

        $this->dispatch('openModal');
		 $comp = Competition::find($competition_team_request->competition_id);
         $this->selected_comp = $comp;

        $comp_attendees_ids = Competition_attendee::where('competition_id',$competition_team_request->competition_id)->pluck('attendee_id');
        $comp_attendees_array = $comp_attendees_ids->toArray();
        $comp_referee = Comp_member::where('comp_id',$competition_team_request->competition_id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->pluck('member_id');
        $comp_referee_array = $comp_referee->toArray();
        $comp_attendees_ids_a = array_merge($comp_attendees_array,$comp_referee_array);

        $team_member = Team_member::whereNotIn('member_id',$comp_attendees_ids_a)->whereIn('member_position_id',$players_type_ids_array)->where('team_id',$competition_team_request->team_id)->where('invitation_status',1)->where('is_active',1)->with('members','member_position')->get();
        $comp_attendees = Competition_attendee::where('competition_id',$competition_team_request->competition_id)->get();
        $this->team_member = $team_member;
        $this->comp_request_id = $id;
		$this->comp_attendees = $comp_attendees;
		$this->competition = $comp;
    }
	 public function reject_compjoin($id)
    {
        $notification = Notification::where('notify_module_id',3)->where('type_id',$id)->update(['is_seen' => 1 , 'is_active' => 0]);
         $comp_team_request = Competition_team_request::find($id);
         $comp_team_request->request_status = 2;
         $comp_team_request->save();
    }
    public function submit_player($comp_team_request_id)
    {
        //dd($this->attendee_ids);
        $competition_id = Competition_team_request::select('competition_id', 'team_id')->find($comp_team_request_id);
        $competition = Competition::select('squad_players_num')->find($competition_id->competition_id);
        $comp_ateendes = Competition_attendee::where('Competition_id',$competition_id->competition_id)->where('team_id',$competition_id->team_id)->count();
        $total_attende = $comp_ateendes + count($this->attendee_ids);

        if(count($this->attendee_ids) > 0)
        {
            if($total_attende <= $competition->squad_players_num)
            {
                foreach($this->attendee_ids as $attendee)
                {
                    $comp_attendee = new Competition_attendee();
                    $comp_attendee->Competition_id = $competition_id->competition_id;
                    $comp_attendee->team_id = $competition_id->team_id;
                    $comp_attendee->attendee_id = $attendee;
                    $comp_attendee->save();
                }


             return redirect(route('competition.show', $competition_id->competition_id));
            }
            else
            {
                $this->dispatch('swal:modal', [

                 'message' => 'You cant add more than '.$competition->squad_players_num.' Players',

             ]);
            }
        }
    }
    public function removeselected__player($index)
    {
        //dd($this->attendee_ids);
        unset($this->attendee_ids[$index]);
    }
}
