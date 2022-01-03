<?php


namespace Module\Fields\Middleware;


use App\Helper\Submitter;
use Closure;
use Illuminate\Http\Request;

class FieldsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param $scope
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Handle Request Before Controller

        return $next($request); // Execute Controller
    }
}