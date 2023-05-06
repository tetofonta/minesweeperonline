<?php

namespace App\Http\Middleware;

use Exception;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class DBTransaction
{
    /**
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            DB::beginTransaction();
            $ret = $next($request);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        if ($ret instanceof Response && $ret->getStatusCode() > 399) {
            DB::rollBack();
        } else {
            DB::commit();
        }

        return $ret;
    }
}
