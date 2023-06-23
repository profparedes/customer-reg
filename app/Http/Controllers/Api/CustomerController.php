<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CustomerResource::collection(Customer::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'cpf' => 'required|unique:customers,cpf',
            'birth_date' => 'required|date',
            'gender' => ['required', Rule::in(['M', 'F'])],
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
        ]);

        $customer = Customer::create($validated);

        return response()->json($customer, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            return new CustomerResource($customer);
        }

        return response()->json(['error' => 'Customer not found'], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::find($id);

        if($customer) {
            $validated = $request->validate([
                'name' => 'required',
                'cpf' => ['required', Rule::unique('customers')->ignore($customer->$id)],
                'birth_date' => 'required|date',
                'gender' => ['required', Rule::in(['M', 'F'])],
                'address' => 'required',
                'state' => 'required',
                'city' => 'required',
            ]);

            $customer->update($validated);

            return response()->json($customer);
        }

        return response()->json(['error' => 'Customer not found'], 404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);

        if ($customer) {
            $customer->delete();
            return response()->json(['message' => 'Customer deleted'], 204);
        }

        return response()->json(['error' => 'Customer not found'], 404);
    }
}
