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

class Admin
{
    /**
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()) return response(['error' => true], 404);
        if(!auth()->user()->admin) return response(['error' => true], 403);
        return $next($request);
    }
}
