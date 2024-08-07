<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\hasRole;
use App\Models\User;
use App\Models\Country;
use App\Models\Competition;
use App\Models\Competition_attendee;
use App\Models\Competition_team_request;
use App\Models\Match_fixture;
use App\Models\Notification;
use App\Models\StatDecisionMaker;
use App\Models\StatTrack;
use App\Models\Team;
use App\Models\Team_member;
use App\Models\User_profile;
use App\Models\user_sport_cerification;
use App\Models\user_sport_membership;
use Illuminate\Support\Facades\Hash;


class BulkUploadController extends Controller
{
    //
    public function comp_bulk()
    {
        if(Auth::check())
        {
            // if(Auth::user()->hasRole('superadmin')  == 'superadmin')
            if(Auth::user())
            {
                $users = User::where('first_name', '!=', NULL)->get();
                $competitions = Competition::where('comp_type_id', '!=', Null)->orderBy('id','DESC')->where('is_active', 1)->get();
                return view('backend.bulks.comp_bulk',compact('users','competitions'));
            }
            else
            {
                return redirect('admin-panel');
            }
        }
        else
        {
            return redirect('admin-panel');
        }

    }

    public function comp_import(Request $request)
    {
        $is_active = 1;
        $admin_id = $request->admin_id;
        $filetype = $_FILES["import"]['name'];

        $allowed = array('csv', "CSV");
        $ext = pathinfo($filetype, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return back()->with('error', 'Wrong file type is uploaded. Please upload only csv file');
        }

        $filename = $_FILES["import"]['tmp_name'];

        if ($_FILES['import']['size'] > 0) {
            $file = fopen($filename, "r");

            // $headers = fgetcsv($file, 1000, ",");
            $rowcount = 0;
            while (($getdata = fgetcsv($file, 10000000, ",")) !== FALSE) {
                if (max(array_keys($getdata)) > 14 || max(array_keys($getdata)) < 14)
                {
                    return back()->with('error', 'Wrong file data is uploaded. Please upload valid csv file');
                }
                if($getdata[0] == null && $getdata[1] == null && $getdata[2] == null && $getdata[3] == null && $getdata[4] == null && $getdata[5] == null && $getdata[6] == null && $getdata[7] == null
                && $getdata[8] == null && $getdata[9] == null && $getdata[10] == null && $getdata[11] == null && $getdata[12] == null && $getdata[13] == null && $getdata[14] == null && $getdata[15] == null){
                    continue;
                }else{
                    $rowcount++;
                }
            }
            if($rowcount > 2)
            {}else{
                return back()->with('error', 'The uploaded file is empty. Please upload file with valid data.');
            }

            $files = fopen($filename, "r");
            $row = 0;
            $x = 0;
            $comp_squad_player_num = 0;
            $competitionData = array();
            while (($getData = fgetcsv($files, 10000000, ",")) !== FALSE)
            {
                $row++;
                if ($row == 1) continue;
                if ($row == 2) continue;

                if($getData[0] == null && $getData[1] == null && $getData[2] == null && $getData[3] == null && $getData[4] == null && $getData[5] == null && $getData[6] == null && $getData[7] == null
                && $getData[8] == null && $getData[9] == null && $getData[10] == null && $getData[11] == null && $getData[12] == null && $getData[13] == null && $getData[14] == null){
                    continue;
                }

                if($getData[13] == null && $getData[14] == null)
                {
                    $sportid = $getData[0];
                    $sportid_array = ['1', '2', '3', '4', '5', '6'];
                    if(in_array($sportid, $sportid_array))
                    {
                        if(intval($sportid) != 1){
                            $x++;
                        }
                    }else{
                        $x++;
                    }

                    $comp_type_id = $getData[1];
                    $comp_type_array = ['1', '2', '3'];
                    if(in_array($comp_type_id, $comp_type_array))
                    {
                        $comp_type = intval($comp_type_id);
                    }else
                    {
                        $x++;
                        $comp_type = "";
                    }

                    $comp_subtype_id = $getData[2];
                    $comp_subtype_array = ['1', '2', '3', '4', '5', '6'];
                    if(in_array($comp_subtype_id, $comp_subtype_array))
                    {
                        $compSub_type = intval($comp_subtype_id);
                    }else{
                        $x++;
                        $compSub_type = "";
                    }

                    $name = $getData[3];
                    $name_strlength = strlen($name);
                    if($name_strlength > 30 || $name_strlength == 0){
                        $x++;
                    }

                    $description = $getData[4];
                    $desc_strlength = strlen($description);
                    if($desc_strlength > 255){
                        $x++;
                    }

                    $halftime_array = ['1', '2', '5', '10', '15', '20', '25', '30', '35', '40', '45'];
                    $competition_half_time = $getData[5];
                    if(in_array($competition_half_time, $halftime_array))
                    {}else{
                        $x++;
                    }

                    $location = $getData[6];
                    $location_strlength = strlen($location);
                    if($location_strlength == 0 || $location_strlength > 50){
                        $x++;
                    }

                    if (!empty($getData[7]))
                    {
                        $value = explode('/', $getData[7]);
                        $date = $value[0]." ".$value[1];
                    }else {
                        $nowDate = now();
                        $strtotimeDate = strtotime($nowDate);
                        $date = date('Y-m-d h:i:s', $strtotimeDate);
                    }

                    $start_datetime = $date;
                    $dateFormat = 'Y-m-d H:i:s';

                    $cal_time = strtotime($start_datetime);
                    $testDate = date($dateFormat, $cal_time);
                    if($start_datetime != $testDate)
                    {
                        $x++;
                    }

                    // return $comp_type;
                    $team_number = $getData[8];
                    if($team_number != ""){
                        if(is_numeric(intval($team_number)) == false){
                            $x++;
                        }else{
                            if(intval($team_number) == 0)
                            {
                                $x++;
                            }else{
                                if($compSub_type > 0){
                                    if($compSub_type == 1 && $comp_type = 1){
                                        if(intval($team_number) == 2)
                                        {}else{
                                            $x++;
                                        }
                                    }else if($compSub_type == 2 && $comp_type = 2)
                                    {   if(intval($team_number) == 3 || intval($team_number) == 4)
                                        {
                                        }else{
                                            $x++;
                                        }
                                    }else if($compSub_type == 3 && $comp_type = 2)
                                    {   if(intval($team_number) >= 5 || intval($team_number) <= 32)
                                        {}else{
                                            $x++;
                                        }
                                    }else {
                                        if($comp_type = 3){
                                            if($compSub_type == 4 || $compSub_type == 5 || $compSub_type == 6)
                                            {   if(intval($team_number) >= 3 || intval($team_number) <= 32)
                                                {}else{
                                                    $x++;
                                                }
                                            }else{
                                                $x++;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }else{
                        $x++;
                    }

                    $squad_player_num = $getData[9];
                    if($squad_player_num != ""){
                        if(is_numeric(intval($squad_player_num)) == false)
                        {
                            $x++;
                        }else{
                            if(intval($squad_player_num) == 0){
                                $x++;
                            }else{
                                $comp_squad_player_num = $squad_player_num;
                            }
                        }
                    }else{
                        $x++;
                    }

                    $lineup_player_num = $getData[10];
                    if($lineup_player_num != ""){
                        if(is_numeric(intval($lineup_player_num)) == false)
                        {
                            $x++;
                        }else{
                            if(intval($lineup_player_num) == 0){
                                $x++;
                            }
                            if(intval($lineup_player_num) > intval($squad_player_num)){
                                $x++;
                            }
                        }
                    }else{
                        $x++;
                    }

                    $report_type = $getData[11];
                    $report_type_array = ['1', '2'];
                    if(in_array($report_type, $report_type_array))
                    {}else{
                        $x++;
                    }

                    $vote_time_array = ['2', '4', '5', '10', '15', '20', '25', '30'];
                    $vote_mins = $getData[12];
                    if(in_array($vote_mins, $vote_time_array))
                    {}else{
                        $x++;
                    }
                    $competition = array([
                        'user_id' => $admin_id,
                        'sport_id' => $getData[0],
                        'comp_type_id' => $getData[1],
                        'comp_subtype_id' => $getData[2],
                        'name' => $getData[3],
                        'description' => $getData[4],
                        'competition_half_time' => $getData[5],
                        'location' => $getData[6],
                        'start_datetime' => $date,
                        'team_number' => $getData[8],
                        'squad_players_num' => $getData[9],
                        'lineup_players_num' => $getData[10],
                        'report_type' => $getData[11],
                        'vote_mins' => $getData[12],
                        'is_active' => $is_active,
                    ]);
                }else{
                    $competition = "";
                }

                if($getData[0] == null && $getData[1] == null && $getData[2] == null && $getData[3] == null && $getData[4] == null && $getData[5] == null && $getData[6] == null && $getData[7] == null
                && $getData[8] == null && $getData[9] == null && $getData[10] == null && $getData[11] == null && $getData[12] == null )
                {
                    $teamPlayer_ids = $getData[13];
                    if($teamPlayer_ids != ""){
                        $participateTeams = array();
                        $teamPlayer_ids_array = explode(';', str_replace(array("\n", " "), '', $teamPlayer_ids));
                        foreach ($teamPlayer_ids_array as $value) {
                            $ids_explode = explode('(', $value);
                            $team_id = $ids_explode[0];
                            $teamData = Team::find($team_id);
                            if($teamData)
                            {
                                if(!in_array($team_id, $participateTeams, true)){
                                    array_push($participateTeams, $team_id);
                                }
                                $players_ids = str_replace(')', '', $ids_explode[1]);
                                $players_ids_array = explode(',', $players_ids);
                                if(count($players_ids_array) == intval($comp_squad_player_num)){
                                    foreach ($players_ids_array as $vals) {
                                        $team_members = Team_member::where('team_id', $team_id)->whereIn('member_position_id', [1,2,3,8])->where('invitation_status',1)->where('is_active',1)->pluck('member_id');
                                        $team_players_ids = $team_members->toArray();
                                        if(in_array($vals, $team_players_ids))
                                        {}else{
                                            $x++;
                                        }
                                    }
                                }
                            }else{
                                $x++;
                            }
                        }
                    }else{
                        $teamPlayer_ids_array = "";
                    }

                    $fixturesData = $getData[14];
                    if($fixturesData != ""){
                        $compFixturesData = explode(',', str_replace("\n", '', $fixturesData));
                        foreach ($compFixturesData as $fixturesTeamData)
                        {
                            $roundFixturesData = explode('(' , $fixturesTeamData);
                            $fixturesDate = explode(' ; ', str_replace(')', '', $roundFixturesData[1]));
                            $fixtureTeamsIds = explode(' VS ', $fixturesDate[0]);
                            if(!in_array($fixtureTeamsIds[0], $participateTeams, true)){
                                $x++;
                            }
                            if(!in_array($fixtureTeamsIds[1], $participateTeams, true)){
                                $x++;
                            }
                        }
                    }else{
                        $compFixturesData = "";
                    }
                    // return $compFixturesData;
                    if($x > 0){
                        return back()->with('error', 'Wrong data format is uploaded. Please check row number '.$row.' in the uploaded file.' );
                    }

                    $assignTeamFixture = array([
                        'teamPlayerIds' => $teamPlayer_ids_array,
                        'fixturesData' => $compFixturesData,
                    ]);

                }else{
                    $assignTeamFixture = "";
                }
                $competition_data = array("competition" => $competition, "assignTeamFixture" => $assignTeamFixture);
                array_push($competitionData, $competition_data);
            }
                // return $competitionData;
                // return $x;
            if($x > 0){
                return back()->with('error', 'Wrong data format is uploaded. Please check row number '.$row.' in the uploaded file.' );
            }
            if($x == 0){
                for ($row = 0; $row < sizeof($competitionData); $row++) {
                    if($competitionData[$row]['competition'] != ""){
                        $compData = $competitionData[$row]['competition'];
                        $comp = Competition::create($compData[0]);
                        if($comp['comp_type_id'] == 1)
                        {}else{
                        $stat_ids = "1,2,3,5,47";
                        $stat_tracking = new StatTrack();
                        $stat_tracking->tracking_type = 1;
                        $stat_tracking->tracking_for = $comp->id;
                        $stat_tracking->stat_type = 1;
                        $stat_tracking->stat_ids = $stat_ids;
                        $stat_tracking->is_active = 1;
                        $stat_tracking->save();

                        $stat_decision_makers = new StatDecisionMaker();
                        $stat_decision_makers->decision_stat_for = 1;
                        $stat_decision_makers->type_id = $comp->id;
                        $stat_decision_makers->stat_type = 1;
                        $stat_decision_makers->stat_id = 10;
                        $stat_decision_makers->stat_order = 1;
                        $stat_decision_makers->save();
                        }
                    }
                    if($competitionData[$row]['assignTeamFixture'] != "")
                    {
                        $competitionFixtureData = $competitionData[$row]['assignTeamFixture'];
                        // return $competitionFixtureData[0];
                        $comp_participate_teams = $competitionFixtureData[0]['teamPlayerIds'];
                        if($comp_participate_teams != ""){
                            foreach ($comp_participate_teams as $v) {
                                $teamIds_array = explode('(', $v);
                                $teamId = $teamIds_array[0];
                                $teamdata = Team::find($teamId);
                                if($teamdata)
                                {
                                    $comp_team_request = new Competition_team_request();
                                    $comp_team_request->competition_id = $comp->id;
                                    $comp_team_request->team_id = $teamId;
                                    $comp_team_request->user_id = $teamdata->user_id;
                                    $comp_team_request->request_status = 1;
                                    $comp_team_request->save();
                                }
                                $player_ids = str_replace(')', '', $teamIds_array[1]);
                                $player_ids_array = explode(',', $player_ids);
                                foreach ($player_ids_array as $val) {
                                    $comp_attendee = new Competition_attendee();
                                    $comp_attendee->Competition_id = $comp->id;
                                    $comp_attendee->team_id = $teamId;
                                    $comp_attendee->attendee_id = $val;
                                    $comp_attendee->save();
                                }
                            }

                            if($competitionFixtureData[0]['fixturesData'] != "")
                            {
                                $createFixturesData = $competitionFixtureData[0]['fixturesData'];
                                // return $createFixturesData;
                                foreach ($createFixturesData as $fixture)
                                {
                                    $roundFixtureData = explode('(' ,$fixture);
                                    $compFixtureRound = $roundFixtureData[0];
                                    $fixtureDate = explode(' ; ', str_replace(')', '', $roundFixtureData[1]));
                                    $fixtureTeamIds = explode(' VS ', $fixtureDate[0]);
                                    $match_fixture = new Match_fixture();
                                    $match_fixture->competition_id = $comp->id;
                                    $match_fixture->teamOne_id = $fixtureTeamIds[0];
                                    $match_fixture->teamTwo_id = $fixtureTeamIds[1];
                                    $match_fixture->fixture_date = $fixtureDate[1];
                                    $match_fixture->fixture_type = 0;
                                    $match_fixture->fixture_round = $compFixtureRound;
                                    $match_fixture->refree_id = 1;
                                    $match_fixture->venue = "comp";
                                    $match_fixture->location = $comp->location;
                                    $match_fixture->save();
                                }
                            }
                        }
                    }
                }
                fclose($file);
                return back()->with('success', 'Competitions imported successfully!');
            }

        }else{
            return back()->with('error', 'The uploaded file is empty. Please upload file with valid data.');
        }
    }

    public function dwnldCompFile()
    {
        $myFile = public_path("comp.csv");
        $headers = ['Content-Type: text/csv'];
        $newName = 'Competition' . time() . '.csv';

        return response()->download($myFile, $newName, $headers);
    }
    public function dwnldTeamCsvFile()
    {
        $myFile = public_path("team.csv");
        $headers = ['Content-Type: text/csv'];
        $newName = 'Team' . time() . '.csv';
        return response()->download($myFile, $newName, $headers);
    }

    public function team_bulk()
    {
        if(Auth::check())
        {
            // if(Auth::user()->hasRole('superadmin')  == 'superadmin')
            if(Auth::user())
            {
                $users = User::get();
                $teams = Team::where('is_active', 1)->orderBy('id','DESC')->get();
                return view('backend.bulks.team_bulk',compact('users','teams'));
            }
            else
            {
                return redirect('admin-panel');
            }
        }
        else
        {
            return redirect('admin-panel');
        }

    }

    public function team_import()
    {

        // $this->validate($request, array(
        //     'file'   => 'max:10240|required|mimes:csv,xlsx',
        // ));

        $filetype = $_FILES["import"]['name'];

        $allowed = array('csv', "CSV");
        $ext = pathinfo($filetype, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return back()->with('error', 'Wrong file type is uploaded. Please upload only csv file');
        }

        $filename = $_FILES["import"]['tmp_name'];

        if ($_FILES['import']['size'] > 0) {
            $file = fopen($filename, "r");

            // $headers = fgetcsv($file, 1000, ",");
            $rowcount = 0;
            while (($getdata = fgetcsv($file, 10000000, ",")) !== FALSE) {
                if (max(array_keys($getdata)) > 22 || max(array_keys($getdata)) < 22)
                {
                    return back()->with('error', 'Wrong file is uploaded. Please upload valid csv file');
                }

                if($getdata[0] == null && $getdata[1] == null && $getdata[2] == null && $getdata[3] == null && $getdata[4] == null && $getdata[5] == null && $getdata[6] == null && $getdata[7] == null
                    && $getdata[8] == null && $getdata[9] == null && $getdata[10] == null && $getdata[11] == null && $getdata[12] == null && $getdata[13] == null && $getdata[14] == null
                    && $getdata[15] == null && $getdata[16] == null && $getdata[17] == null && $getdata[18] == null && $getdata[19] == null && $getdata[20] == null && $getdata[21] == null && $getdata[22] == null){
                    continue;
                }else{
                    $rowcount++;
                }
            }
            if($rowcount > 2)
            {}else{
                return back()->with('error', 'The uploaded file is empty. Please upload file with valid data.');
            }

            $files = fopen($filename, "r");
            $row = 0;
            $x = 0;

            $createTeamsData = array();
            while (($getData = fgetcsv($files, 10000000, ",")) !== FALSE) {
                $row++;

                if ($row == 1) continue;
                if ($row == 2) continue;
                if($getData[0] == null && $getData[1] == null && $getData[2] == null && $getData[3] == null && $getData[4] == null && $getData[5] == null && $getData[6] == null && $getData[7] == null
                    && $getData[8] == null && $getData[9] == null && $getData[10] == null && $getData[11] == null && $getData[12] == null && $getData[13] == null && $getData[14] == null
                    && $getData[15] == null && $getData[16] == null && $getData[17] == null && $getData[18] == null && $getData[19] == null && $getData[20] == null && $getData[21] == null && $getData[22] == null){
                    continue;
                }
                else{
                    if($getData[0] != null && $getData[1] != null && $getData[2] != null && $getData[3] != null && $getData[4] != null && $getData[5] != null && $getData[6] != null
                        && $getData[7] == null && $getData[8] == null && $getData[9] == null && $getData[10] == null && $getData[11] == null && $getData[12] == null && $getData[13] == null && $getData[14] == null
                        && $getData[15] == null && $getData[16] == null && $getData[17] == null && $getData[18] == null && $getData[19] == null && $getData[20] == null && $getData[21] == null && $getData[22] == null)
                        {
                        $sportid = $getData[0];
                        $sportid_array = ['1', '2', '3', '4', '5', '6'];
                        if(in_array($sportid, $sportid_array))
                        {
                            if(intval($sportid) != 1){
                                $x++;
                            }
                        }else{
                            $x++;
                        }

                        $name = $getData[1];
                        $name_strlength = strlen($name);
                        if($name_strlength == 0 || $name_strlength > 30){
                            $x++;
                        }

                        $location = $getData[2];
                        if(strlen($location) == 0 || strlen($location) > 50){
                            $x++;
                        }

                        $homeGround = $getData[3];
                        $homeGround_strlength = strlen($homeGround);
                        if($homeGround_strlength == 0 || $homeGround_strlength > 30){
                            $x++;
                        }

                        $homeGround_location = $getData[4];
                        $homeGround_location_strlength = strlen($homeGround_location);
                        if($homeGround_location_strlength == 0 || $homeGround_location_strlength > 50){
                            $x++;
                        }

                        $country_name = $getData[5];
                        if(strlen($country_name) == 0){
                            $x++;
                            $country_id = '';
                        }else{
                            $country_data = Country::where('name', 'LIKE', $country_name)->first();
                            if($country_data){
                                $country_id = $country_data->id;
                            }else{
                                $country_id = "";
                                $x++;
                            }
                        }

                        $description = $getData[6];
                        $desc_strlength = strlen($description);
                        if($desc_strlength > 255){
                            $x++;
                        }

                        if($x > 0){
                            return back()->with('error', 'Wrong data format is uploaded. Please check row number '.$row.' in the uploaded file.' );
                        }

                        $team = array([
                            'user_id' => Auth::user()->id,
                            'sport_id' => $getData[0],
                            'name' => $getData[1],
                            'location' => $getData[2],
                            'homeGround' => $getData[3],
                            'homeGround_location' => $getData[4],
                            'country_id' => $country_id,
                            'description' => $getData[6],
                        ]);

                    }else{
                        $team = "";
                    }

                    if($getData[0] == null && $getData[1] == null && $getData[2] == null && $getData[3] == null && $getData[4] == null && $getData[5] == null && $getData[6] == null)
                    {
                        $player_email = $getData[7];
                        if(filter_var($player_email, FILTER_VALIDATE_EMAIL))
                        {
                            $finduser_email = User::where('email', $player_email)->first();
                            if($finduser_email){
                                $existPlayer_id = $finduser_email->id;
                            }else{
                                $existPlayer_id = 0;
                            }
                        }else{
                            $x++;
                        }

                        if($existPlayer_id == 0){

                            $first_name = $getData[8];
                            $first_name_strlength = strlen($first_name);
                            if($first_name_strlength > 30 || $first_name_strlength == 0){
                                $x++;
                            }

                            $last_name = $getData[9];
                            $last_name_strlength = strlen($last_name);
                            if($last_name_strlength > 30 || $last_name_strlength == 0){
                                $x++;
                            }

                            $password = $getData[10];
                            if(strlen($password) < 4 || strlen($password) > 100){
                                $x++;
                            }

                            $player_dob = $getData[11];
                            if($player_dob == "")
                            {
                                $x++;
                                $cal_dobDate = '';
                            }
                            else{

                                $dateFormat = 'd-m-Y';
                                $cal_dobDate = '';

                                $cal_time = strtotime($player_dob);
                                $testDate = date($dateFormat, $cal_time);
                                if($player_dob != $testDate)
                                {
                                    $x++;
                                }else{
                                    $cal_age = date('Y-m-d', $cal_time);
                                    $age = date_diff(date_create($cal_age), date_create('today'))->y;
                                    if($age > 14){
                                        $cal_dobDate = date('Y-m-d', $cal_time);
                                    }else{
                                        $x++;
                                    }
                                }
                            }

                            $height = $getData[12];
                            if($height == "" || $height > 999 || $height < 1){
                                $x++;
                            }else{
                                if(is_numeric(intval($height)) == false){
                                    $x++;
                                }
                            }

                            $weight = $getData[13];
                            if($weight == "" || $weight < 1 || $weight > 999){
                                $x++;
                            }else{
                                if(is_numeric(intval($weight)) == false){
                                    $x++;
                                }
                            }

                            $player_bio = $getData[14];
                            $valid_player_bio = strlen($player_bio);
                            if($valid_player_bio > 250 || $valid_player_bio < 3){
                                $x++;
                            }

                            $nationality = $getData[15];
                            if(strlen($nationality) == 0 || strlen($nationality) > 150){
                                $x++;
                                $country_id = '';
                            }else{
                                $country_data = Country::where('name', 'LIKE', $nationality)->first();
                                if($country_data){
                                    $country_id = $country_data->id;
                                }else{
                                    $country_id = "";
                                    $x++;
                                }
                            }
                            $location = $getData[16];
                            if(strlen($location) == 0 || strlen($location) > 50){
                                $x++;
                            }else{
                                $remove_space = str_replace(' ', '', $location);
                                $explodeLocation = explode(",", $remove_space);
                                $locationArrayCount = count($explodeLocation)-1;
                                $countryName = $explodeLocation[$locationArrayCount];
                                $country_data = Country::where('name', 'LIKE', $countryName)->first();
                                if($country_data){
                                }else{
                                    $x++;
                                }
                            }

                            $sport_id = $getData[17];
                            $sportsid_array = ['1', '2', '3', '4', '5', '6'];
                            if(in_array($sport_id, $sportsid_array))
                            {
                                if(intval($sport_id) != 1){
                                    $x++;
                                }
                            }else{
                                $x++;
                            }

                            $preferred_position = $getData[18];
                            $position_array = ['1' , '2', '3', '8'];
                            if(in_array($preferred_position, $position_array)){
                            }else{
                                $x++;
                            }
                            $jersey_no = $getData[19];
                            if($jersey_no != ""){
                                if(is_numeric(intval($jersey_no)) == false){
                                    $x++;
                                }
                            }

                            $sport_level_id = $getData[20];
                            $level_array = ['1', '2', '3'];
                            if(in_array($sport_level_id, $level_array))
                            {}else{
                                $x++;
                            }

                            $accept_team_invite = $getData[21];
                            $invite_array = ['0', '1'];
                            if(in_array($accept_team_invite, $invite_array))
                            {}else{
                                $x++;
                            }

                            $accept_user_invite = $getData[22];
                            $user_invite_array = ['1', '2', '0'];
                            if(in_array($accept_user_invite, $user_invite_array))
                            {}else{
                                $x++;
                            }

                            if($x > 0){
                                return back()->with('error', 'Wrong data format is uploaded. Please check row number '.$row.' in the uploaded file.' );
                            }

                            $player = array([
                                'playerId' => $existPlayer_id,
                                'first_name' => $getData[8],
                                'last_name' => $getData[9],
                                'email' => $getData[7],
                                'password' => Hash::make($getData[10]),
                                'dob' => $cal_dobDate,
                                'height' => $getData[12],
                                'weight' => $getData[13],
                                'bio' => $getData[14],
                                'nationality' => $getData[15],
                                'location' => $getData[16],
                                'sport_id' => $getData[17],
                                'preferred_position' => $getData[18],
                                'jersey_no' => $getData[19],
                                'sport_level_id' => $getData[20],
                                'accept_team_invite' => $getData[21],
                                'accept_user_invite' => $getData[22],
                            ]);
                        }else{
                            $player = array([
                                'playerId' => $existPlayer_id,
                                'first_name' => "",
                                'last_name' => "",
                                'email' => "",
                                'password' => "",
                                'dob' => "",
                                'height' => "",
                                'weight' => "",
                                'bio' => "",
                                'nationality' => "",
                                'location' => "",
                                'sport_id' => "",
                                'preferred_position' => $getData[18],
                                'jersey_no' => $getData[19],
                                'sport_level_id' => "",
                                'accept_team_invite' => "",
                                'accept_user_invite' => "",
                            ]);
                        }


                    }else{
                        $player = "";
                    }
                    $teamPlayersData = array('team' => $team, 'player' => $player);
                    array_push($createTeamsData, $teamPlayersData);
                }
            }
            // return $createTeamsData;
            if($x == 0){
                $team_id = 0;
                for ($i = 0; $i < sizeof($createTeamsData); $i++)
                {
                    $team_data = $createTeamsData[$i];
                    $teamdata = $team_data['team'];
                    if($teamdata != "")
                    {
                        $teams = Team::create([
                            'user_id' => Auth::user()->id,
                            'sport_id' => $teamdata[0]['sport_id'],
                            'name' => $teamdata[0]['name'],
                            'location' => $teamdata[0]['location'],
                            'homeGround' => $teamdata[0]['homeGround'],
                            'homeGround_location' => $teamdata[0]['homeGround_location'],
                            'country_id' => $teamdata[0]['country_id'],
                            'description' => $teamdata[0]['description'],
                            'is_active' => 1,
                        ]);
                        $team_id = $teams->id;
                    }
                    if($team_data['player'] != "")
                    {
                        $player_Data = $team_data['player'];
                        $p_Data = $player_Data[0];
                        $player_preferred_position = 0;
                        $jersey_num = 0;
                        if($p_Data['playerId'] != 0)
                        {
                            $player_id = $p_Data['playerId'];
                            $ufplayers = User_profile::where('profile_type_id', 2)
                                        ->where('user_id', $player_id)->first();

                            $jersey_num = $p_Data['jersey_no'];
                            if($p_Data['preferred_position'] == ""){
                                $player_preferred_position = $ufplayers->preferred_position;
                            }else{
                                $player_preferred_position = $p_Data['preferred_position'];
                            }
                        }else{
                            $data = User::create([
                                'first_name' => $p_Data['first_name'],
                                'last_name' => $p_Data['last_name'],
                                'email' => $p_Data['email'],
                                'password' => $p_Data['password'],
                                'check_popup' => 4,
                                'dob' => $p_Data['dob'],
                                'height' => $p_Data['height'],
                                'weight' => $p_Data['weight'],
                                'bio' => $p_Data['bio'],
                                'nationality' => $p_Data['nationality'],
                                'location' => $p_Data['location'],
                                'p_box_player' => 1,
                            ]);
                            $player_id = $data->id;
                            $u_profile = User_profile::create([
                                'user_id' => $player_id,
                                'profile_type_id' => 2,
                                'sport_id' => $p_Data['sport_id'],
                                'preferred_position' => $p_Data['preferred_position'],
                                'sport_level_id' => $p_Data['sport_level_id'],
                                'accept_team_invite' => $p_Data['accept_team_invite'],
                                'accept_user_invite' => $p_Data['accept_user_invite'],

                            ]);
                            $jersey_num = $p_Data['jersey_no'];
                            $player_preferred_position = $p_Data['preferred_position'];
                        }
                        $check_team_member = Team_member::where('team_id', $team_id)->where('member_id', $player_id)->first();
                        if(!empty($check_team_member))
                        {
                            if($check_team_member->invitation_status == 1 )
                            {
                            }
                            else if($check_team_member->invitation_status == 0 )
                            {
                            }
                            else
                            {
                                $update_request = Team_member::find($check_team_member->id);
                                $update_request->invitation_status = 1;
                                $update_request->action_user = Auth::user()->id;
                                $update_request->save();

                            }
                        }
                        else
                        {
                            if($player_id != Auth::user()->id)
                            {
                                $send_request =  new Team_member();
                                $send_request->action_user = Auth::user()->id;
                                $send_request->team_id = $team_id;
                                $send_request->member_id = $player_id;
                                $send_request->member_position_id = $player_preferred_position;
                                if($jersey_num != 0 && $jersey_num != ""){
                                    $send_request->jersey_number = $jersey_num;
                                }
                                $send_request->invitation_status = 1;
                                $send_request->save();
                                // return $send_request;
                            }
                        }
                    }
                }
            }

            fclose($file);
            return back()->with('success', 'Teams imported successfully!');

        }else{
            return back()->with('error', 'The uploaded file is empty. Please upload file with valid data.');
        }
    }
    public function dwnldPlayerCsvFile()
    {
        $myFile = public_path("playersdata.csv");
        $headers = ['Content-Type: text/csv'];
        $newName = 'Player' . time() . '.csv';

        return response()->download($myFile, $newName, $headers);
    }
    public function player_bulk()
    {
        if(Auth::check())
        {
            // if(Auth::user()->hasRole('superadmin')  == 'superadmin')
            if(Auth::user())
            {

                $ufplayers = User_profile::where('profile_type_id', 2)
                ->groupBy('user_id')
                ->pluck('user_id');

                $ufplayers_array = $ufplayers->toArray();

                $players = User::whereIn('id', $ufplayers_array)->orderBy('id','DESC')->get();

                $teams = Team::where('is_active', 1)->get();
                return view('backend.bulks.player_bulk',compact('players'));
            }
            else
            {
                return redirect('admin-panel');
            }
        }
        else
        {
            return redirect('admin-panel');
        }
    }

    public function player_import()
    {
        // $this->validate($request, array(
        //     'file'   => 'max:10240|required|mimes:csv,xlsx',
        // ));

        $filetype = $_FILES["import"]['name'];

        $allowed = array('csv', "CSV");
        $ext = pathinfo($filetype, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            return back()->with('error', 'Wrong file type is uploaded. Please upload only csv file');
        }

        $filename = $_FILES["import"]['tmp_name'];

        if ($_FILES['import']['size'] > 0) {
            $file = fopen($filename, "r");

            // $headers = fgetcsv($file, 1000, ",");
            $rowcount = 0;
            while (($getdata = fgetcsv($file, 10000000, ",")) !== FALSE) {
                if (max(array_keys($getdata)) == 15)
                {}else{
                    return back()->with('error', 'Wrong file data is uploaded. Please upload valid csv file');
                }
                if($getdata[0] == null && $getdata[1] == null && $getdata[2] == null && $getdata[3] == null && $getdata[4] == null && $getdata[5] == null && $getdata[6] == null && $getdata[7] == null
                && $getdata[8] == null && $getdata[9] == null && $getdata[10] == null && $getdata[11] == null && $getdata[12] == null && $getdata[13] == null && $getdata[14] == null && $getdata[15] == null){
                    continue;
                }else{
                    $rowcount++;
                }
            }

            if($rowcount > 2)
            {}else{
                return back()->with('error', 'The uploaded file is empty. Please upload file with valid data.');
            }

            $files = fopen($filename, "r");
            $row = 0;
            $x = 0;
            while (($getData = fgetcsv($files, 10000000, ",")) !== FALSE) {
                $row++;

                if ($row == 1) continue;
                if ($row == 2) continue;

                if($getData[0] == null && $getData[1] == null && $getData[2] == null && $getData[3] == null && $getData[4] == null && $getData[5] == null && $getData[6] == null && $getData[7] == null
                && $getData[8] == null && $getData[9] == null && $getData[10] == null && $getData[11] == null && $getData[12] == null && $getData[13] == null && $getData[14] == null && $getdata[15] == null){
                    continue;
                }

                $first_name = $getData[0];
                $first_name_strlength = strlen($first_name);
                if($first_name_strlength > 30 || $first_name_strlength == 0){
                    $x++;
                }

                $last_name = $getData[1];
                $last_name_strlength = strlen($last_name);
                if($last_name_strlength > 30 || $last_name_strlength == 0){
                    $x++;
                }

                $player_email = $getData[2];
                if(filter_var($player_email, FILTER_VALIDATE_EMAIL))
                {
                    $finduser_email = User::where('email', $player_email)->get();
                    if(count($finduser_email) > 0){
                        $x++;
                    }
                }else{
                    $x++;
                }

                $password = $getData[3];
                if(strlen($password) < 4 || strlen($password) > 100){
                    $x++;
                }

                $player_dob = $getData[4];
                if($player_dob == "")
                {
                    $x++;
                    $cal_dobDate = '';
                }
                else{

                    $dateFormat = 'd-m-Y';
                    $cal_dobDate = '';

                    $cal_time = strtotime($player_dob);
                    $testDate = date($dateFormat, $cal_time);
                    if($player_dob != $testDate)
                    {
                        $x++;
                    }else{
                        $cal_age = date('Y-m-d', $cal_time);
                        $age = date_diff(date_create($cal_age), date_create('today'))->y;
                        if($age > 14){
                            $cal_dobDate = date('Y-m-d', $cal_time);
                        }else{
                            $x++;
                        }
                    }
                }

                $height = $getData[5];
                if($height == "" || $height > 999 || $height < 1){
                    $x++;
                }else{
                    if(is_numeric(intval($height)) == false){
                        $x++;
                    }
                }

                $weight = $getData[6];
                if($weight == "" || $weight < 1 || $weight > 999){
                    $x++;
                }else{
                    if(is_numeric(intval($weight)) == false){
                        $x++;
                    }
                }

                $player_bio = $getData[7];
                $valid_player_bio = strlen($player_bio);
                if($valid_player_bio > 250 || $valid_player_bio < 3){
                    $x++;
                }

                $nationality = $getData[8];
                if(strlen($nationality) == 0 || strlen($nationality) > 150){
                    $x++;
                    $country_id = '';
                }else{
                    $country_data = Country::where('name', 'LIKE', $nationality)->first();
                    if($country_data){
                        $country_id = $country_data->id;
                    }else{
                        $country_id = "";
                        $x++;
                    }
                }

                $location = $getData[9];
                if(strlen($location) == 0 || strlen($location) > 50){
                    $x++;
                }else{
                    $remove_space = str_replace(' ', '', $location);
                    $explodeLocation = explode(",", $remove_space);
                    $locationArrayCount = count($explodeLocation)-1;
                    $countryName = $explodeLocation[$locationArrayCount];
                    $country_data = Country::where('name', 'LIKE', $countryName)->first();
                    if($country_data){
                    }else{
                        $x++;
                    }
                }

                $sportid = $getData[10];
                $sportid_array = ['1', '2', '3', '4', '5', '6'];
                if(in_array($sportid, $sportid_array))
                {
                    if(intval($sportid) != 1){
                        $x++;
                    }
                }else{
                    $x++;
                }

                $preferred_position = $getData[11];
                $position_array = ['1' , '2', '3', '8'];
                if(in_array($preferred_position, $position_array)){
                }else{
                    $x++;
                }

                $sport_level_id = $getData[12];
                $level_array = ['1', '2', '3'];
                if(in_array($sport_level_id, $level_array))
                {}else{
                    $x++;
                }

                $accept_team_invite = $getData[13];
                $invite_array = ['0', '1'];
                if(in_array($accept_team_invite, $invite_array))
                {}else{
                    $x++;
                }

                $accept_user_invite = $getData[14];
                $user_invite_array = ['1', '2', '0'];
                if(in_array($accept_user_invite, $user_invite_array))
                {}else{
                    $x++;
                }

                $team_idsData = $getData[15];
                $team_ids = str_replace(' ', '', $team_idsData);
                if($team_ids != ""){
                    $team_ids_a = $team_ids;
                    $checkTeam_ids_array = explode(',', $team_ids_a);
                    foreach ($checkTeam_ids_array as $checkTeam_id)
                    {
                        $findTeam = Team::find($checkTeam_id);
                        if($findTeam)
                        {}else{
                            $x++;
                        }
                    }
                }else{
                    $team_ids_a = "";
                }

                if($x > 0){
                return back()->with('error', 'Wrong data format is uploaded. Please check row number '.$row.' in the uploaded file.' );
                }

                $player[] = ([
                    'first_name' => $getData[0],
                    'last_name' => $getData[1],
                    'email' => $getData[2],
                    'password' => Hash::make($getData[3]),
                    'dob' => $cal_dobDate,
                    'height' => $getData[5],
                    'weight' => $getData[6],
                    'bio' => $getData[7],
                    'nationality' => $getData[8],
                    'location' => $getData[9],
                    'sport_id' => $getData[10],
                    'preferred_position' => $getData[11],
                    'sport_level_id' => $getData[12],
                    'accept_team_invite' => $getData[13],
                    'accept_user_invite' => $getData[14],
                    'team_ids' =>$team_ids_a,
                ]);
            }
            // return $player;
            // return $x;
            if($x == 0){
                for ($i = 0; $i < count($player); $i++) {
                    $p_Data = $player[$i];

                    $data = User::create([
                        'first_name' => $p_Data['first_name'],
                        'last_name' => $p_Data['last_name'],
                        'email' => $p_Data['email'],
                        'password' => $p_Data['password'],
                        'check_popup' => 4,
                        'dob' => $p_Data['dob'],
                        'height' => $p_Data['height'],
                        'weight' => $p_Data['weight'],
                        'bio' => $p_Data['bio'],
                        'nationality' => $p_Data['nationality'],
                        'location' => $p_Data['location'],
                        'p_box_player' => 1,
                    ]);
                    $user_id = $data->id;
                    $u_profile = User_profile::create([
                        'user_id' => $user_id,
                        'profile_type_id' => 2,
                        'sport_id' => $p_Data['sport_id'],
                        'preferred_position' => $p_Data['preferred_position'],
                        'sport_level_id' => $p_Data['sport_level_id'],
                        'accept_team_invite' => $p_Data['accept_team_invite'],
                        'accept_user_invite' => $p_Data['accept_user_invite'],

                    ]);
                    $t_data = $p_Data['team_ids'];
                    if($t_data != ""){
                        $team_ids_array = explode(',', $t_data);
                        foreach ($team_ids_array as $team_id)
                        {
                            $check_team_member = Team_member::where('team_id', $team_id)->where('member_id', $user_id)->first();
                            if(!empty($check_team_member))
                            {
                                if($check_team_member->invitation_status == 1 )
                                {
                                }
                                else if($check_team_member->invitation_status == 0 )
                                {
                                }
                                else
                                {
                                    $update_request = Team_member::find($check_team_member->id);
                                    $update_request->invitation_status = 1;
                                    $update_request->action_user = Auth::user()->id;
                                    $update_request->save();

                                }
                            }
                            else
                            {
                                if($user_id != Auth::user()->id)
                                {
                                    $send_request =  new Team_member();
                                    $send_request->action_user = Auth::user()->id;
                                    $send_request->team_id = $team_id;
                                    $send_request->member_id = $user_id;
                                    $send_request->member_position_id = $u_profile->preferred_position;
                                    $send_request->invitation_status = 1;
                                    $send_request->save();

                                }
                            }
                        }
                    }
                }
            }
            fclose($file);
            return back()->with('success', 'Players imported successfully!');

        }else{
            return back()->with('error', 'The uploaded file is empty. Please upload file with valid data.');
        }
    }
}
