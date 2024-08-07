<?php
namespace App\Livewire\Competition;
use App\Models\Match_fixture;
use App\Models\Competition;
use Livewire\Component;
use DateTimeZone;
use Carbon\Carbon;
class LeaugeIcsFile extends Component
{
    public $fixture;
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
    public function mount($fixture_id)
    {
        $this->fixture = Match_fixture::find($fixture_id);
    }
    public function render()
    {
        return view('livewire.competition.leauge-ics-file');
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
		//dd(date('H:i',$dt));

		$icalObject=	"BEGIN:VCALENDAR\nVERSION:2.0\nPRODID:-//ical.marudot.com//iCal Event Maker\nBEGIN:VEVENT\nDTSTART;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nDTEND;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nLOCATION:".$competition->location."\nTRANSP: OPAQUE\nSEQUENCE:0\nUID:\nDTSTAMP;TZID=".$timezone.":".date("Ymd\THis",$dt)."\nSUMMARY:".$competition->name."\nDESCRIPTION:".$competition->name."\nPRIORITY:1\nCLASS:PUBLIC\nBEGIN:VALARM\nTRIGGER:-PT10080M\nACTION:DISPLAY\nDESCRIPTION:Reminder\nEND:VALARM\nEND:VEVENT\nEND:VCALENDAR\n";

		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename="cal.ics"');
		$contents = $icalObject;
		$filename = $competition->name.'.ics';
		return response()->streamDownload(function () use ($contents) {
			echo $contents;
		}, $filename);
	}
}
