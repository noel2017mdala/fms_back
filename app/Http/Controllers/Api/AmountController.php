<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAmount;
use App\Models\Amount;
use Illuminate\Support\Carbon;

class AmountController extends Controller
{
    public function index(int $id){
        
         $amountTransaction = UserAmount::where('user_id', $id)->get();
        $amount = Amount::where('user_id', $id)->get();

        return response()->json([
            'state' => 1,
            'amount_transaction' =>  $amountTransaction,
            'amount' => $amount
        ]); 

   
    }

    
    public function create_transaction(Request $request){
        
      

        // $createProject = Amount::create([
        //     'user_id' =>1,
        //     'Amount' =>  0,
        //     'transaction_date'  => Carbon::now(),
        // ]);
    
        //  return;
        $user_id  = $request['id'];
        $data =  Amount::where('user_id', $user_id)->get();
        

        $prevBalance = 0;
        foreach($data as $value){
            $prevBalance =  $value;
        }
        

        $createProject = UserAmount::create([
            'user_id' =>1,
            'prev_Amount' =>  $prevBalance['Amount'],
            'date_value' => 'Tue',
            'transaction_date'  => Carbon::now(),
        ]);

        if($createProject){

        $createAmount = Amount::find($user_id);
        $createAmount->update(['Amount' => 200]);

        $amountTransaction = UserAmount::all();
        $amount = Amount::all();

     return response()->json([
         'state' => 1,
         'userAmount' =>  $amountTransaction,
         'amount' => $amount,
     ]);
    }
}

}
