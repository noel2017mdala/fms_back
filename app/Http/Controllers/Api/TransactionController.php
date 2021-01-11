<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TransactionModel as Transaction;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    public function index(){
       if(auth()->user()){
        $transaction =  Transaction::limit('3')->get();
        if(!empty($transaction)){

       return response()->json([
            'state' => 1,
            'transaction' => $transaction,
            ], 200);
    } else{

        return response()->json([
            'state' => 0,
            'msg' => '',
        ], 404);
    }
       }else{
        return response()->json([
            'msg' => 'page not found',
        ], 404);
    }

    }

    public function getEarnings(Request $request){
        
        if(auth()->user()){

            $earnings = Transaction::where('transaction_type', 0)->limit(3)->get();
            // return $earnings;
           if(!empty($earnings)){
            return response()->json([
                'state' => 1,
                'transaction' => $earnings,
                ], 200);
        } else{
    
            return response()->json([
                'state' => 0,
                'msg' => '',
            ]);
        }

        }else{
            return response()->json([
                'msg' => 'page not found',
            ], 404);
        }
      
}

public function getExpenses(){
   if(auth()->user()){
    $expense = Transaction::where('transaction_type', 1)->limit(3)->get();
    if(!empty($expense)){
        return response()->json([
            'state' => 1,
            'transaction' => $expense,
        ], 200);
    }else{
        
        return response()->json([
            'state' => 0,
            'msg' => ''
        ]);

        }

        }else{
            return response()->json([
                'msg' => 'page not found',
            ], 404);
        }
   }

}