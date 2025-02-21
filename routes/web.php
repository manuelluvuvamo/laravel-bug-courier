<?php

namespace ManuelLuvuvamo\BugCourier;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemDto;
use ManuelLuvuvamo\BugCourier\Application\Services\Item\CreateItemService;

Route::group(['middleware' => [config('bug-courier.routes.middleware')], 'prefix' => config('bug-courier.routes.prefix')], function () {
    Route::post('report', function (Request $request, CreateItemService $use_case) {
        try {
            $title = $request->input('title');
            $observations = $request->input('observations');
            $error_message = Session::get('exception_message');
            $description = "Observations: $observations\n\n$error_message";

            $data = new CreateItemDto($title, $description, []);
            $use_case->execute($data);

            Session::forget('exception_message');
            Session::forget('exception_title');

            return Redirect::back()->with('success', 'Report sent successfully');
        } catch (\Exception $e) {
            return Redirect::back()->with('error', 'An error occurred while sending the report');
        }
    })->name('bug-courier.report');
});
