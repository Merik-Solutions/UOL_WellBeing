<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Transaction;
use App\Models\WithdrawRequest;
use App\Repositories\interfaces\WithdrawRequestRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class WithdrawRequestController extends Controller
{
    public $repo;

    public function __construct(WithdrawRequestRepository $repository)
    {
        $this->repo = $repository;
    }

    public function index()
    {
        $withdraw_requests = $this->repo->ofDoctor(auth()->id())->paginate(10);

        $wallet = auth()->user()->wallet;



        $waiting_money = auth()->user()->getWaitingMoney();
        return responseJson(
            [
                'finished_money_total' => round($wallet, 1),
                'waiting_money_total' => round($waiting_money, 1),
                'requests' => $withdraw_requests,
            ],
            __('Loaded Successfully'),
        );
    }

    public function waiting()
    {
        $waiting_money = Transaction::query()
            ->forDoctors()
            ->ofReceiver(auth()->id())
            ->isWaiting()
            ->paginate(10);
        return responseJson($waiting_money, __('Loaded Successfully'));
    }

    public function finished()
    {
        $finished_money = Transaction::query()
            ->forDoctors()
            ->ofReceiver(auth()->id())
            ->isFinished()
            ->paginate(10);

        return responseJson($finished_money, __('Loaded Successfully'));
    }

    public function store(Request $request)
    {
        $inputs = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:1' /* 'max:'.auth()->user()->wallet */,
            ],
        ]);       

        $withdraw = $this->repo->updateOrCreate(
            [
                'doctor_id' => auth()->id(),
                'status' => WithdrawRequest::WAITING,
            ],
            $inputs,
        );
        return responseJson($withdraw, __('Saved Successfully'));
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => ['required|integer|exists:withdraw_requests,id'],
        ]);
        $this->repo->delete($request->id);
        return responseJson(null, __('Deleted Successfully'));
    }
}
