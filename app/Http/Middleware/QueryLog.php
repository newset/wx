<?php
/**
 * Date: 2015/4/19
 * Time: 18:25
 * @author GROOT (pzyme@outlook.com)
 */
namespace App\Http\Middleware;
use Closure;
use DB;

/**
 * 开启查询记录
 * Class QueryLog
 * @package App\Http\Middleware
 */
class QueryLog {

    public function handle($request, Closure $next)
    {
        if(env('APP_DEBUG')) DB::enableQueryLog();
        return $next($request);
    }
}