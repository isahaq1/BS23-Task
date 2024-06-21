<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MockResponseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('x-mock-status')) {
            $status = $request->header('x-mock-status');
            // dd($status);
            $response = [
                'success' => 'Mock response for success',
                'fail' => 'Mock response for failure',
            ];

            if ($status == 'success') {
                return response()->json(['message' => $response['success']], 200);
            } elseif ($status == 'failed') {
                return response()->json(['message' => $response['fail']], 400);
            }
        }

        return $next($request);
    }
}
