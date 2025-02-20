<?php

namespace ManuelLuvuvamo\BugCourier\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HandleServerError
{
    /**
     * Handle an incoming request and capture exceptions globally.
     */
    public function handle(Request $request, Closure $next)
    {
            $response = $next($request);

            if ($response->getStatusCode() === 500) {
                
                $error_title = "Error 500 - Execution Failure in " . $response->exception->getFile() . " Captured on ".  date('Y/m/d H:i:s');

                $error_message = $response->exception->getMessage();
                $error_file = $response->exception->getFile();
                $error_line = $response->exception->getLine();
                $error_trace = $response->exception->getTraceAsString();
                $error_url = $request->fullUrl();

                $detailed_error_message = "Error: $error_message\n\n";
                $detailed_error_message .= "File: $error_file\n\n";
                $detailed_error_message .= "Line: $error_line\n\n";
                $detailed_error_message .= "URL: $error_url\n\n";
                $detailed_error_message .= "Stack Trace: $error_trace";

                Session::put('exception_message',$detailed_error_message);
                Session::put('exception_title', $error_title);

                return response()->view('bug-courier::errors.500', [], 500);
            }

            return $response;
    }
}
