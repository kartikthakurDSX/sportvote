<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Match_fixture;
use App\Models\Competition;
use App\Models\Comp_member;

class MatchfixtureEditLocationtime extends Component
{
	public $match_fixture_id;
	public $fixture_date;
	public $fixture_location;
	public $fixture_venue;
	public $edit_location = false;

	 public function mount($match_fixture)
    {
        $this->match_fixture_id = $match_fixture;
    }
    public function render()
    {
		$match_fixture = Match_fixture::find($this->match_fixture_id);
		$competition = Competition::find($match_fixture->competition_id);
		$comp_admins = Comp_member::where('comp_id',$competition->id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->with('member')->pluck('member_id');
		$admins = $comp_admins->toArray();
        return view('livewire.matchfixture-edit-locationtime',compact('match_fixture','competition','admins'));
    }
	public function match_fixture($id)
	{
		$this->edit_location = true;
		$match_fixture = Match_fixture::find($id);
		$this->fixture_date = $match_fixture->fixture_date;
		$this->fixture_location = $match_fixture->location;
		$this->fixture_venue = $match_fixture->venue;
	}
	public function save_changes()
	{
		$match_fixture = Match_fixture::find($this->match_fixture_id);
		$match_fixture->fixture_date = $this->fixture_date;
		$match_fixture->location = $this->fixture_location;
		$match_fixture->venue = $this->fixture_venue;
		$match_fixture->save();

		$this->dispatch('closeModal');
		return redirect(route('match-fixture.show', $this->match_fixture_id));
	}
}
