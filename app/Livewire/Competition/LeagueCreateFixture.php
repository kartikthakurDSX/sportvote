<?php

namespace App\Livewire\Competition;
use App\Models\Competition;
use App\Models\Match_fixture;
use App\Models\Competition_team_request;
use App\Models\Team_member;
use App\Models\Team;
use App\Models\Notification;
use App\Models\Comp_member;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class LeagueCreateFixture extends Component
{
    public $comp_id;
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
        $competition = Competition::find($this->comp_id);
        $comp_admins = Comp_member::where('comp_id',$competition->id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->with('member')->pluck('member_id');
		$admins = $comp_admins->toArray();
        $comp_referee = Comp_member::select('member_id')->where('comp_id',$competition->id)->where('invitation_status',1)->where('is_active',1)->count();
        $fixtures = Match_fixture::where('competition_id',$competition->id)->latest()->count();
        return view('livewire.competition.league-create-fixture',compact('competition','comp_referee','fixtures','admins'));
    }
      public function start_competition()
    {
        $comp_referee = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',6)->where('invitation_status',1)->first();
        if(!empty($comp_referee))
        {
            $match_fixture = Match_fixture::where('competition_id',$this->comp_id)->get();
            $competition = Competition::find($this->comp_id);
            if($competition->team_number % 2 == 0)
            {
                //Even Team
                $team_type = "Even";
                $t_rounds = $competition->team_number-1;
                $r_fixtures = $competition->team_number / 2;

            }
            else
            {
                //Odd Team
                $team_type = "Odd";
                $t_rounds = $competition->team_number;
                $r_fixtures = (int)($competition->team_number / 2);
            }
            if($competition->comp_subtype_id == 5)
            {
                $total_rounds = $t_rounds * 2;
                $round_fixtures = $r_fixtures;
            }
            elseif($competition->comp_subtype_id == 6)
            {
                $total_rounds = $t_rounds * 3;
                $round_fixtures = $r_fixtures;
            }
            else
            {
                $total_rounds = $t_rounds;
                $round_fixtures = $r_fixtures;
            }
            $total_fixtures = $total_rounds * $round_fixtures;
            if($match_fixture->count() == $total_fixtures)
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
                    $this->dispatch('swal:modal', ['message' => 'Competition Start!!']);
                    return redirect(route('competition.show', $this->comp_id));
                }
                else
                {
                $this->dispatch('swal:modal', ['message' => 'Create All Rounds Fixtures']);
            }
        }
        else
        {
            $this->dispatch('swal:modal', ['message' => 'Referee is not ready for this competition']);
        }
    }
    public function all_ics_file()
	{
		// dd($this->comp_id);
		$all_fixtures = Match_fixture::where('competition_id',$this->comp_id)->where('teamOne_id','!=','teamTwo_id')->get();
		$competition = Competition::find($this->comp_id);
		$ip = $_SERVER['REMOTE_ADDR'];
		$ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
		$ipInfo = json_decode($ipInfo);
		$timezone = $ipInfo->timezone;




		foreach($all_fixtures as $fixture)
		{
            $dt = strtotime($fixture->fixture_date);
			$icalObject[] =	"BEGIN:VCALENDAR\nVERSION:2.0\nMETHOD:PUBLISH\nBEGIN:VEVENT\nDTSTART;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nDTEND;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nLOCATION:".$fixture->location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nSUMMARY:".$competition->name."\nDESCRIPTION:".$competition->name."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR";
		}
		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="cal.ics"');
		$contents = $icalObject;
		$filename = $competition->name.'fixture_event.ics';
		return response()->streamDownload(function () use ($contents) {
			echo implode("\n",$contents);
		}, $filename);
		//dd($all_fixtures);
	}
}
