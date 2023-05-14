<?php

namespace App\Http\Middleware;

use App\Models\Game;
use Exception;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;

class InGame
{
    /**
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()) response(['error' => true], 404);
        $game = Game::where('user_id', auth()->user()->id)->where('status', 'running')->first();
        if(!$game) return response(view('html.game.game', ['error' => true]), 404);
        $request['_game'] = $game;
        return $next($request);
    }
}
