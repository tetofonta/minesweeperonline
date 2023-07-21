<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use App\Models\User;

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
}
