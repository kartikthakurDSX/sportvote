<?php

use App\Http\Controllers\Match_fixtureController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\FanController;
use App\Http\Controllers\PlayerprofileController;
use App\Http\Controllers\ForgetPasswordController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\RefreeController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MatchfixtureController;
use App\Http\Controllers\MyTeamController;
use App\Http\Controllers\MyCompetitionController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BulkUploadController;
use App\Http\Controllers\Admin\CompReportTypeController;
use App\Http\Controllers\Admin\CompSubTypeController;
use App\Http\Controllers\Admin\CompTypeController;
use App\Http\Controllers\Admin\MemberPositionController;
use App\Http\Controllers\Admin\NotifyModuleController;
use App\Http\Controllers\Admin\Sport_attitudeController;
use App\Http\Controllers\Admin\SportGroundMapController;
use App\Http\Controllers\Admin\SportGroundPositionController;
use App\Http\Controllers\Admin\SportLevelController;
use App\Http\Controllers\Admin\SportsController;
use App\Http\Controllers\Admin\SportStatsController;
use App\Http\Controllers\CompController;
use App\Http\Controllers\features\FeatureController;
use App\Http\Controllers\pricing\PricingController;
use App\Http\Controllers\settings\SettingController;
use App\Http\Controllers\terms\TermsOfUseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [HomePageController::class, 'home']);
Route::get('/zoho', [HomePageController::class, 'testzoho'])->name('testzoho');
Route::get('/index', [HomePageController::class, 'home'])->name('index');
Route::post('SaveUserMail', [HomePageController::class, 'SaveUserMail']);
Route::post('updateverification', [HomePageController::class, 'updateverification']);
Route::post('updatProfile', [HomePageController::class, 'updatProfile']);
Route::post('userlogin', [HomePageController::class, 'userlogin']);
Route::post('userProfile', [HomePageController::class, 'userProfile']);
Route::post('userloginpass', [HomePageController::class, 'userloginpass']);
Route::get('afterlogin', [HomePageController::class, 'afterlogin']);
Route::post('search.js', [HomePageController::class, 'search'])->name('search.index');
Route::post('create_login_otp', [HomePageController::class, 'create_login_otp']);
Route::post('userRank', [DashboardController::class, 'userRank']);
Route::get('checkUserprofile', [HomePageController::class, 'checkUserprofile']);
Route::get('checkrefreeprofile', [HomePageController::class, 'checkrefreeprofile']);
Route::post('check_email_login', [HomePageController::class, 'check_email_login']);
Route::post('create_password', [HomePageController::class, 'create_password']);
Route::post('vanish_otp', [HomePageController::class, 'vanish_otp']);

Route::post('check_existing_email', [ForgetPasswordController::class, 'check_existing_email']);
// Route::post('send_passwordforget_mail',[ForgetPasswordController::class,'send_passwordforget_mail']);
// Route::post('reset_password/{$token}',[ForgetPasswordController::class,'reset_password']);
// Route::get('reset_password/{token}/{email}',[ForgetPasswordController::class,'reset_password']);
// Route::post('submit_reset_password',[ForgetPasswordController::class,'submit_reset_password']);



Route::get('checkteamMenus', [HomePageController::class, 'checkteamMenus']);
Route::get('checkCompetitionMenus', [HomePageController::class, 'checkCompetitionMenus']);

Route::get('features', [FeatureController::class, 'index']);
Route::get('pricing', [PricingController::class, 'index']);
Route::post('match_Details', [CompetitionController::class, 'match_Details']);

Route::resource('match-fixture', Match_fixtureController::class);
Route::resource('player_profile', PlayerprofileController::class);
Route::resource('competition', CompetitionController::class);

Route::group(
    ['middleware' => ['auth']],
    function () {
        Route::post('reset_password', [ForgetPasswordController::class, 'reset_password']);
        // Route::resource('competition', CompetitionController::class);
        Route::post('public_top_performer', [CompetitionController::class, 'public_top_performer']);

        Route::post('comp_top_fiveteam', [CompetitionController::class, 'comp_top_fiveteam']);
        Route::post('comp_top_fiveplayer', [CompetitionController::class, 'comp_top_fiveplayer']);
        Route::post('top_players_sats_list', [CompetitionController::class, 'top_players_sats_list']);
        Route::post('top_teams_sats_list', [CompetitionController::class, 'top_teams_sats_list']);
        Route::post('temp_league_team', [CompetitionController::class, 'temp_league_team']);
        Route::post('league_quick_compare', [CompetitionController::class, 'league_quick_compare']);
        Route::post('on_change_get_team_logo', [CompetitionController::class, 'on_change_get_team_logo']);
        Route::post('on_change_mvp_winner', [CompetitionController::class, 'on_change_mvp_winner']);
        Route::resource('team', TeamController::class);
        Route::post('save_team', [TeamController::class, 'save_team'])->name('team.save_team');
        Route::post('team_stat_graphic', [TeamController::class, 'team_stats']);
        // Route::resource('player_profile', PlayerprofileController::class);
        Route::resource('user_profile', PlayerprofileController::class);
        Route::post('player_p_my_stat', [PlayerprofileController::class, 'player_p_my_stat']);
        Route::post('player_info_fixture', [Match_fixtureController::class, 'player_info_fixture']);
        // Route::resource('match-fixture',Match_fixtureController::class);


        Route::get('terms', [TermsOfUseController::class, 'index']);
        Route::get('setting', [SettingController::class, 'index']);
    }
);
Route::get('public_top_performer', [CompetitionController::class, 'public_top_performer']);


//Backend routes Start from Here
Route::get('admin-panel', [AdminLoginController::class, 'index']);
Route::post('admin-login', [AdminLoginController::class, 'login'])->name('admin-login');
Route::get('admin-dashboard', [AdminLoginController::class, 'dashboard'])->name('admin-dashboard');
Route::get('admin-logout', [AdminLoginController::class, 'logout']);
Route::get('comp-bulk', [BulkUploadController::class, 'comp_bulk']);
Route::post('admin-Competition-import', [BulkUploadController::class, 'comp_import']);
Route::get('team-bulk', [BulkUploadController::class, 'team_bulk']);
Route::get('player-bulk', [BulkUploadController::class, 'player_bulk']);
Route::post('admin-team-import', [BulkUploadController::class, 'team_import']);
Route::post('admin-player-import', [BulkUploadController::class, 'player_import']);

/**for Download sample comp csv */
Route::get('comp-csv', [BulkUploadController::class, 'dwnldCompFile']);
Route::get('players-csv', [BulkUploadController::class, 'dwnldPlayerCsvFile']);
Route::get('team-csv', [BulkUploadController::class, 'dwnldTeamCsvFile']);

/**For comp sub-Type */

Route::get('admin-comp-subtype', [CompSubTypeController::class, 'index']);
Route::get('admin-add-compSubtype', [CompSubTypeController::class, 'add']);
Route::post('admin-create-compSubtype', [CompSubTypeController::class, 'create']);
Route::get('admin/comp-sub-type/{competitionSubType}/edit', [CompSubTypeController::class, 'edit']);
Route::post('admin/comp-sub-type/{competitionSubType}/update', [CompSubTypeController::class, 'update']);
Route::delete('admin/comp-sub-type/{compSubType}/delete', [CompSubTypeController::class, 'delete']);


/**For comp_report Type */

Route::get('admin-comp-report-type', [CompReportTypeController::class, 'index']);
Route::get('admin-add-compReportType', [CompReportTypeController::class, 'add']);
Route::post('admin-create-compReportType', [CompReportTypeController::class, 'create']);
Route::get('admin/comp-report-type/{CompReportType}/edit', [CompReportTypeController::class, 'edit']);
Route::post('admin/comp-report-type/{CompReportType}/update', [CompReportTypeController::class, 'update']);
Route::delete('admin/comp-report-type/{CompReportType}/delete', [CompReportTypeController::class, 'delete']);
Route::get('changeCompReportTypeStatus', [CompReportTypeController::class, 'changeStatus']);

/**For comp Type */

Route::get('admin-comp-type', [CompTypeController::class, 'index']);

Route::get('admin-add-compType', [CompTypeController::class, 'add']);
Route::post('admin-create-compType', [CompTypeController::class, 'create']);

Route::get('admin/comp-type/{CompType}/edit', [CompTypeController::class, 'edit']);
Route::post('admin/comp-type/{CompType}/update', [CompTypeController::class, 'update']);

Route::delete('admin/comp-type/{module}/delete', [CompTypeController::class, 'delete']);

Route::get('changeCompTypeStatus', [CompTypeController::class, 'changeStatus']);

/**fOR member position */
Route::get('admin-member-position', [MemberPositionController::class, 'index']);
Route::get('admin-add-member-position', [MemberPositionController::class, 'add']);
Route::post('admin-create-member-position', [MemberPositionController::class, 'create']);
Route::get('admin/member-position/{MemberPosition}/edit', [MemberPositionController::class, 'edit']);
Route::post('admin/member-position/{MemberPosition}/update', [MemberPositionController::class, 'update']);
Route::delete('admin/member-position/{MemberPosition}/delete', [MemberPositionController::class, 'delete']);


/**For Notify Modules */

Route::get('admin-notifty-modules', [NotifyModuleController::class, 'index']);
Route::get('admin-add-notiftyModules', [NotifyModuleController::class, 'add']);

Route::post('admin-create-notifyModule', [NotifyModuleController::class, 'create']);
Route::get('admin/notify-module/{NotifyModule}/edit', [NotifyModuleController::class, 'edit']);
Route::post('admin/notify-module/{NotifyModule}/update', [NotifyModuleController::class, 'update']);
Route::delete('admin/notify-module/{NotifyModule}/delete', [NotifyModuleController::class, 'delete']);

/**For Sport Stats */
Route::get('admin.sport-stats', [SportStatsController::class, 'index']);
Route::get('admin.add-sportStats', [SportStatsController::class, 'add']);
Route::post('admin.create-sportStats', [SportStatsController::class, 'create']);
Route::get('admin/sport-stats/{sportStat}/edit', [SportStatsController::class, 'edit']);
Route::post('admin/sport-stats/{sportStat}/update', [SportStatsController::class, 'update']);
Route::delete('admin/sport-stats/{sportStat}/delete', [SportStatsController::class, 'delete']);

/**For Sport levels */
Route::get('admin-sport-levels', [SportLevelController::class, 'index']);
Route::get('admin-add-sportLevel', [SportLevelController::class, 'add']);
Route::post('admin-create-sportLevel', [SportLevelController::class, 'create']);
Route::get('admin/sport-level/{sport}/edit', [SportLevelController::class, 'edit']);
Route::post('admin/sport-level/{sport}/update', [SportLevelController::class, 'update']);
Route::delete('admin/sport-level/{sport}/delete', [SportLevelController::class, 'delete']);

/**For Sports */
Route::get('sports', [SportsController::class, 'index']);
Route::get('admin-add-sports', [SportsController::class, 'add']);
Route::post('admin-create-sports', [SportsController::class, 'create']);
Route::get('admin/sport/{sport}/edit', [SportsController::class, 'edit']);
Route::post('admin/sport/{sport}/update', [SportsController::class, 'update']);
Route::delete('admin/sport/{sport}/delete', [SportsController::class, 'delete']);


/**For Sport Attitudes */
Route::get('admin-sport-attitude', [Sport_attitudeController::class, 'index']);
Route::get('admin-add-sportAttitude', [Sport_attitudeController::class, 'add']);
Route::post('admin-create-sportAttitude', [Sport_attitudeController::class, 'create']);
Route::get('admin/sport-attitude/{sport}/edit', [Sport_attitudeController::class, 'edit']);
Route::post('admin/sport});-attitude/{sport}/update', [Sport_attitudeController::class, 'update']);
Route::delete('admin/sport-attitude/{sport}/delete', [Sport_attitudeController::class, 'delete']);
Route::get('changeSportAttitudeStatus', [Sport_attitudeController::class, 'changeStatus']);

/**For Ground Positions */
Route::get('admin-sport-ground-positions', [SportGroundPositionController::class, 'index']);
Route::get('admin-add-sportGroundPositions', [SportGroundPositionController::class, 'add']);
Route::post('admin-create-sportGroundPositions', [SportGroundPositionController::class, 'create']);
Route::get('admin/sport-ground-position/{SportGroundPosition}/edit', [SportGroundPositionController::class, 'edit']);
Route::post('admin/sport-ground-position/{SportGroundPosition}/update', [SportGroundPositionController::class, 'update']);
Route::delete('admin/sport-ground-position/{SportGroundPosition}/delete', [SportGroundPositionController::class, 'delete']);

/**For Ground Maps */
Route::get('admin-sport-ground-map', [SportGroundMapController::class, 'index']);
Route::get('admin-add-sportGroundMap', [SportGroundMapController::class, 'add']);
Route::post('admin-create-sportGroundMap', [SportGroundMapController::class, 'create']);
Route::get('admin/sport-ground-map/{SportGroundMap}/edit', [SportGroundMapController::class, 'edit']);
Route::post('admin/sport-ground-map/{SportGroundMap}/update', [SportGroundMapController::class, 'update']);
Route::delete('admin/sport-ground-map/{SportGroundMap}/delete', [SportGroundMapController::class, 'delete']);

//Backend routes End Here



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('autosearch_player_name', [DashboardController::class, 'autosearch_player_name'])->name('autosearch_player_name');
    Route::get('team_comp_follow', [DashboardController::class, 'team_comp_follow']);
    Route::post('request_remove', [DashboardController::class, 'request_remove']);
    Route::post('request_accept', [DashboardController::class, 'request_accept']);
    Route::Post('request_reject', [DashboardController::class, 'request_reject']);
    Route::post('attendee_team', [DashboardController::class, 'attendee_team']);
    Route::post('player_stats', [DashboardController::class, 'player_stats']);
    Route::post('get_comp_my_stat_pd', [DashboardController::class, 'get_comp_my_stat_pd']);
    Route::post('top_performaer', [DashboardController::class, 'top_performaer']);
    Route::post('remove_p_boxes', [DashboardController::class, 'remove_p_boxes']);
    Route::post('get_comp_logo', [DashboardController::class, 'get_comp_logo']);

    // teams

    Route::post('team_members', [TeamController::class, 'team_members']);
    Route::post('team_logo_crop', [TeamController::class, 'team_logo_crop'])->name('team_logo_crop');
    // Route::post('team_submit',[TeamController::class,'team_submit']);
    // Route::get('my_teams/{id}',[TeamController::class,'my_teams']);

    Route::post('remove_member_team', [TeamController::class, 'remove_member']);
    Route::post('edit_teamlogo/{id}', [TeamController::class, 'edit_teamlogo']);

    Route::post('send_invitation_team_admins', [TeamController::class, 'send_invitation_team_admins']);
    //trophy cabinate url
    Route::post('addtrophycabinet', [TeamController::class, 'adddetail']);
    Route::post('edittrophycabinet', [TeamController::class, 'editdetail']);
    Route::get('edittrophy_cabinet/{id}', [TeamController::class, 'editcabinet']);
    Route::get('delete/{id}', [TeamController::class, 'delete']);
    Route::get('autosearch_team_player/{id}', [TeamController::class, 'autosearch_player']);
    Route::get('autosearch_member_name/{id}', [TeamController::class, 'autosearch_user']);
    Route::post('send_invitation_team_player', [TeamController::class, 'send_invitation_team_player']);
    Route::Post('most_stat_player', [TeamController::class, 'most_stat_player']);
    Route::post('edit_teambanner/{id}', [TeamController::class, 'edit_teambanner']);
    Route::post('save_team_contact', [TeamController::class, 'save_team_contact']);
    Route::get('TeamAdmin-profile/{admin_id}/{team_id}', [TeamController::class, 'team_admin_profile']);

    // for a fan
    Route::resource('fan', FanController::class);
    // Route::post('save_profile_pic',[FanController::class,'save_profile_pic']);
    Route::post('crop', [FanController::class, 'crop'])->name('crop');
    Route::post('addfriend', [FanController::class, 'addfriend']);
    Route::post('unfriends', [FanController::class, 'unfriend']);
    Route::post('follow_suggested_player', [FanController::class, 'follow_suggested_player']);
    Route::post('unfollow_player', [FanController::class, 'unfollow_player']);
    Route::post('follow_team', [FanController::class, 'follow_team']);
    Route::post('unfollow_team', [FanController::class, 'unfollow_team']);
    Route::post('follow_comps', [FanController::class, 'follow_comps']);
    Route::post('unfollow_comp', [FanController::class, 'unfollow_comp']);

    // player profile

    Route::get('create_player-prfile', [PlayerprofileController::class, 'create_player_profile']);

    Route::get('autosearch_player', [PlayerprofileController::class, 'autosearch_player'])->name('autosearch_player');
    Route::post('edit_playerlogo/{id}', [PlayerprofileController::class, 'edit_playerlogo']);
    Route::post('edit_playerimg/{id}', [PlayerprofileController::class, 'edit_playerimg']);
    Route::post('addplayertrophycabinet', [PlayerprofileController::class, 'addplayertrophycabinet']);
    Route::get('deleteplayertrophycabinet/{id}', [PlayerprofileController::class, 'deleteplayertrophycabinet']);
    Route::post('edit_playerbanner/{id}', [PlayerprofileController::class, 'edit_playerbanner']);

    //suggested follow and add friend
    Route::post('fansearchdata', [HomePageController::class, 'search']);

    // Referee
    Route::resource('referee', RefreeController::class);
    // Route::post('referee.store',RefreeController::class, 'store');

    Route::get('autosearch_comp', [CompetitionController::class, 'autosearch_comp'])->name('autosearch_comp');

    // Competition create

    Route::get('CompAdmin-profile/{admin_id}/{comp_id}', [CompetitionController::class, 'comp_admin_profile']);
    Route::post('comp_logo_crop', [CompetitionController::class, 'comp_logo_crop'])->name('comp_logo_crop');
    Route::post('edit_complogo/{id}', [CompetitionController::class, 'edit_comp_logo']);
    Route::post('edit_compbanner/{id}', [CompetitionController::class, 'edit_compbanner']);
    Route::post('comp_sub_type', [CompetitionController::class, 'comp_sub_type']);
    Route::post('createComp', [CompetitionController::class, 'createComp']);
    Route::post('save_competition', [CompetitionController::class, 'save_competition']);
    Route::post('team_minmax', [CompetitionController::class, 'team_minmax']);
    Route::post('send_invitation', [CompetitionController::class, 'invitation']);
    Route::get('autosearch_team', [CompetitionController::class, 'autosearch_team'])->name('autosearch_team');
    Route::get('search_team', [CompetitionController::class, 'search_team'])->name('search_team');
    Route::post('competition_members', [CompetitionController::class, 'competition_members']);
    Route::post('remove_member_comp', [CompetitionController::class, 'remove_member']);
    Route::post('send_comp_invitation', [CompetitionController::class, 'send_comp_invitation']);
    Route::post('send_request_compadmin', [CompetitionController::class, 'send_request_compadmin']);
    Route::post('send_request_referee', [CompetitionController::class, 'send_request_referee']);
    Route::post('team_rank_determine', [CompetitionController::class, 'team_rank_determine']);
    Route::post('player_rank_determine', [CompetitionController::class, 'player_rank_determine']);
    //Route::get('KO-competition/{id}',[CompetitionController::class,'ko_Competition']);
    Route::get('KO-competition/{id}', [CompetitionController::class, 'ko_competition']);
    Route::get('block_comp/{id}', [CompetitionController::class, 'destroy']);
    Route::get('block_competition/{id}', [CompetitionController::class, 'mycompdestroy']);
    Route::get('autosearch_user_name', [CompetitionController::class, 'autosearch_user']);
    Route::get('autosearch_compmember_name', [CompetitionController::class, 'autosearch_userprofile']);
    Route::get('autosearch_comprefree_name', [CompetitionController::class, 'autosearch_refreeprofile']);
    Route::post('send_invitation_comp_admins', [CompetitionController::class, 'add_admins']);
    Route::post('send_invitation_referee_admins', [CompetitionController::class, 'add_referee']);
    Route::get('draft_competition/{id}', [CompetitionController::class, 'draftcomp']);

    //Ko Fixture table
    Route::post('create_fixture', [CompetitionController::class, 'create_fixture']);
    Route::post('generate_ics_file_leauge', [CompetitionController::class, 'generate_ics_file_leauge']);

    Route::post('save_comp_contact', [CompetitionController::class, 'save_comp_contact']);
    Route::post('create_league_fixture', [CompetitionController::class, 'create_league_fixture']);
    Route::post('edit_league_fixture', [CompetitionController::class, 'edit_league_fixture']);
    //my Team
    Route::resource('my_team', MyTeamController::class);
    Route::post('player_info', [MyTeamController::class, 'player_info']);
    Route::post('player_jersey_number', [MyTeamController::class, 'player_jersey_number']);

    Route::get('created_teams', [MyTeamController::class, 'mycreatedTeam']);
    Route::get('all_teams', [MyTeamController::class, 'allTeams']);
    Route::get('following_teams', [MyTeamController::class, 'following_teams']);
    Route::get('participated_teams', [MyTeamController::class, 'participatedIn']);

    //my competitions
    Route::resource('my_competition', MyCompetitionController::class);
    Route::post('select_players', [MyCompetitionController::class, 'select_players']);
    Route::post('selected_players', [MyCompetitionController::class, 'selected_players']);
    Route::post('store_match_fixture', [MyCompetitionController::class, 'store_match_fixture']);

    Route::get('participate_competitions', [CompetitionController::class, 'participate_in']);
    Route::get('follow_competitions', [CompetitionController::class, 'follow_comp']);
    Route::get('created_competitions', [CompetitionController::class, 'my_competitions']);
    Route::get('all_competitions', [CompetitionController::class, 'all_competitions']);

    // Matches
    // Route::resource('match_fixture',Match_fixtureController::class);

    Route::post('player_image', [Match_fixtureController::class, 'player_image']);
    Route::post('script.js', [Match_fixtureController::class, 'substitutePLayer'])->name('substitute.player');
    Route::post('save_lineup_players', [Match_fixtureController::class, 'save_lineup_players']);

    Route::post('fixture_squads_players', [Match_fixtureController::class, 'fixture_squads_players']);
    Route::post('submit_fixture_squad', [Match_fixtureController::class, 'submit_fixture_squad']);

    Route::post('fixture_stat', [Match_fixtureController::class, 'fixture_stat']);
    Route::post('ownGoal_statTime', [Match_fixtureController::class, 'ownGoal_statTime']);
    Route::post('find_position_player', [Match_fixtureController::class, 'find_position_player']);
    Route::post('change_squad_player_position', [Match_fixtureController::class, 'change_squad_player_position']);
    Route::post('/updateStats/{id}', [MatchfixtureController::class, 'updateStats'])->name('match.stats');

    Route::get('notifications', [NotificationsController::class, 'index']);
    // Route::post('fixture_teams',[MyCompetitionController::class,'fixture_teams']);
    // Route::post('team_players',[MyCompetitionController::class,'team_players']);
    // Route::post('save_squad_players',[MyCompetitionController::class,'save_squad_players']);
    // Route::post('select_squad_players',[MyCompetitionController::class,'select_squad_players']);
    // Route::post('save_selected_squad_player',[MyCompetitionController::class,'save_selected_squad_player']);

    //Route for new comp pages
    Route::get('/league-view/{id}', [CompController::class, 'showcomp']);
    Route::get('get-fixtures', [CompController::class, 'get_fixtures']);
    Route::get('/ics_file/{id}', [CompController::class, 'ics_file']);
    Route::get('comp-info', [CompController::class, 'comp_info']);
    Route::get('save_info', [CompController::class, 'save_info']);
    // livewire route
    Route::get('logout', [HomePageController::class, 'logout']);

});

require __DIR__ . '/auth.php';
