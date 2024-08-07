<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Competition;
use App\Models\Comp_member;
use App\Models\Comp_rule_set;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class CreateCompetition extends Component
{
    use WithFileUploads;

    public $competition_member;
	public $game_id;
    public $logo;
	public $bannerpreview;

    // form variable

    public $comp_id = "";
	public $comp_info;
    public $comp_name;
    public $comp_logo;


    public $referee_id = [];
	public $banner;

    public $is_add_rule;
    public $rule_desc;
    public $comp_rules;
    public $compet_id;
    public $compe_id = "";
    public $listeners = ['refreshData'];


	public function refresh()
    {
		$this->dispatch('$refresh');
    }
    public function refreshData()
    {
        $this->dispatch('refreshDataComplete'); // Optional: Emit an event to signal that data refresh is complete
    }

    public function render()
    {
        $compe_id = session('createComp_id');
        if($compe_id){
            $this->comp_id = $compe_id;
        }
        $this->competition_member = Comp_member::where('comp_id', $this->comp_id)->get();
        $this->comp_rules = Comp_rule_set::where('comp_id',$this->comp_id)->where('is_active',1)->get();
		if($this->comp_id != "")
		{
			$competition = Competition::find($this->comp_id);
			$competition_logo = $competition->comp_logo;
            $this->is_add_rule = 1;
		}
		else
		{
			$competition_logo = "competitions-icon-128.png";
            $this->is_add_rule = 0;
		}

        return view('livewire.create-competition',compact('competition_logo'));
    }
    protected $messages = [
        'rule_desc.required' => 'Rule field is required.',
    ];

	public function add_rule()
    {
        // dd($this->rule_desc);
        $this->validate([
            'rule_desc' => 'required',
        ]);
        if($this->is_add_rule == 1){
            if($this->rule_desc)
            {
                $add_rule = new Comp_rule_set();
                $add_rule->comp_id = $this->comp_id;
                $add_rule->user_id = Auth::user()->id;
                $add_rule->description = $this->rule_desc;
                $add_rule->save();
                $this->rule_desc = "";
            }
        }
    }
    public function delete_comp_rule($id)
    {
        $delet = Comp_rule_set::find($id)->delete();
        $this->comp_rules = Comp_rule_set::where('comp_id',$this->comp_id)->where('is_active',1)->get();
    }

}
