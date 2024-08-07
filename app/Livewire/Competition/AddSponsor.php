<?php

namespace App\Livewire\Competition;

use App\Models\Sponsor;
use App\Models\Comp_member;
use App\Models\Competition;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddSponsor extends Component
{
    use WithFileUploads;

    public $comp_id;
    public $sponsor_name;
    public $sponsor_image = [];
    public $sponsor_id;
    public $sponsorname;
    public $sponsorimage;

    protected function rules()
    {

        return [
			'sponsor_image' => 'required',
            // 'sponsor_image' => 'image|max:512|mimes:png,jpg,jpeg',
        ];

    }
    protected $messages = [
        'sponsor_image.required' => 'Select image for Sponsor',
        'sponsor_image.*.mimes' => 'The sponsor image must be a file of type: jpeg, png, jpg.',
    ];

    public function mount($competition)
    {
        $this->comp_id = $competition;
    }
    public function render()
    {
		// $comp_admins = Comp_member::where('comp_id',$this->comp_id)->where('member_position_id',7)->where('invitation_status',1)->where('is_active', 1)->pluck('member_id');
		// $admins = $comp_admins->toArray();
		// $competition = Competition::find($this->comp_id);
		// $comp_sponsers = Sponsor::where('module_type',1)->where('type',2)->where('type_id',$this->comp_id)->where('is_active', 1)->get();
        // return view('livewire.competition.add-sponsor',compact('admins','competition','comp_sponsers'));

        $comp_admins = Comp_member::where('comp_id', $this->comp_id)
            ->where('member_position_id', 7)
            ->where('invitation_status', 1)
            ->where('is_active', 1)
            ->pluck('member_id')
            ->toArray();

        $admins = $comp_admins; // Define $admins variable

        $competition = Competition::find($this->comp_id);

        $comp_sponsers = Sponsor::where('module_type', 1)
            ->where('type', 2)
            ->where('type_id', $this->comp_id)
            ->where('is_active', 1)
            ->get();

        return view('livewire.competition.add-sponsor', compact('admins', 'competition', 'comp_sponsers'));


    }

    public function add_sponsor_info()
    {
		$this->validate([
            'sponsor_image' => 'required',
            'sponsor_image.*' => 'image|mimes:jpeg,png,jpg',
        ]);

        foreach ($this->sponsor_image as $key => $image) {

            $this->sponsor_image[$key] = $image->store('image','public');
            $sponsor_image = $image->hashName();
            $sponsor = new Sponsor();
            $sponsor->user_id = Auth::user()->id;
            $sponsor->module_type= 1;
            $sponsor->type= 2;
            $sponsor->type_id = $this->comp_id;
            $sponsor->sponsor_image = $sponsor_image;
            $sponsor->save();

        }
        if($sponsor)
        {
            $this->sponsor_name = '';
            $this->reset('sponsor_image');
        }
		$this->dispatch('CloseaddsponserModal');
        $this->dispatch('OpeneditcompponsorModal');
		return redirect(route('competition.show', $this->comp_id));
    }

    public function edit_sponsor()
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
        Sponsor::where('id', $this->sponsor_id)
        ->update([
        //'sponsor_name' => $this->sponsorname,
        'sponsor_image' => $image
        ]);
        $this->dispatch('CloseeditsponserModal');
		return redirect(route('competition.show', $this->comp_id));

    }

    public function open_add_sponsor()
	{
        $this->dispatch('CloseeditcompponsorModal');
		$this->dispatch('OpenaddsponserModal');
	}
	public function close_add_sponsor()
	{
		$this->dispatch('CloseaddsponserModal');
		return redirect(route('competition.show', $this->comp_id));
	}
    public function open_editteam_sponsor()
	{
		$this->dispatch('OpeneditcompponsorModal');
	}
	public function close_editteam_sponsor()
	{
		$this->dispatch('CloseeditcompponsorModal');
		//return redirect(route('competition.show', $this->comp_id));
	}
    public function open_edit_sponsor($id)
	{
        $this->sponsor_id = $id;
        $compsponsor = Sponsor::find($id);
        //$this->sponsorname = $compsponsor->sponsor_name;
        $this->sponsorimage = $compsponsor->sponsor_image;
		$this->dispatch('OpeneditsponserModal');
	}
	public function close_edit_sponsor()
	{
		$this->dispatch('CloseeditsponserModal');
		//return redirect(route('competition.show', $this->comp_id));
	}

    public function deletecompetition_sponsor($id)
    {
        $compsponsor = Sponsor::find($id);
        $compsponsor->is_active = 0;
        $compsponsor->save();
		return redirect(route('competition.show', $this->comp_id));
    }
}
