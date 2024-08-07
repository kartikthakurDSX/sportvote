<?php

namespace App\Livewire\Team;

use App\Models\Sponsor;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class AddcommunitySponsor extends Component
{

    use WithFileUploads;
    use WithPagination;
    public $team_id;
    public $sponsor_name;
    public $sponsor_image;
    public $sponsor_id;
    public $sponsorname;
    public $sponsorimage;

    protected function rules()
    {

        return [
            'sponsor_name' => 'required|string|max:50',
            'sponsor_image' => 'image|max:512|mimes:png,jpg,jpeg',
        ];

    }
    protected $messages = [
        'sponsor_name.required' => 'The Sponsor Name cannot be empty.',
        'sponsor_image.required' => 'Select image for Sponsor',
        'sponsor_image.*.mimes' => 'The sponsor image must be a file of type: jpeg, png, jpg.',

    ];
    public function Mount($team)
    {
        $this->team_id = $team;
    }

    public function render()
    {
		$com_sponsers = Sponsor::where('type_id', $this->team_id)->where('type', 2)->where('is_active', 1)->paginate(6);
        return view('livewire.team.addcommunity-sponsor', compact('com_sponsers'));
    }

    public function add_communitysponsor_info()
    {
        $this->validate([
            'sponsor_image' => 'required',
            'sponsor_image.*' => 'mimes:jpeg,png,jpg',
        ]);
        $this->sponsor_image->store('image','public');
	    $sponsor_image = $this->sponsor_image->hashName();
        $sponsor =new Sponsor();
        $sponsor->user_id = Auth::user()->id;
        $sponsor->type = 2;
        $sponsor->type_id = $this->team_id;
        $sponsor->sponsor_name = $this->sponsor_name;
        $sponsor->sponsor_image = $sponsor_image;
        $sponsor->save();
        $this->sponsor_name = "";
        $this->sponsor_image = "";
		$this->dispatch('CloseaddcommunitysponserModal');
        $this->dispatch('OpeneditcommunitysponsorModal');
    }

    public function editcommunity_sponsor()
    {
        if($this->sponsor_image != '')
        {
            $this->validate([
                'sponsor_image' => 'required',
                'sponsor_image.*' => 'mimes:jpeg,png,jpg',
            ]);
            $this->sponsor_image->store('image','public');
            $image = $this->sponsor_image->hashName();

        }else{
            $image = $this->sponsorimage;

        }
        $sponsor = Sponsor::find($this->sponsor_id);
        $sponsor->sponsor_name = $this->sponsorname;
        $sponsor->sponsor_image = $image;
        $sponsor->save();
        $this->dispatch('CloseeditcommunitysponserModal');
    }

    public function open_addcommunity_sponsor()
	{
        $this->dispatch('CloseeditcommunitysponsorModal');
		$this->dispatch('OpenaddcommunitysponserModal');
	}

	public function close_addcommunity_sponsor()
	{
		$this->dispatch('CloseaddcommunitysponserModal');
	}

    public function open_edit_sponsor()
	{
		$this->dispatch('OpeneditcommunitysponsorModal');
	}

	public function close_edit_sponsor()
	{
		$this->dispatch('CloseeditcommunitysponsorModal');
	}

    public function open_editcommunity_sponsor($id)
	{
        $this->sponsor_id = $id;
        $compsponsor = Sponsor::where('id', $id)->first();
        $this->sponsorname = $compsponsor->sponsor_name;
        $this->sponsorimage = $compsponsor->sponsor_image;
		$this->dispatch('OpeneditcommunitysponserModal');
	}
	public function close_editcommunity_sponsor()
	{
		$this->dispatch('CloseeditcommunitysponserModal');
	}

    public function deletecommunity_sponsor($id)
    {
        $compsponsor = Sponsor::where('id', $id)->first();
        $compsponsor->is_active = 0;
        $compsponsor->save();
    }
}
