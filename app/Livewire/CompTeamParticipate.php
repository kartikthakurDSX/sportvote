<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Competition;
use App\Models\Team;
use App\Models\Competition_team_request;
use App\Models\Notification;
use App\Models\Match_fixture;
use App\Models\User_profile;
use App\Models\Comp_member;
use App\Models\User;
use App\Models\Competition_attendee;
use App\Models\Team_member;
use Spatie\CalendarLinks\Link;

use Illuminate\Support\Facades\Auth;

class CompTeamParticipate extends Component
{

	public $team_attendees;
	public $open_addteam = false;
	public $team_id = [];
	public $selected_team_id;
	public $team_user_id;
	public $comp_id;
	public $team_members;
	public $attendee_ids = [];
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

    public function mount($competition)
    {
        $this->comp_id = $competition;
    }
    public function render()
    {

		$this->dispatch('addteam');

		$comp_team_request = Competition_team_request::with('team', 'user')
			->where('competition_id', $this->comp_id)
			->where('request_status', '!=', 3)
			->get();

		$comp_teams = Competition_team_request::with('team', 'user')
			->where('competition_id', $this->comp_id)
			->where('request_status', 1)
			->get();

		$comp_teams_chunks = $comp_teams->chunk(10);

		$comp_admins = Comp_member::where('comp_id', $this->comp_id)
			->where('member_position_id', 7)
			->where('invitation_status', 1)
			->where('is_active', 1)
			->pluck('member_id')
			->toArray();

		$admins = $comp_admins;

		$competition = Competition::find($this->comp_id);

		$accept_pending_compteam = Competition_team_request::where('competition_id', $this->comp_id)
			->whereNotIn('request_status', [2, 3])
			->count();

		$comteamids = $comp_team_request
			->filter(function ($comteam) {
				return $comteam->request_status == 0 || $comteam->request_status == 1;
			})
			->pluck('team_id')
			->toArray();

		$imcomteamids = implode(",", $comteamids);

		$competitionlevel = $competition->sport_levels_id;

		$teams = Team::whereNotIn('id', $comteamids)->get();

		$comp_admin_team_ids = Team::where('user_id', $competition->user_id)
			->where('is_active', 1)
			->pluck('id')
			->toArray();

		return view('livewire.comp-team-participate', compact(
			'comp_team_request',
			'admins',
			'competition',
			'accept_pending_compteam',
			'teams',
			'comp_admin_team_ids',
			'comp_teams_chunks'
		));

	}



	public function add_team()
	{
		$this->dispatch('addteam');
		$this->open_addteam = true;

		// $this->dispatch('openModaladdteam');
	}
	 public function send_invitation()
    {
        //dd($this->team_id);
		$competition = Competition::find($this->comp_id);
		if($this->team_id)
		{
            $check_team_num = Competition_team_request::where('competition_id',$this->comp_id)->whereNotIn('request_status',[2,3])->count();
            // dd(var_dump($competition->team_number));
			if($competition->team_number < $check_team_num){
                dd($competition->team_number > $check_team_num);
				$this->dispatch('swal:modal', [

					'message' => $competition->team_number.' teams required',

				]);
			}
			else{
                for($i=0; $i< count($this->team_id); $i++)
                {

                    $team = Team::find($this->team_id[$i]);
                    if($team->user_id == Auth::user()->id)
                    {
                        $request_status = 1;
                    }
                    else
                    {
                        $request_status = 0;
                    }
                    $check_team_request = Competition_team_request::where('competition_id',$this->comp_id)->where('team_id',$this->team_id[$i])->first();
                    $check_team_updated = Competition_team_request::where('competition_id',$this->comp_id)->WhereNotIn('request_status',[2,3])->count();
                    if($competition->team_number > $check_team_updated)
                    {
                        if(!empty($check_team_request))
                        {
                            $comp_team_request = Competition_team_request::find($check_team_request->id);
                            $comp_team_request->request_status = $request_status;
                            $comp_team_request->save();
                            if($team->user_id != Auth::user()->id)
                            {
                                $notification = Notification::create([
                                    'notify_module_id' => 3,
                                    'type_id' => $comp_team_request->id,
                                    'sender_id' => Auth::user()->id,
                                    'reciver_id' =>  $team->user_id,
                                    'is_active' => 1,
                                ]);
                            }
                        }
                        else
                        {
                            $comp_team_request = new Competition_team_request();
                            $comp_team_request->competition_id = $this->comp_id;
                            $comp_team_request->team_id = $this->team_id[$i];
                            $comp_team_request->user_id = $team->user_id;
                            $comp_team_request->save();
                            // dd($comp_team_request);

                            if($team->user_id != Auth::user()->id)
                            {
                                $notification = Notification::create([
                                    'notify_module_id' => 3,
                                    'type_id' => $comp_team_request->id,
                                    'sender_id' => Auth::user()->id,
                                    'reciver_id' =>  $team->user_id,
                                    'is_active' => 1,
                                ]);
                            }
                        }
                    }
                    else
                    {
                         return redirect(route('competition.show', $this->comp_id));
                    }
                }
                $this->open_addteam = false;
                // dd($competition->team_number > $check_team_num);
			}
		}
		else
		{
			$this->dispatch('swal:modal', ['message' => 'select team']);
		}


        $this->team_info = "";
        //$this->dispatch('closeModal');
        //return redirect(route('competition.show', $this->comp_id));
    }
	public function addteamcancel()
	{
		$this->open_addteam = false;
	}


}
