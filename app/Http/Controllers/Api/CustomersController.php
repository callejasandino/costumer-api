<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customer::all();

        return response()->json([
            'customers' => $customers
        ]);
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'age' => $request->input('age'),
            'dob' => $request->input('dob'),
            'email' => $request->input('email'),
        ]);

        return response()->json([
            'message' => "Customer $customer->first_name $customer->last_name created"
        ]);
    }

    public function update($customerId, UpdateCustomerRequest $request)
    {
        $customer = Customer::where('id', $customerId)->first();

        if(! $customer) {
            return response()->json([
                'error' => 'Customer Not found'
            ], 404);
        }

        $customer->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'age' => $request->input('age'),
            'dob' => $request->input('dob'),
            'email' => $request->input('email'),
        ]);

        return response()->json([
            'message' => "Customer $customer->first_name $customer->last_name updated"
        ]);
    }

    public function destroy($customerId)
    {
        $customer = Customer::where('id', $customerId)->first();

        $customer->delete();

        return response()->json([
            'message' => "Customer deleted"
        ]);
    }
}
