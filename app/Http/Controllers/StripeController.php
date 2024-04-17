<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Session;
use Exception;

class StripeController extends Controller
{
    public function processPayment(Request $req)
    {
        // Set your secret key
        Stripe\Stripe::setApiKey(env('STRIPE_SK'));
        // Get the payment token submitted by the form
        $token = $req->input('stripeToken');

        try {
            $customer = Stripe\Customer::create(array(

                "address" => [
                    "line1" => $req->address,
                    "postal_code" => $req->pcode,
                    "city" => $req->city,
                    "state" => $req->state,
                    "country" => $req->country,
                ],
                "email" => $req->email,
                "name" => $req->first_name,
                'source' => $req->stripeToken,
            ));
            // dd($customer->source);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        // try {
        //     $customer->sources->create(["source" => $token]);
        // } catch (Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500);
        // }
        // dd($customer);
        Stripe\Charge::create([
            "balance" => 100 * 100,
            "currency" => "usd",
            "customer" => $customer->id,
            "description" => "Test payment.",
            "shipping" => [
                "name" => $customer->name,
                "address" => [
                    "line1" => "510 Townsend St",
                    "postal_code" => $customer->pcode,
                    "city" => $customer->city,
                    "state" => $customer->city,
                    "country" => $customer->countryds,
                ],
            ]
        ]);
        return back();
    }
}
