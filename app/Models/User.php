<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin Builder
 */
class User extends Authenticatable
{
    use HasFactory;


    public $incrementing = false;
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'id',
        'password',
        'admin',
        'active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login' => 'datetime',
        'admin' => 'boolean',
        'active' => 'boolean'
    ];

    public function games(){
        return $this->hasMany(Game::class)->orderBy('created_at', 'desc');
    }

    public function getPoints(){
        return User::select([DB::raw("(SUM(CASE WHEN games.status = 'won' AND games.ranked = true THEN games.bombs WHEN games.status != 'running' and games.ranked = true THEN -games.bombs ELSE 0 END) + 1000) as points")])
            ->leftJoin('games', 'users.id', '=', 'games.user_id')
            ->where('users.id', '=', $this->id)
            ->first()->points;
    }

    public function getStandingPosition(){
        if(!$this->active) return -1;
        return User::select(['username'])
            ->join('games', 'users.id', '=', 'games.user_id')
            ->where('users.active', '=', 'true')
            ->groupBy('users.username')
            ->havingRaw("(SUM(CASE WHEN games.status = 'won' AND games.ranked = true THEN games.bombs WHEN games.status != 'running' and games.ranked = true THEN -games.bombs ELSE 0 END) + 1000) >= ?", [$this->getPoints()])
            ->count();
    }

    public static function getStandings(){
        return User::select([
            'users.username as username',
            DB::raw("(SUM(CASE WHEN games.status = 'won' THEN games.bombs WHEN games.status != 'running' THEN -games.bombs ELSE 0 END) + 1000) as points"),
            DB::raw('COUNT(*) OVER() as total')
        ])
            ->join('games', 'games.user_id', '=', 'users.id')
            ->whereNotNull('users.email_verified_at')
            ->where('users.active', '=', 'true')
            ->where('games.ranked', '=', 'true')
            ->groupBy('users.username')
            ->orderBy('points', 'DESC')
            ->orderByRaw('COUNT(games.id) ASC');
    }

    public static function getStandingsAverageCompletionTime(){
        return User::select([
            'users.username as username',
            DB::raw("to_char(make_interval(0, 0, 0, 0, 0, 0, (SUM(EXTRACT(EPOCH FROM games.finished_at - games.created_at))/COUNT(games.id))), 'HH24h MIm SSs') as points"),
            DB::raw('COUNT(*) OVER() as total')
        ])
            ->join('games', 'games.user_id', '=', 'users.id')
            ->whereNotNull('users.email_verified_at')
            ->where('users.active', '=', 'true')
            ->where('games.ranked', '=', 'true')
            ->where('games.status', '=', 'won')
            ->groupBy('users.username')
            ->orderBy('points', 'ASC')
            ->orderByRaw('COUNT(games.id) ASC');
    }
}
