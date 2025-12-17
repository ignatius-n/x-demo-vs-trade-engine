<?php

namespace App\Jobs;

use App\Enums\StatusOptionsEnum;
use App\Models\Order;
use App\Services\MatchingEngineService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class InitializeOrderMatchingEngineJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $orderId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        try {
            $engine = new MatchingEngineService();
            $order  = Order::find($this->orderId);
            if (!$order || $order->status !== StatusOptionsEnum::OPEN->value) {
                return;
            }
            $engine->match($order);
        }
        catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
