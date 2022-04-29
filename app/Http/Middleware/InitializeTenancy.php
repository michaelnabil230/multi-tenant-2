<?php


namespace App\Http\Middleware;

use App\Tenancy;
use Closure;
use Illuminate\Http\Request;

class InitializeTenancy
{
    /**
     * Set this property if you want to customize the on-fail behavior.
     *
     * @var callable|null
     */
    public static $onFail;

    protected Tenancy $tenancy;

    public function __construct(Tenancy $tenancy)
    {
        $this->tenancy = $tenancy;
    }

    public function handle(Request $request, Closure $next)
    {
        $domain = $request->getHost();

        try {
            $this->tenancy->initialize($domain);
        } catch (\Exception $e) {
            $onFail = static::$onFail ?? function () {
                abort(404);
            };

            return $onFail($request, $next);
        }

        return $next($request);
    }
}
