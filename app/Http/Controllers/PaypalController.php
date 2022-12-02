<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PaypalController extends Controller
{
    public function index() 
    {
        return view('payment');
    }

    public function bill(Request $request)
    {
        try{

            $response = $this->gateway->purchase([
                'amount'    => $request->input('payment'),
                'currency'  => config('paypal.currency'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error')
            ])->send();

            if($response->isRedirect()) {
                $response->redirect();
            } else {
                $response->getMessage();
            }

        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerId   = $request->input('PayerID');

        if(paymentId && $payerId) {
            $transaction = $this->gateway->completePurchase([
                'payer_id'             => payerId,
                'transactionReference' => $paymentId
            ]);

            $response = $transaction->send();

            if($response->isSuccessful()) {

                $responseData = $response->getData();

                $payment = new Payment;
                $payment->payment_id = $responseData['id'];
                $payment->payer_id = $responseData['payer']['payer_info']['payer_id'];
                $payment->payer_email = $responseData['payer']['payer_info']['email'];
                $payment->amount = $responseData['transactions'][0]['amount']['total'];
                $payment->currency = config('paypal.currency');
                $payment->payment_status = $responseData['id'];
                $payment->save();

            } else {
                return $response->getMessage();
            }

        } else {
            return 'Transaction was declined.';
        }
    }

    public function error()
    {
        return 'The user cancelled the payment.';
    }

    public function login() 
    {
        $response = Http::get("https://www.sandbox.paypal.com/signin/authorize?flowEntry=static&client_id=" . config('paypal.client_id') . "&scope=openid profile email&redirect_uri=http://127.0.0.1:8000/paypal/token&response_type=code");

        return $response;
    }
}
