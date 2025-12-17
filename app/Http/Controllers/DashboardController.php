<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Show the user's dashboard.
     */
    public function index(Request $request): \Inertia\Response
    {
        try {
            $balanceFormatted   = number_format(auth()->user()?->balance ?? 0, 2);
            return \inertia('Dashboard', compact('balanceFormatted'));
        }
        catch (\Exception) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
