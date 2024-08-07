<?php

namespace App\Livewire\Competition;

use Livewire\Component;
use App\Models\Competition;
use App\Models\Match_fixture;
use App\Models\Comp_member;
use App\Models\Team;
use App\Models\Competition_attendee;
use App\Models\Team_member;
use App\Models\Notification;
use App\Models\Competition_team_request;
use Illuminate\Support\Facades\Auth;

class CompKoFixtureTable extends Component
{
	public $selectteamOne_id;
	public $selectteamTwo_id;
	public $fixture_venue;
	public $fixture_date;
	public $refree_id;
	public $comp_id;
	public $fixture_location;
	public $selected_team_name = "";
	public $round_start;
	public $next_comp_team;
	public $matchfixtureteamids;
	public $current_round;
	public $first_comp_team = true;

	protected $rules = [
        'selectteamOne_id' => 'required',
        'fixture_date' => 'required',
        'fixture_location' => 'required',
        'fixture_venue' => 'required'
    ];


	public function mount($comp)
    {
        $this->comp_id = $comp;
		$refree_ids = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',6)->where('invitation_status',1)->first();
		if($refree_ids){
			$this->refree_id = $refree_ids->member_id;
		}

    }
    public function render()
    {
		$valid_rounds = ['4', '8', '16', '32', '64', '128'];
		$competition = Competition::select('team_number', 'user_id', 'comp_start', 'squad_players_num')->find($this->comp_id);
		$comp_round = $competition->team_number;

		$round_array = [];
		while ($comp_round > 1) {
			$comp_round =  $comp_round / 2;
			$round_num = floor($comp_round);
			$round_array[] = (int) $round_num;
		}

		$comp_teams = Competition_team_request::select('id', 'team_id', 'request_status', 'competition_id')
			->where('competition_id', $this->comp_id)
			->where('request_status', 1)
			->with('team:id,name,team_logo')
			->get();

		$squad_selected_teams = $comp_teams->filter(function ($comp_team) use ($competition) {
			$comp_team_squad_player = Competition_attendee::where('competition_id', $this->comp_id)
				->where('team_id', $comp_team->team->id)
				->count();

			return $comp_team_squad_player == $competition->squad_players_num;
		})->pluck('team.team_id')->toArray();

		$comp_admins = Comp_member::where('comp_id', $this->comp_id)
			->where('member_position_id', 7)
			->where('invitation_status', 1)
			->where('is_active', 1)
			->pluck('member_id')
			->toArray();

		$admins = $comp_admins;

		$this->round_start = in_array($competition->team_number, $valid_rounds) ? 1 : 0;
		$total_rounds = count($round_array) - (!$this->round_start ? 1 : 0);

		$SRmatch_fixture = Match_fixture::where('competition_id', $this->comp_id)
			->where('fixture_round', $this->round_start)
			->with('teamOne:name,id,team_logo', 'teamTwo:name,id,team_logo')
			->orderBy('fixture_type')
			->get();

		$fixtureteamids = array_merge(
			$SRmatch_fixture->pluck('teamOne_id')->toArray(),
			$SRmatch_fixture->pluck('teamTwo_id')->toArray()
		);

		$accepted_comp_team = Competition_team_request::where('competition_id', $this->comp_id)
			->where('request_status', 1)
			->count();

		$refrees = Comp_member::where('comp_id', $this->comp_id)
			->where('member_position_id', 6)
			->where('invitation_status', 1)
			->with('member:id,first_name,last_name')
			->get();

		$Sr_completed_round = Match_fixture::where('competition_id', $this->comp_id)
			->where('fixture_round', $this->round_start)
			->where('finishdate_time', '!=', null)
			->count();

		$next_round_teams = Match_fixture::select('id', 'teamOne_id', 'teamTwo_id', 'winner_team_id', 'finishdate_time', 'competition_id', 'fixture_round')
			->where('competition_id', $this->comp_id)
			->where('finishdate_time', '!=', null)
			->with('teamOne:name,id,team_logo', 'teamTwo:name,id,team_logo')
			->get();

		$groupBy_next_round_teams = $next_round_teams->groupBy('fixture_round');



		return view('livewire.competition.comp-ko-fixture-table', compact(
			'valid_rounds',
			'competition',
			'comp_teams',
			'admins',
			'fixtureteamids',
			'SRmatch_fixture',
			'Sr_completed_round',
			'accepted_comp_team',
			'refrees',
			'groupBy_next_round_teams',
			'squad_selected_teams',
			'total_rounds'
		));


	}
    public function delete_fixture($id)
	{
		$match_fix = Match_fixture::find($id);
		$match_fix->delete();
		session()->flash('message', 'fixture canceled');
		return redirect()->back();


	}
    public function check_start_comp($id)
    {
        $competition = Competition::find($this->comp_id);
        if($competition->comp_start == 1)
        {
            return redirect(route('match-fixture.show', $id));
        }
        else
        {
            $this->dispatch('swal:modal', [

                'message' => 'Competition not start yet.',

            ]);
        }
    }
    public function ics_file($id)
	{
		$match_fixture = Match_fixture::find($id);
		$competition = Competition::find($match_fixture->competition_id);

		$ip = $_SERVER['REMOTE_ADDR'];
		$ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
		$ipInfo = json_decode($ipInfo);
		$timezone = $ipInfo->timezone;
		$dt = strtotime($match_fixture->fixture_date);

		$icalObject=	"BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//ical.marudot.com//iCal Event Maker\nBEGIN:VEVENT\nDTSTART;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nDTEND;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nLOCATION:".$competition->location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nSUMMARY:".$competition->name."\nDESCRIPTION:".$competition->name."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR\n";

		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="cal.ics"');
		$contents = $icalObject;
		$filename = 'fixture_event.ics';
		return response()->streamDownload(function () use ($contents) {
			echo $contents;
		}, $filename);
	}
    public function all_ics_file()
	{
		//dd($this->comp_id);
		$all_fixtures = Match_fixture::where('competition_id',$this->comp_id)->where('teamOne_id','!=','teamTwo_id')->get();
		$competition = Competition::find($this->comp_id);




		foreach($all_fixtures as $fixture)
		{
			$ip = $_SERVER['REMOTE_ADDR'];
			$ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
			$ipInfo = json_decode($ipInfo);
			$timezone = $ipInfo->timezone;
			$dt = strtotime($fixture->fixture_date);
			$icalObject[] =	"BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//ical.marudot.com//iCal Event Maker\nBEGIN:VEVENT\nDTSTART;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nDTEND;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nLOCATION:".$competition->location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nSUMMARY:".$competition->name."\nDESCRIPTION:".$competition->name."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR";
		}
		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="cal.ics"');
		$contents = $icalObject;

		$filename = $competition->name.'fixture_event.ics';
		return response()->streamDownload(function () use ($contents) {
			echo implode("\n",$contents);
			//print_r($contents);
			// $contents;
		}, $filename);
		//dd($all_fixtures);
	}
    public function start_competition()
    {
		$comp_referee = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',6)->where('invitation_status',1)->first();
        if(!empty($comp_referee))
        {
			$match_fixture = Match_fixture::where('competition_id',$this->comp_id)->get();
			$competition = Competition::find($this->comp_id);

			if($match_fixture->count() > 0)
			{
				$exceed_fixture_date = array();
				foreach($match_fixture as $mtf)
				{
					if($mtf->fixture_date < $competition->start_datetime)
					{
						$exceed_fixture_date[] = $mtf->id;
					}
				}

					$competition = Competition::find($this->comp_id);
					$competition->comp_start = 1;
					$competition->save();
					// get all admins from team and team members table
					$comp_team_request = Competition_team_request::select('team_id')->where('competition_id',$this->comp_id)->where('request_status',1)->get();
					$team_ids = array();
					foreach($comp_team_request as $comp_team)
					{
						$team_ids[] = $comp_team->team_id;
					}
					$team_owners = Team::select('user_id')->whereIn('id',$team_ids)->get();
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
					$admins1 = array_merge($owners_id, $team_admins);
					//$admins = array_unique(array_filter($admins1));
					//dd($admins1);
					// send notification to all admins
					for($i = 0; $i < Count($admins1); $i++)
					{
						//if($admins[$i] != Auth::user()->id)

						$notification = new Notification();
						$notification->notify_module_id = 9;
						$notification->type_id = $competition->id;
						$notification->sender_id = Auth::user()->id;
						$notification->reciver_id = $admins1[$i];
						$notification->save();

					}
					session()->flash('message', 'Competition Start');
			}
			else
			{
				$this->dispatch('swal:modal', [

					'message' => 'Create Fixture',

				]);
			}
		}
		else
		{
			$this->dispatch('swal:modal', [

                'message' => 'Referee is not ready for this competition',

            ]);
		}
    }
    public function move_create_fixture($id,$round)
	{
		//dd($round);

		if($round == -1)
		{
			$this->first_comp_team = true;
			$this->current_round = $this->round_start;
		}
		else
		{
			$this->current_round = $round + 1;
			$this->first_comp_team = false;
			$next_round_num = $round + 1;
            $next_round_team_ids = Match_fixture::where('competition_id',$this->comp_id)->where('finishdate_time','!=',null)->where('fixture_round',$round)->pluck('winner_team_id');
            $next_fixtures = Match_fixture::where('competition_id',$this->comp_id)->where('fixture_round',$next_round_num)->get();
            $nextfixtureteamoneids = array();
            $nextfixtureteamtwoids = array();
            foreach($next_fixtures as $fixtureteam){
                $nextfixtureteamoneids[] = $fixtureteam['teamOne_id'];
                $nextfixtureteamtwoids[] = $fixtureteam['teamTwo_id'];
            }
            $this->matchfixtureteamids = array_merge($nextfixtureteamoneids, $nextfixtureteamtwoids);
            $this->next_comp_team = Team::select('id','name','team_logo')->whereIn('id',$next_round_team_ids)->get();

		}
		$comp_referee = Comp_member::select('comp_id','member_position_id','invitation_status')->where('comp_id',$this->comp_id)->where('member_position_id',6)->where('invitation_status',1)->first();
        if(!empty($comp_referee))
        {
			$this->selectteamOne_id = $id;

			$this->selected_team_name = Team::find($id);

			$this->dispatch('openModal');
		}
		else
		{
			$this->dispatch('swal:modal', [

				'message' => 'Referee is not ready for this competition',

			]);
		}

	}
    public function close_modal()
    {
        $this->dispatch('closeModal');
    }
	public function save_move_fixture()
	{
		//dd($this->fix_round_num);
		$refree_ids = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',6)->where('invitation_status',1)->where('is_active', 1)->first();
		if($refree_ids){
			$refree_id = $refree_ids->member_id;
		}
			if($this->selectteamTwo_id)
			{
				$competition = Competition::find($this->comp_id);
				if($competition->start_datetime == NULL)
				{
					$competition->start_datetime = $this->fixture_date;
					$competition->save();
				}

				$this->validate();
				$match_fixture = new Match_fixture();
				$match_fixture->competition_id = $this->comp_id;
				$match_fixture->teamOne_id = $this->selectteamOne_id;
				$match_fixture->teamTwo_id = $this->selectteamTwo_id;
				$match_fixture->fixture_date = $this->fixture_date;
				$match_fixture->location = $this->fixture_location;
				$match_fixture->venue = $this->fixture_venue;
				// $match_fixture->refree_id = $refree_id;
				$match_fixture->fixture_type = 0;
				$match_fixture->fixture_round = $this->current_round;
				$match_fixture->save();
				$this->selectteamTwo_id = "";
				$this->dispatch('closeModal');
				return redirect()->back();
			}
			else
			{

				$competition = Competition::find($this->comp_id);
				if($competition->start_datetime == NULL)
				{
					$competition->start_datetime = $this->fixture_date;
					$competition->save();
				}
				$this->validate();
				$match_fixture = new Match_fixture();
				$match_fixture->competition_id = $this->comp_id;
				$match_fixture->teamOne_id = $this->selectteamOne_id;
				$match_fixture->teamTwo_id =  $this->selectteamOne_id;
				$match_fixture->winner_team_id = $this->selectteamOne_id;
				$match_fixture->fixture_date = $this->fixture_date;
				$match_fixture->location = $this->fixture_location;
				$match_fixture->venue = $this->fixture_venue;
				$match_fixture->refree_id = $refree_id;
				$match_fixture->fixture_type = 9;
				$match_fixture->finishdate_time = now();
				$match_fixture->fixture_round = $this->current_round;
				$match_fixture->save();
				$this->selectteamTwo_id ="";
				$this->dispatch('closeModal');
				//return redirect()->back();
			}
	}
	public function cancel_button()
	{
		$this->selectteamTwo_id = "";
	}
}
