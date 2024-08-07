<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Competition_team_request;
use App\Models\Match_fixture;
use App\Models\Competition;
use App\Models\Comp_member;
use App\Models\User_profile;
use App\Models\Team_member;
use App\Models\Team;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class CompetitionTeams extends Component
{
    public $comp_id;
    public $competition;
    public $fixture;
    public $selectteamOne_id;
    public $selectteamTwo_id;
    public $left_team;
    public $right_team;
    public $fixture_date;
    public $fixture_location;
    public $fixture_venue;
    public $refree_id;
    public $match_fixture_id;
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

    protected $rules = [
        'selectteamOne_id' => 'required',
        'selectteamTwo_id' => 'required',
        'left_team' => 'required',
        'right_team' => 'required',
        'fixture_date' => 'required',
        'refree_id' => 'required',
        'fixture_location' => 'required',
        'fixture_venue' => 'required'
    ];

    public function mount($competition)
    {
        $this->comp_id = $competition;
    }
    public function render()
    {
        $competition = $this->comp_id;
        $comp = Competition::find($competition);
        $competition_teams = Competition_team_request::where('competition_id',$competition)->where('request_status', '!=', 3)->with('user','team','competition')->get();

        // where request status 1 pending........................ check teams, already created match fixture for them
        $c_team = Competition_team_request::where('competition_id',$competition)->where('request_status',1)->pluck('team_id');
        $match_fixture_teams = Match_fixture::where('competition_id', $this->comp_id)->first();
        $this->match_fixture_id = $match_fixture_teams;
        // dd($teams);
        // End check teams

        $refrees = User_profile::where('profile_type_id',3)->with('user')->get();

        $comp_member = Comp_member::where('comp_id',$competition)->where('invitation_status','!=',3)->where('is_active', 1)->with('member_position','member')->get();
        // One of Game
        if($comp->comp_type_id == 1)
        {
            $comp_teams = Competition_team_request::where('competition_id',$competition)->where('request_status',1)->get();

                 $teamrequeststatus = array();
            foreach($comp_teams as $key => $tm){
                $teamrequeststatus[] = $tm->request_status;
            }
            $importteamrequest = implode(' and ', $teamrequeststatus);


           if($importteamrequest == "1 and 1")
            {
                $comp_referee = Comp_member::where('comp_id',$competition)->where('member_position_id',6)->where('invitation_status',1)->where('is_active', 1)->first();
                if(!empty($comp_referee))
                {
                    $check = Match_fixture::where('competition_id',$competition)->where('teamOne_id',$comp_teams[0]->team_id)->where('teamTwo_id',$comp_teams[1]->team_id)->value('id');
                    if(empty($check))
                    {
                        $check_fixture = Match_fixture::where('competition_id',$competition)->count();
                        if($check_fixture == 0)
                        {
                            $match_fixture = new Match_fixture();
                            $match_fixture->competition_id = $competition;
                            $match_fixture->teamOne_id = $competition_teams[0]->team_id;
                            $match_fixture->teamTwo_id = $competition_teams[1]->team_id;
                            $match_fixture->teamOne_position = 1;
                            $match_fixture->teamTwo_position = 2;
                            $match_fixture->fixture_date = $comp->start_datetime;
                            $match_fixture->fixture_type = 1;
                            $match_fixture->venue = $comp->location;
                            $match_fixture->location = $comp->location;
                            $match_fixture->save();
                        }

                    }
                    else
                    {
                    }
                }
                else
                {

                }

            }

        }
        // End of One of Game fixture

        return view('livewire.competition-teams',compact('match_fixture_teams','competition_teams','competition','comp','comp_member','refrees','importteamrequest'));
    }

    public function start_competition()
    {
        $comp_referee = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',6)->where('invitation_status',1)->first();
        if(!empty($comp_referee))
        {  $competition = Competition::find($this->comp_id);
            $competition->comp_start = 1;
            $competition->save();
                // get all admins from team and team members table
                $comp_team_request = Competition_team_request::where('competition_id',$this->comp_id)->where('request_status',1)->get();
                $team_ids = array();
                foreach($comp_team_request as $comp_team)
                {
                    $team_ids[] = $comp_team->team_id;
                }
                $team_owners = Team::whereIn('id',$team_ids)->get();
                $owners_id = array();
                foreach($team_owners as $owner)
                {
                    $owners_id[] = $owner->user_id;
                }
                $teammembers = Team_member::whereIn('team_id',$team_ids)->where('invitation_status',1)->with('member_position')->get();
                $team_admins = array();

                foreach($teammembers as $tma1)
                {
                    if($tma1->member_position->member_type == 2)
                    {
                        $team_admins[] = $tma1->member_id;
                    }
                }
                $admins = array_merge($owners_id, $team_admins);

                // send notification to all admins
                for($i = 0; $i < Count($admins); $i++)
                    {
                        if($admins[$i] != Auth::user()->id)
                        {
                            $notification = new Notification();
                            $notification->notify_module_id = 6;
                            $notification->type_id = $this->match_fixture_id->id;
                            $notification->sender_id = Auth::user()->id;
                            $notification->reciver_id = $admins[$i];
                            $notification->save();
                        }
                    }


                    session()->flash('message', 'Competition Start');
        }
        else
        {
            $this->dispatch('swal:modal', [

                'message' => 'Referee is not ready for this competition',

            ]);
        }
    }

    public function check_start_comp()
    {
        $competition = Competition::find($this->comp_id);
        if($competition->comp_start == 1)
        {
            return redirect(route('match-fixture.show', $this->match_fixture_id->id));
        }
        else
        {
            $this->dispatch('swal:modal', [

                'message' => 'Competition not start yet.',

            ]);
        }
    }
    public function select_teamOne()
    {
        $this->selectteamOne_id;
    }
    public function select_teamTwo()
    {
        $this->selectteamTwo_id;
    }

    public function left_team_position()
    {
        $this->left_team;
    }

    public function create_fixture()
    {
        $this->validate();
        $check_fixture = Match_fixture::where('competition_id',$this->comp_id)->count();
        if($check_fixture == 0)
        {
            $match_fixture = new Match_fixture();
            $match_fixture->competition_id = $this->comp_id;
            $match_fixture->teamOne_id = $this->selectteamOne_id;
            $match_fixture->teamTwo_id = $this->selectteamTwo_id;
            $match_fixture->TeamOne_position = $this->left_team;
            $match_fixture->TeamTwo_position = $this->right_team;
            $match_fixture->fixture_date = $this->fixture_date;
            $match_fixture->location = $this->fixture_location;
            $match_fixture->venue = $this->fixture_venue;
            $match_fixture->save();
             return redirect('my_competition');
        }
    }
}
