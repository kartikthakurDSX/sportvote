<?php

namespace App\Livewire\Competition;

use App\Models\Sponsor;
use App\Models\Comp_member;
use App\Models\Competition;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AddcommunitySponsor extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $competition;
    public $SponsorHeading;
    public $sponsor_name;
    public $sponsor_image = [];
    public $sponsor_id;
    public $sponsorname;
    public $sponsorimage;

    protected function rules()
    {

        return [
			'sponsor_image' => 'required',
            //'sponsor_image' => 'image|max:512|mimes:png,jpg,jpeg',
        ];

    }
    protected $messages = [
        'sponsor_image.required' => 'Select image for Sponsor',
    ];

    public function mount($competition, $SponsorHeading)
    {
        $this->comp_id = $competition;
        $this->SponsorHeading = $SponsorHeading;
    }
    public function render()
    {
		$comp_admins = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->pluck('member_id');
		$admins = $comp_admins->toArray();
		$comp = Competition::find($this->comp_id);
		$comp_sponsers = Sponsor::where('module_type',2)->where('type',2)->where('type_id',$this->comp_id)->where('is_active', 1)->get();
        return view('livewire.competition.addcommunity-sponsor',compact('admins','comp','comp_sponsers'));
    }

    public function add_communitysponsor_info()
    {
        // $this->validate();
        foreach ($this->sponsor_image as $key => $image) {

            $this->sponsor_image[$key] = $image->store('image','public');
            $sponsor_image = $image->hashName();
            $sponsor = new Sponsor();
            $sponsor->user_id = Auth::user()->id;
            $sponsor->module_type= 2;
            $sponsor->type= 2;
            $sponsor->type_id = $this->comp_id;
            $sponsor->sponsor_image = $sponsor_image;
            $sponsor->save();

        }
        $this->sponsor_image = "";
		$this->dispatch('CloseaddcommunitysponserModal');
		return redirect(route('competition.show', $this->comp_id));
    }

    public function editcommunity_sponsor()
    {
        if($this->sponsor_image != '')
        {
            $this->sponsor_image->store('image','public');
            $image = $this->sponsor_image->hashName();

        }else{
            $image = $this->sponsorimage;

        }
        $sponsor = Sponsor::find($this->sponsor_id);
        //$sponsor->sponsor_name = $this->sponsorname;
        $sponsor->sponsor_image = $image;
        $sponsor->save();
        $this->dispatch('CloseeditcommunitysponserModal');
		return redirect(route('competition.show', $this->comp_id));
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
        $compsponsor = Sponsor::find($id);
        //$this->sponsorname = $compsponsor->sponsor_name;
        $this->sponsorimage = $compsponsor->sponsor_image;
		$this->dispatch('OpeneditcommunitysponserModal');
		return redirect(route('competition.show', $this->comp_id));
	}
	public function close_editcommunity_sponsor()
	{
		$this->dispatch('CloseeditcommunitysponserModal');
	}

    public function deletecommunity_sponsor($id)
    {
        $compsponsor = Sponsor::find($id)->delete();
       return redirect(route('competition.show', $this->comp_id));
    }
}
