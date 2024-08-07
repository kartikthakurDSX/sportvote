<?php

namespace App\Livewire\Team;

use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\Team_member;
use App\Models\User;
use App\Models\Sponsor;
use App\Models\Member_position;
use App\Models\Youtube_video;
use App\Livewire\Trix;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class RightsideBar extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $team;
    public $admins;
    public $body;
    public $is_save = 1;
    public $max_char;
    public $msg;
    public $email;
    public $phone_number;
    public $address;
    public $team_owner;
    public $sponsor_image = [];
    public $youtubevideo;
    public $video_title;
    public $video_description;
    public $video_link;
    public $video_id;

    protected $messages = [
        'sponsor_image.required' => 'Select image for Sponsor',
        'sponsor_image.*.mimes' => 'The sponsor image must be a file of type: jpeg, png, jpg.',
    ];
    //  public $listeners = ['refreshData'];


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

    public function mount($id)
    {
        $this->team = Team::find($id);
        $team_admins = Team_member::where('team_id', $id)->where('member_position_id', 4)->where('invitation_status', 1)->pluck('member_id');
        $this->email = $this->team->team_email;
        $this->phone_number = $this->team->team_phone_number;
        $this->address = $this->team->team_address;
        $this->admins = $team_admins->toArray();
        $this->body = $this->team->description;

        $this->team_owner = User::find($this->team->user_id);
        $this->youtubevideo = Youtube_video::select('video_link', 'id')->where('type', 1)->where('type_id', $this->team->id)->where('is_active', 1)->get();
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
    public function save()
    {
        //dd($this->body);
        $edit_team_desc = Team::find($this->team->id);
        $edit_team_desc->description = $this->body;
        $edit_team_desc->save();
        $this->dispatch('ClosedescModal');
        // return redirect(route('team.show', $this->team->id));
    }
    public function edit_team_desc()
    {
        //$this->dispatch('ck_editor');
        $this->dispatch('OpendescModal');
    }

    public function closemodal()
    {
        $this->dispatch('ClosedescModal');
        // return redirect(route('team.show', $this->team->id));
    }

    //Adminstrator
    public function cancel_request($id)
    {
        $team_member = Team_member::find($id);
        $team_member->invitation_status = 3;
        $team_member->save();
    }
    public function add_communitysponsor_info()
    {
        $this->validate([
            'sponsor_image' => 'required',
            'sponsor_image.*' => 'image|mimes:jpeg,png,jpg',
        ]);

        foreach ($this->sponsor_image as $key => $image) {
            $this->sponsor_image[$key] = $image->store('image', 'public');
            $sponsor_image = $image->hashName();
            $sponsor = new Sponsor();
            $sponsor->user_id = Auth::user()->id;
            $sponsor->module_type = 2;
            $sponsor->type = 1;
            $sponsor->type_id = $this->team->id;
            $sponsor->sponsor_image = $sponsor_image;
            $sponsor->save();
        }
        $this->sponsor_name = "";
        $this->sponsor_image = "";
        $this->dispatch('CloseaddcommunitysponserModal');
        $this->dispatch('OpeneditcommunitysponsorModal');
    }

    //Community sponsor
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
    public function deletecommunity_sponsor($id)
    {
        $compsponsor = Sponsor::find($id);
        $compsponsor->is_active = 0;
        $compsponsor->save();
    }

    //youtube vedios
    public function addcomp_video()
    {
        // $this->validate();
        $comp_video = new Youtube_video();
        $comp_video->type = 1;
        $comp_video->type_id = $this->team->id;
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
        $this->video_title = $compyoutube_video->video_title;
        $this->video_description = $compyoutube_video->description;
        $this->video_link = $compyoutube_video->video_link;
        $this->dispatch('Openeditcompyoutube_videoModal');
    }

    public function close_editcompyoutube_video()
    {
        $this->dispatch('Closeeditcompyoutube_videoModal');
    }

    // public function deletecomp_video($id)
    // {
    //     $compvideo = Youtube_video::find($id)->delete();

    //     $this->dispatch('Closeeditcompyoutube_videoModal');
    // }
    public function deletecomp_video($id)
    {
        // Find the Youtube_video record with the given ID
        $compvideo = Youtube_video::find($id);

        // Check if the record exists
        if ($compvideo) {
            // If the record exists, delete it
            $compvideo->delete();
        } else {
            // If the record does not exist, handle the situation accordingly
            // For example, you could log an error or show a message to the user
            // Here, I'll just log a message to the Laravel log file
            \Log::error("Youtube_video with ID $id not found for deletion.");
        }

        // Dispatch browser event to close the modal
        $this->dispatch('Closeeditcompyoutube_videoModal');
    }


    public function render()
    {
        $admin_position_ids = Member_position::where('member_type', 2)->pluck('id');
        $team_member = Team_member::where('team_id', $this->team->id)->whereIn('member_position_id', $admin_position_ids)->with('member_position', 'members')->whereIn('invitation_status', [0, 1])->latest()->paginate(4);
        $com_sponsers = Sponsor::where('module_type', 2)->where('type', 1)->where('type_id', $this->team->id)->where('is_active', 1)->latest()->get();
        $com_sponsers_view = Sponsor::select('id', 'sponsor_image')->where('module_type', 2)->where('type', 1)->where('type_id', $this->team->id)->where('is_active', 1)->latest()->get();
        $video = Youtube_video::where('type', 1)->where('type_id', $this->team->id)->where('is_active', 1)->latest()->first();

        return view('livewire.team.rightside-bar', compact('team_member', 'com_sponsers', 'com_sponsers_view', 'video'));
    }
}
