<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PaypalController extends Controller
{
    public function index() 
    {
        $response = Http::get("https://www.sandbox.paypal.com/signin/authorize?flowEntry=static&client_id=" . config('paypal.client_id') . "&scope=openid profile email&redirect_uri=http://127.0.0.1:8000/paypal/token&response_type=code");

        return $response;
    }
}
