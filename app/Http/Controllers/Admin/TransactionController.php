<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Repositories\interfaces\DoctorRepository;
use App\Repositories\interfaces\CategoryRepository;
use App\Repositories\interfaces\TransactionRepository;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    protected $repo;
    protected $doctors;
    protected $categories;

    public function __construct(TransactionRepository $repo,
        DoctorRepository $doctors,
        CategoryRepository $categories
        ) {
         $this->repo = $repo;
         $this->doctors = $doctors;
         $this->categories = $categories;
    }

    
    public function index(){
        // $data['transactions'] = $this->repo->filters()->with('sender:id,name,phone', 'receiver:id,name')->orderBy('updated_at', 'desc')->paginate(20);
        $data['doctors'] = $this->doctors->get(['id', 'name'])->pluck('name', 'id');
        $data['users'] = Patient::get()->pluck('name', 'id');
        $data['categories'] = $this->categories->pluck('name_ar', 'id');

        return view('admin.transactions.transactions',$data);
    }

    public function transactions()
    {
        $transactions = $this->repo->filters()->with('sender:id,name,phone', 'receiver:id,name')->orderBy('updated_at', 'desc');
        return DataTables::of($transactions)->make(true);

    }

}
