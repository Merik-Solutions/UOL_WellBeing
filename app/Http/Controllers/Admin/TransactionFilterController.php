<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Repositories\interfaces\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionFilterController extends Controller
{
    private $repo;
    public function __construct(TransactionRepository $repo,)
    {
         $this->repo = $repo;
    }
    public function filter(Request $request){
        $start_date = $request->start_date ?? null;
        $end_date = $request->start_date ?? null;
        $filter = $request->filter ?? null;

        $query = Transaction::where('id','<>',null);

        if($filter && $filter !== 'All'){
            if ($request->filter == 'custom') {
                $start_date = $request->start_date;
                $end_date = $request->end_date;
            }
                $query = $this->filterResult($filter, $start_date, $end_date, $query);
                $data['transactions'] = $query->get();
            
        }else{
            $data['transactions'] = Transaction::get();
        }

       return view('admin.transactions._table',$data);
 }


    private function filterResult($filter, $start_date, $end_date, $query)
    {
        if ($filter == 'monthly') {
            $query = $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        } elseif ($filter == 'weekly') {
            $query = $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } else {
            $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
        }

        return $query;
    }
}
