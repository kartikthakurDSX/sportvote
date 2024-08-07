<?php

namespace App\Livewire\Team;
use App\Models\Sponsor;
use App\Models\Team_member;
use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class CommunitySponsor extends Component
{
    use WithPagination;
	use WithFileUploads;

    public $sponsor_name;
    public $sponsor_image = [];
    public $sponsor_id;
    public $sponsorname;
    public $sponsorimage;
	public $team_id;


    protected function rules()
    {

        return [
            'sponsor_image' => 'image|max:512|mimes:png,jpg,jpeg',
        ];

    }
    protected $messages = [
        'sponsor_image.required' => 'Select image for Sponsor',
    ];
	public function mount($team)
	{
		$this->team_id = $team;
	}
    public function render()
    {
		$com_sponsers = Sponsor::where('module_type',2)->where('type', 1)->where('type_id',$this->team_id)->where('is_active', 1)->latest()->get();
		$com_sponsers_view = Sponsor::select('id','sponsor_image')->where('module_type',2)->where('type', 1)->where('type_id',$this->team_id)->where('is_active', 1)->latest()->get();
		$team_admins = Team_member::where('team_id', $this->team_id)->where('member_position_id',4)->where('invitation_status',1)->pluck('member_id');
		$admins = $team_admins->toArray();
		$team = Team::find($this->team_id);
        return view('livewire.team.community-sponsor', compact('com_sponsers','admins','team','com_sponsers_view'));
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
            $sponsor->type= 1;
            $sponsor->type_id = $this->team_id;
            $sponsor->sponsor_image = $sponsor_image;
            $sponsor->save();

        }
        // $this->sponsor_image->store('image','public');
	    // $sponsor_image = $this->sponsor_image->hashName();
        // $sponsor = Sponsor::create([
        // 'user_id' => Auth::user()->id,
        // 'module_type' => 2,
        // 'type'=> 1,
		// 'type_id' => $this->team_id,
        // //'sponsor_name' => $this->sponsor_name,
        // 'sponsor_image' => $sponsor_image,
        // ]);
        $this->sponsor_name = "";
        $this->sponsor_image = "";
		$this->dispatch('CloseaddcommunitysponserModal');
        $this->dispatch('OpeneditcommunitysponsorModal');
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
	}
	public function close_editcommunity_sponsor()
	{
		$this->dispatch('CloseeditcommunitysponserModal');
	}

    public function deletecommunity_sponsor($id)
    {
        $compsponsor = Sponsor::find($id);
        $compsponsor->is_active = 0;
        $compsponsor->save();
    }










}
