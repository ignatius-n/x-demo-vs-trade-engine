<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    //
    public function index(Request $request)
    {
        try {
            $assetOptions   = getAssetOptions();
            $sidesOptions   = getSideOptions();
            return \inertia('Orders/Index', compact('assetOptions', 'sidesOptions'));
        }
        catch (\Exception) {
            abort(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle order placement (BUY / SELL)
     */
    public function store(StoreOrderRequest $request)
    {
        try {
            dd($request->all());
        }
        catch (\Exception) {
            return \response()->json([], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
