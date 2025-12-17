<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Jobs\InitializeOrderMatchingEngineJob;
use App\Services\OrderPlacementService;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;
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
    public function store(StoreOrderRequest $request): JsonResponse
    {
        try {
            $orderPlacementService  = new OrderPlacementService(new WalletService());
            $order                  = $orderPlacementService->place(
                user: auth()->user(),
                symbol: $request->symbol,
                side: $request->side,
                price: $request->price,
                amount: $request->amount
            );
            /**
             * Async matching avoids blocking HTTP request
             * and mirrors real exchange architectures.
             */
            InitializeOrderMatchingEngineJob::dispatch($order->id);
            return response()->json([
                'message'   => 'Order placed successfully',
                'order'     => $order->fresh(),
            ], Response::HTTP_CREATED);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Error processing your request',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
