<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use function PHPUnit\Framework\isNull;

class AdminController extends Controller
{

    public function getDashoard(Request $req){

        //potrebbe essere fatto tutto con una query
        $total_user = User::all()->count();
        $blocked_user = User::where('active', '=', 'false')->count();
        $active_user = User::select()
            ->whereNotNull('last_login')
            ->whereRaw("last_login > 'now'::timestamp - '4 month'::interval")->count();

        $users_by_month = User::select([
            DB::raw("date_trunc('month', created_at) as month"),
            DB::raw('COUNT(*) as users')
        ])->groupBy('month')->orderBy('month', 'ASC')->get();

        $comulative_users_by_month = array_fill(0, count($users_by_month), 0);
        for($i = 0; $i < count($users_by_month); $i++){
            if($i == 0) $comulative_users_by_month[0] = $users_by_month[0]->users;
            else {
                $comulative_users_by_month[$i] = $comulative_users_by_month[$i-1] + $users_by_month[$i]->users;
            }
        }

        $games = Game::select(['status', DB::raw('COUNT(*) as count')])->groupBy('status')->get();
        $games_by_month = Game::select([
            DB::raw("date_trunc('month', created_at) as month"),
            DB::raw('COUNT(*) as games')
        ])->groupBy('month')->orderBy('month', 'ASC')->get();
        $comulative_games_by_month = array_fill(0, count($games_by_month), 0);
        for($i = 0; $i < count($games_by_month); $i++){
            if($i == 0) $comulative_games_by_month[0] = $games_by_month[0]->games;
            else {
                $comulative_games_by_month[$i] = $comulative_games_by_month[$i-1] + $games_by_month[$i]->games;
            }
        }

        return view('html.admin.dashboard')
            ->with("users", ["blocked" => $blocked_user, "active" => $active_user, "inactive" => $total_user - $active_user - $blocked_user])
            ->with("user_history_ticks", $users_by_month->map(function ($e){return $e->month;})->toArray())
            ->with("user_history_data", $comulative_users_by_month)
            ->with("games_status_ticks", $games->map(function ($e){return $e->status;})->toArray())
            ->with("games_status_data", $games->map(function ($e){return $e->count;})->toArray())
            ->with("games_history_ticks", $users_by_month->map(function ($e){return $e->month;})->toArray())
            ->with("games_history_data", $comulative_users_by_month);
    }

    public function editUser(Request $req){
        $req->validate([
            "username" => "required"
        ]);

        var_dump($req->username);

        $u = User::where('username', '=', $req->username)->first();
        if(is_null($u))
            redirect(route('admin.user'));

        $u->active = $req->active == 'on';
        $u->admin = $req->admin == 'on';
        $u->save();
        return redirect(route('admin.user'));

    }

    public function deleteUser(Request $req){
        $req->validate([
            "username" => "required"
        ]);

        $u = User::where('username', '=', $req->username)->first();
        $u->delete();
        return redirect(route('admin.user'));
    }
}
