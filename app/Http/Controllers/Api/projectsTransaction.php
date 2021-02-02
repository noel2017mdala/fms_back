<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\projectsTransactionModel as Transactions;
use Illuminate\Support\Carbon;


class projectsTransaction extends Controller
{
    public function index(){
        return Transactions::all();
    }
    public function createTransaction(Request $request){
        // return $request->all();
        $createTransaction = Transactions::create([
            'transaction_name' => 'bought cement',
            'projects_id' => 1,
            'transaction_ammount' => 150000,
            'transaction_type' => 0,
            'transaction_by' => 100,
            'transaction_date' => Carbon::now(),
        ]);
        
        if($createTransaction){
            return responce()->json([
                'state' => 1,
                'msg' => 'transaction crated successfully'
             ]);
        }
    }
}
