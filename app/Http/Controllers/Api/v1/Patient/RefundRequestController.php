<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Helpers\Responder;
use App\Http\Controllers\Controller;
use App\Http\Requests\RefundRequest\StoreRefundRequestRequest;
use App\Http\Resources\RefundRequest\RefundRequestResource;
use App\Repositories\interfaces\RefundRequestRepository;
use Illuminate\Http\Request;

class RefundRequestController extends Controller
{
    public function __construct(public RefundRequestRepository $repo)
    {
        $this->middleware(['auth:api']);
    }

    /**
     * @return Responder
     */
    public function index(Request $request): Responder
    {
        return responseJson(
            RefundRequestResource::collection(
                $request
                    ->user()
                    ->refundRequests()
                    ->with('transaction')
                    ->paginate(10),
            ),
            __('Loaded Successfully'),
        );
    }

    /**
     * @param StoreRefundRequestRequest $request
     * @return Responder
     */
    public function create(StoreRefundRequestRequest $request): Responder
    {
        $refund_request = $request
            ->user()
            ->refundRequests()
            ->updateOrCreate($request->only('transaction_id'));

        return responseJson(
            new RefundRequestResource($refund_request->load('transaction')),
            __('Request Sent Successfully Successfully'),
        );
    }
}
