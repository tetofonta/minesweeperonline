<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Builder
 */
class Game extends Model
{
    use HasFactory;
    const UPDATED_AT = null;
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'width',
        'height',
        'bombs',
        'seed',
        'limit',
        'status',
        'state',
        'finished_at',
        'ranked'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'finished_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getTotalDuration(){
        return Game::select([DB::raw('(SUM(EXTRACT(EPOCH FROM (finished_at - created_at)))/60/60)::int as total_duration')])
            ->where('status', '!=', 'running')
            ->whereNotNull('finished_at')
            ->first()
            ->total_duration;
    }
}
