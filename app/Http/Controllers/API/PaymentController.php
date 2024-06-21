<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PaymentResource;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Payment;
use App\Models\PaymentDetails;
use Validator;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends BaseController
{

    // payment list
    public function index(): JsonResponse
    {
        $payments = Payment::all();
        
        return $this->sendResponse(PaymentResource::collection($payments), 'Payments retrieved successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $thisUser = Auth::user();

        $this->validate($request,[
            'date'         => 'required',
            'total_amount' => 'required',
        ]);
       
       $transaction_id = 'txn_' . time() . '_' . Str::random(8);
        $payment = new Payment();
        $payment->transaction_id = $transaction_id;
        $payment->total_amount   = $request->total_amount;
        $payment->date           =  date('Y-m-d', strtotime($request->date));
        $payment->narration      = $request->narration;
        $payment->createdBy      = $thisUser->id;
        $payment->status         = false;
        $payment->save();

        $items = ($request->items?$request->items:[]);
        $amount = ($request->amount?$request->amount:[]);
        for ($i = 0; $i < $items; $i++) {
            $paymentDetails = new PaymentDetails();
            $paymentDetails->transaction_id     = $transaction_id;
            $paymentDetails->item_id            = $items[$i];
            $paymentDetails->amount             = $amount[$i];
            $paymentDetails->save();
        }

       
       
        DB::commit();
        return $this->sendResponse(new PaymentResource($payment), 'Payment created successfully.');
    } catch (Exception $ex) {
        DB::rollBack();
        return $this->sendError('Please Try Again.',$ex->getMessage()); 
    }
    } 

    public function changeStatus(Request $request){

    }
}
