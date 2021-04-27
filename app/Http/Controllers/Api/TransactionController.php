<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserAmount;
use App\Models\Amount;
use App\Models\TransactionModel as Transaction;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request, $param ='', $id = ''){

        /*
        checks if the user is authenticated
        */
       if(auth()->user()){
        if(!empty($param && $id)){

            if($param === 'limit'){

        //get transactions with a limit of 2
        $transaction =  Transaction::where('transaction_by', $id)
        ->orderBy('id', 'desc')
        ->limit(3)
        ->get();
        
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
            }
        }
            /*
                Gets all transactions made by that user
                */

         if($param === 'all' && !empty($id)){
            
            $transaction =  Transaction::where('transaction_by', $id)->get();
        
            return response()->json([
                'state' => 1,
                'transactions' => $transaction,
            ]);
        }else{
            return response()->json([
                'msg' => 'page not found',
            ], 404);
        }
       }
       
       else{
        return response()->json([
            'msg' => 'page not found',
        ], 404);
    }

    } 
    public function createTransaction(Request $request){

      
        if(auth()->user()){
       
         $validate = $request->validate([
            'transaction_name' => 'required',
            'transaction_ammount' => 'required',
            'transaction_type'     => 'required',
            'transaction_by' => 'required'
    
        ]);
        $checkTransactionType = $request->all();
        
        if($validate){

            if($checkTransactionType['transaction_type'] === 'income'){
                
                $createTransaction = Transaction::create([
                    'transaction_name' => $request->transaction_name,
                    'transaction_ammount' => $request->transaction_ammount,
                    'transaction_type' => 0,
                    'transaction_by' => $request->transaction_by,
                    'transaction_date' => Carbon::now(),
                ]);
                
                //update the current users balance

                $user_id = $request->transaction_by;
                $data =  Amount::where('user_id', $user_id)->get();
                $prevBalance = 0;

                foreach($data as $value){
                    $prevBalance =  $value['Amount'];
                }

                $createAmount = Amount::find($user_id);
                $createAmount->update(['Amount' => $prevBalance + $request->transaction_ammount]);

                $createUserAmount = UserAmount::create([
                    'user_id' =>$user_id,
                    'prev_Amount' =>  $prevBalance,
                    'transaction_id' => $createTransaction['id'],
                    'date_value' => Date('D'),
                    'transaction_date'  => Carbon::now(),
                ]);


                if($createTransaction && $createUserAmount){
                    return response()->json([
                        'state' => 1,
                        'msg' => 'transaction created successfully'
                     ]);
                }

            }else if($checkTransactionType['transaction_type'] === 'expenditure'){

                       //update the current users balance
                
                       $user_id = $request->transaction_by;
                       $data =  Amount::where('user_id', $user_id)->get();
                       $prevBalance = 0;
       
                       foreach($data as $value){
                           $prevBalance =  $value['Amount'];
                       }
                    if($prevBalance - $request->transaction_ammount > 0){

                        $createTransaction = Transaction::create([
                            'transaction_name' => $request->transaction_name,
                            'transaction_ammount' => $request->transaction_ammount,
                            'transaction_type' => 1,
                            'transaction_by' => $request->transaction_by,
                            'transaction_date' => Carbon::now(),
                        ]);
                        
        
                        $createAmount = Amount::find($user_id);
                        $createAmount->update(['Amount' => $prevBalance - $request->transaction_ammount]);
                        
                        $createUserAmount = UserAmount::create([
                            'user_id' =>$user_id,
                            'prev_Amount' =>  $prevBalance,
                            'transaction_id' => $createTransaction['id'],
                            'date_value' => Date('D'),
                            'transaction_date'  => Carbon::now(),
                        ]);
        
                        if($createTransaction && $createUserAmount){
                            return response()->json([
                                'state' => 1,
                                'msg' => 'transaction created successfully'
                             ]);
                        }
                    }else{

                        return response()->json([
                            'state' => 0,
                            'msg' => 'Failed to create transaction'
                        ], 201);
                    }
                
            }else{
                return response()->json([
                    'state' => 0,
                    'msg' => 'Failed to create transaction',
                 ]);
            }
           

        }
    }   else{
        return response()->json([
            'msg' => 'page not found',
        ], 404);
    }
       
    }

    public function getEarnings($id){
        
        if(auth()->user()){

            if(!empty($id)){
//demo
                $earnings = Transaction::where([
                    'transaction_type'=> 0,
                    'transaction_by' => $id,
                ])
                ->orderBy('id', 'desc')
                ->limit(3)
                ->get();
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
}

    public function getExpenses($id){

        if(auth()->user()){
            if(!empty($id)){
                $expense = Transaction::where([
                    'transaction_type'=> 1,
                    'transaction_by' => $id,
                ])
                ->orderBy('id', 'desc')
                ->limit(3)->get();
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

       public function deleteTransaction(Request $request){

        //check if user is authenticated
        if(auth()->user()){
        
        //gets transaction type and users balance
        $getTransactionType = Transaction::find($request->id);
        $Balance = Amount::where('user_id', $request->userData['id'])->get();

        $userBalance = 0;
        foreach($Balance as $getBalance){
            $userBalance  = $getBalance['Amount'];
        }

        // checks if the transaction type is an income
        if($getTransactionType->transaction_type === 0){
        
            
            if($userBalance - $getTransactionType->transaction_ammount >= 0){
                
                $createAmount = Amount::find($request->userData['id']);
                $createAmount->update(['Amount' => $userBalance - $getTransactionType->transaction_ammount]);
                $getTransaction = DB::delete('delete from User_Amount_transactions where user_id = ? AND transaction_id = ?', [$request->userData['id'],$request->id]);
                $getTransactionType->delete();
    
                return response()->json([
                    'state' => 1,
                    'msg' => 'activity deleted'
                ], 201);

            }else{

                return response()->json([
                    'state' => 0,
                    'msg' => 'Failed to delete activity'
                ], 201);
            }
           
            
            // checks if the transaction type is an expenditure
        }else if($getTransactionType->transaction_type === 1){
           
                $createAmount = Amount::find($request->userData['id']);
                $createAmount->update(['Amount' => $userBalance + $getTransactionType->transaction_ammount]);
                $getTransaction = DB::delete('delete from User_Amount_transactions where user_id = ? AND transaction_id = ?', [$request->userData['id'],$request->id]);
                $getTransactionType->delete();
    
                return response()->json([
                    'state' => 1,
                    'msg' => 'activity deleted'
                ], 201);
                
        }

        }  else{
            return response()->json([
                'state' => 0,
                'msg' => '404'
            ], 404);
        }
       }
}