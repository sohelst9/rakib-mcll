<?php

namespace App\Http\Controllers\payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UniquepayController extends Controller
{
    // Define API keys and host directly
    protected $api_key = 'GVr1uKkC7LHT6';
    protected $secret_key = '17319845';
    protected $host_name = 'playmcll.com';

    //--payment
    public function payment()
    {
        return view('payment');
    }


    //--payment_create
    public function payment_create(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'cus_name' => 'required|string|max:50',
            'cus_email' => 'required|email|max:50',
            'amount' => 'required|numeric',
        ]);

        // Prepare payment request data
        $data = [
            'cus_name' => $validated['cus_name'],
            'cus_email' => $validated['cus_email'],
            'amount' => $validated['amount'],
            'success_url' => route('uniquepay.payment.success'),
            'cancel_url' => route('uniquepay.payment.cancel'),
        ];

        // Call the UniquePay BD API to create a payment request
        $response = Http::withHeaders([
            'app-key' => $this->api_key,
            'secret-key' => $this->secret_key,
            'host-name' => $this->host_name,
        ])->asForm()->post('https://pay.uniquepaybd.com/request/payment/create', $data);

        dd($response->json());

        // Handle the response from the payment gateway
        if ($response->successful()) {
            // Successful response from UniquePay BD
            return response()->json([
                'status' => 'success',
                'data' => $response->json(),
            ]);
        } else {
            // If the request fails
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create payment request.',
                'details' => $response->json(),
            ], 400);
        }
    }


    //--payment_success
    public function payment_success(Request $request)
    {
        info($request->all());
        return $request->all();
    }

    //--payment_cancel
    public function payment_cancel(Request $request)
    {
        info($request->all());
        return $request->all();
    }
}
