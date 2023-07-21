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
        'is_admin'
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
        'last_login' => 'datetime'
    ];

    public function games(){
        return $this->hasMany(Game::class)->orderBy('created_at', 'desc');
    }

    public function getPoints(){
        return User::select([DB::raw("(SUM(CASE WHEN games.status = 'won' AND games.ranked = true THEN games.bombs WHEN games.status != 'running' and games.ranked = true THEN -games.bombs ELSE 0 END) + 1000) as points")])
            ->join('games', 'users.id', '=', 'games.user_id')
            ->where('users.id', '=', $this->id)
            ->first()->points;
    }

    public function getStandingPosition(){
        return User::select(['username'])
            ->join('games', 'users.id', '=', 'games.user_id')
            ->groupBy('users.username')
            ->havingRaw("(SUM(CASE WHEN games.status = 'won' AND games.ranked = true THEN games.bombs WHEN games.status != 'running' and games.ranked = true THEN -games.bombs ELSE 0 END) + 1000) >= ?", [$this->getPoints()])
            ->count();
    }
}
