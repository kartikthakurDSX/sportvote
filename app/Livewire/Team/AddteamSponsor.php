<?php

namespace App\Livewire\Team;

use App\Models\Team;
use App\Models\Team_member;
use App\Models\Sponsor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use File;

class AddteamSponsor extends Component
{
    use WithFileUploads;
    public $team_id;
    public $sponsor_name;
    public $sponsor_image = [];
    public $sponsor_id;
    public $sponsorname;
    public $sponsorimage;
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

    protected function rules()
    {

        return [
            'sponsor_image' => 'required|image',
        ];

    }
    protected $messages = [
        'sponsor_image.required' => 'Select image for Sponsor',
        'sponsor_image.*.mimes' => 'The sponsor image must be a file of type: jpeg, png, jpg.',
        'sponsor_image.0.mimes' => 'The sponsor image must be a file of type: png, jpg, jpeg.',
    ];

    public function Mount($team)
    {
        $this->team_id = $team;
    }

    public function render()
    {

		$teamsponsers = Sponsor::where('module_type', 1)->where('type',1)->where('type_id',$this->team_id)->where('is_active', 1)->get();
		$team_admins = Team_member::where('team_id',$this->team_id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
		$admins = $team_admins->toArray();
		$team = Team::find($this->team_id);
        return view('livewire.team.addteam-sponsor', compact('teamsponsers','admins','team'));
    }

    public function add_sponsor_info()
    {
		$this->validate([
            'sponsor_image' => 'required',
            'sponsor_image.*' => 'image|mimes:jpeg,png,jpg',
        ]);
        foreach ($this->sponsor_image as $key => $image) {

            $this->sponsor_image[$key] = $image->store('image','public');
            // dd($this->sponsor_image[$key]);
            $sponsor_image = $image->hashName();
            $sponsor = new Sponsor();
            $sponsor->user_id = Auth::user()->id;
            $sponsor->module_type= 1;
            $sponsor->type= 1;
            $sponsor->type_id = $this->team_id;
            $sponsor->sponsor_image = $sponsor_image;
            $sponsor->save();

        }

        // $this->sponsor_image->store('image','public');
	    // $sponsor_image = $this->sponsor_image->hashName();
        // $sponsor = new Sponsor();
        // $sponsor->user_id = Auth::user()->id;
        // $sponsor->module_type= 1;
        // $sponsor->type= 1;
        // $sponsor->type_id = $this->team_id;
        // //$sponsor->sponsor_name = $this->sponsor_name;
        // $sponsor->sponsor_image = $sponsor_image;
        // $sponsor->save();
        if($sponsor)
        {
            //$this->sponsor_name = '';
            $this->reset('sponsor_image');
        }
		$this->dispatch('CloseaddsponserModal');
        $this->dispatch('OpeneditteamsponsorModal');

    }

    public function edit_sponsor()
    {
        if($this->sponsor_image != '')
        {
            $this->validate([
                'sponsor_image' => 'required',
                'sponsor_image.*' => 'image|mimes:jpeg,png,jpg',
            ]);
            $this->sponsor_image->store('image','public');
            $image = $this->sponsor_image->hashName();

        }else{

            $image = $this->sponsorimage;

        }
        Sponsor::where('id', $this->sponsor_id)
        ->update([
        //'sponsor_name' => $this->sponsorname,
        'sponsor_image' => $image,
        ]);
        $this->dispatch('CloseeditsponserModal');

    }

    public function open_add_sponsor()
	{
        $this->dispatch('CloseeditteamsponsorModal');
		$this->dispatch('OpenaddsponserModal');
	}
	public function close_add_sponsor()
	{
		$this->dispatch('CloseaddsponserModal');
		// return redirect(route('team.show', $this->team_id));
	}
    public function open_editteam_sponsor()
	{
		$this->dispatch('OpeneditteamsponsorModal');
	}
	public function close_editteam_sponsor()
	{
		$this->dispatch('CloseeditteamsponsorModal');
		//return redirect(route('team.show', $this->team_id));
	}
    public function open_edit_sponsor($id)
	{
        $this->sponsor_id = $id;
        $teamsponsor = Sponsor::find($id);
        //$this->sponsorname = $teamsponsor->sponsor_name;
        $this->sponsorimage = $teamsponsor->sponsor_image;
		$this->dispatch('OpeneditsponserModal');
	}
	public function close_edit_sponsor()
	{
		$this->dispatch('CloseeditsponserModal');
		//return redirect(route('team.show', $this->team_id));
	}

    public function deletecompetition_sponsor($id)
    {
        $teamsponsor = Sponsor::find($id);
        $teamsponsor->is_active = 0;
        $teamsponsor->save();
    }
}
