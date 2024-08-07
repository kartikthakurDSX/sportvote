<?php

namespace App\Livewire\Competition;

use Livewire\Component;
use App\Livewire\Trix;
use App\Models\Comp_member;
use App\Models\Competition;
use App\Models\Comp_rule_set;
use App\Models\Notification;
use App\Models\Sponsor;
use App\Models\Youtube_video;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
class IncludeCompsidebar extends Component
{
    use WithFileUploads;
    use WithPagination;
    public $comp_id;
    public $body;
    public $is_save = 1;
    public $max_char;
    public $msg;
    public $adminstration;
    public $SponsorHeading;
    public $sponsor_name;
    public $sponsor_image = [];
    public $sponsor_id;
    public $sponsorname;
    public $sponsorimage;
    public $youtube_video;
    public $compvideo;
    public $video_title;
    public $video_description;
    public $video_link;
    public $video_id;
    public $youtubevideo;
    public $rule_desc;

    public function mount($competition)
    {
        $this->comp_id = $competition;
        $competition = Competition::find($this->comp_id);
        $this->body = $competition->description;
        $this->adminstration = $competition;
    }
    public function render()
    {
        $comp_admins = Comp_member::where('comp_id', $this->comp_id)->where('member_position_id', 7)->where('invitation_status', 1)->where('is_active', 1)->pluck('member_id');
        $admins = $comp_admins->toArray();
        $competition = Competition::find($this->comp_id);
        $this->dispatch('addadmin');
        $competition = $this->adminstration;
        $competition_member = Comp_member::where('comp_id', $competition->id)->where('member_position_id', 7)->whereIn('invitation_status', [0, 1])->with('member', 'member_position')->latest()->paginate(4);

        $comp_referee = Comp_member::where('comp_id', $competition->id)->where('member_position_id', 6)->whereIn('invitation_status', [0, 1])->with('member', 'member_position')->latest()->paginate(4);
        $comp_activeRefree = Comp_member::where('comp_id', $competition->id)->where('member_position_id', 6)->where('invitation_status', 1)->get();
        $comp_sponsers = Sponsor::where('module_type', 2)->where('type', 2)->where('type_id', $this->comp_id)->where('is_active', 1)->get();

        $comp_rules = Comp_rule_set::where('comp_id',$competition->id)->where('is_active',1)->get();
        $comp_rules_array = array();
        $x = 1;
        foreach ($comp_rules as $value)
        {
            $rule = $x.") ".$value->description;
            array_push($comp_rules_array, $rule);
            $x++;
        }
        $comp_rules_paragraph = implode('<br>', $comp_rules_array);
        $competition_video = Youtube_video::where('type', 2)->where('type_id', $this->comp_id)->where('is_active', 1)->orderBy('id', 'DESC')->get();
        $this->youtubevideo = $competition_video;
        $video = Youtube_video::where('type', 2)->where('type_id', $this->comp_id)->where('is_active', 1)->latest()->first();

        return view('livewire.competition.include-compsidebar', compact('competition', 'admins', 'competition_member', 'comp_referee','comp_activeRefree', 'comp_sponsers', 'competition_video', 'video','comp_rules','comp_rules_paragraph'));
    }
    public $listeners = [
        Trix::EVENT_VALUE_UPDATED // trix_value_updated()
    ];
    public function trix_value_updated($value)
    {
        if (strlen($value) < 500) {
            $this->body = $value;
            $this->is_save = 1;
            $this->max_char =   500 - strlen($value);
        } else {
            $this->is_save = 0;
            $this->max_char =   500 - strlen($value);
            $this->msg = "You can not use more than 500 characters.";
        }
    }

    public function edit_comp_desc()
    {
        $this->dispatch('OpendescModal');
    }
    public function closemodal()
    {
        $this->dispatch('ClosedescModal');
    }
    public function openaddcomprules()
    {
        $this->dispatch('OpenaddcomprulesModal');
    }
    public function closeaddcomprules()
    {
        $this->dispatch('CloseaddcomprulesModal');
    }

    public function save()
    {
        $edit_comp_desc = Competition::find($this->comp_id);
        $edit_comp_desc->description = $this->body;
        $edit_comp_desc->save();
        $this->dispatch('ClosedescModal');
    }
    public function cancel_request($id)
    {
        $comp_member = Comp_member::find($id);
        $comp_member->invitation_status = 3;
        $comp_member->save();
        $notification = Notification::where('notify_module_id',4)->where('type_id',$id)->where('reciver_id',$comp_member->member_id)->update(['is_active' => 0, 'is_seen' => 1]);

    }

    public function add_rule()
    {
        $this->validate([
            'rule_desc' => 'required',
        ]);
        $comp_admins = Comp_member::where('comp_id', $this->comp_id)->where('member_position_id', 7)->where('invitation_status', 1)->where('is_active', 1)->pluck('member_id');
        $admins = $comp_admins->toArray();
        $compData = Competition::find($this->comp_id);
        if(in_array(Auth::user()->id, $admins) || $compData->user_id == Auth::user()->id){
            if($this->rule_desc)
            {
                $add_rule = new Comp_rule_set();
                $add_rule->comp_id = $this->comp_id;
                $add_rule->user_id = Auth::user()->id;
                $add_rule->description = $this->rule_desc;
                $add_rule->save();
                if($add_rule){
                    return redirect(route('competition.show', $this->comp_id));
                }
            }

        }
    }
    public function delete_comp_rule($id)
    {
        $comp_admins = Comp_member::where('comp_id', $this->comp_id)->where('member_position_id', 7)->where('invitation_status', 1)->where('is_active', 1)->pluck('member_id');
        $admins = $comp_admins->toArray();
        $compData = Competition::find($this->comp_id);
        if(in_array(Auth::user()->id, $admins) || $compData->user_id == Auth::user()->id){
            $delet = Comp_rule_set::find($id)->delete();
        }
    }
    public function active_refree($id)
    {
        $comp_member = Comp_member::find($id);
        $comp_member->is_active = 1;
        $comp_member->save();
        $notification = Notification::where('notify_module_id',4)->where('type_id',$id)->where('reciver_id',$comp_member->member_id)->update(['is_active' => 0, 'is_seen' => 1]);
    }

    public function inactive_refree($id)
    {
        $comp_member = Comp_member::find($id);
        $comp_member->is_active = 3;
        $comp_member->save();
        $notification = Notification::where('notify_module_id',4)->where('type_id',$id)->where('reciver_id',$comp_member->member_id)->update(['is_active' => 0, 'is_seen' => 1]);
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
    public function close_addcomprules_model()
    {
        $this->dispatch('CloseaddcomprulesModal');
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
        $this->sponsorimage = $compsponsor->sponsor_image;
        $this->dispatch('OpeneditcommunitysponserModal');
        return redirect(route('competition.show', $this->comp_id));
    }
    public function close_editcommunity_sponsor()
    {
        $this->dispatch('CloseeditcommunitysponserModal');
    }
    public function add_communitysponsor_info()
    {
        $this->validate([
            'sponsor_image' => 'required',
            'sponsor_image.*' => 'mimes:jpeg,png,jpg',
        ]);
        foreach ($this->sponsor_image as $key => $image)
        {
            $this->sponsor_image[$key] = $image->store('image','public');
            $sponsor_image = $image->hashName();
            $sponsor = new Sponsor();
            $sponsor->user_id = Auth::user()->id;
            $sponsor->module_type = 2;
            $sponsor->type = 2;
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
        if ($this->sponsor_image != '') {
            $this->validate([
                'sponsor_image' => 'required',
                'sponsor_image.*' => 'mimes:jpeg,png,jpg',
            ]);
            $this->sponsor_image->store('image','public');
            $image = $this->sponsorimage->hashName();
        } else {
            $image = $this->sponsorimage;
        }
        $sponsor = Sponsor::find($this->sponsor_id);
        $sponsor->sponsor_image = $image;
        $sponsor->save();
        $this->dispatch('CloseeditcommunitysponserModal');
        return redirect(route('competition.show', $this->comp_id));
    }

    public function deletecommunity_sponsor($id)
    {
        Sponsor::find($id)->delete();
        return back();
    }
    protected function rules()
    {
        return [
            'video_link' => 'required'

        ];
    }
    protected $messages = [
        'video_link' =>  'Enter Video link',
        'sponsor_image.required' => 'Select image for Sponsor',
        'rule_desc.required' => 'Rule field is required.',
        'sponsor_image.*.mimes' => 'The sponsor image must be a file of type: jpeg, png, jpg.',
    ];
    public function addcomp_video()
    {
        $this->validate();
        $comp_video = new Youtube_video();
        $comp_video->type = 2;
        $comp_video->type_id = $this->comp_id;
        $comp_video->video_link = $this->video_link;
        $comp_video->save();
        $this->video_title = "";
        $this->video_description = "";
        $this->video_link = "";
        $this->dispatch('Closecompyoutube_videoModal');
        $this->dispatch('OpeneditvideoModal');
    }
    public function editcomp_video()
    {
        $compyoutube_video = Youtube_video::find($this->video_id);
        $compyoutube_video->video_link = $this->video_link;
        $compyoutube_video->save();
        if ($compyoutube_video) {
            $this->dispatch('Closeeditcompyoutube_videoModal');
        }
    }
    public function open_compyoutube_video()
    {
        $this->dispatch('CloseeditvideoModal');
        $this->dispatch('Opencompyoutube_videoModal');
    }
    public function close_compyoutube_video()
    {
        $this->dispatch('Closecompyoutube_videoModal');
    }
    public function open_edityoutube_video()
    {
        $this->dispatch('OpeneditvideoModal');
    }
    public function close_edityoutube_video()
    {
        $this->dispatch('CloseeditvideoModal');
    }
    public function open_editcompyoutube_video($id)
    {
        $this->video_id = $id;
        $compyoutube_video = Youtube_video::find($id);
        $this->video_link = $compyoutube_video->video_link;
        $this->dispatch('Openeditcompyoutube_videoModal');
    }
    public function close_editcompyoutube_video()
    {
        $this->dispatch('Closeeditcompyoutube_videoModal');
    }
    public function deletecomp_video($id)
    {
        $compvideo = Youtube_video::find($id)->delete();
        $this->dispatch('Closeeditcompyoutube_videoModal');
    }
}
