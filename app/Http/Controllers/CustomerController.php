<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $errorMessages = [
            'cpf.unique' => 'Este CPF já está cadastrado',
            'cpf.size' => 'O campo de CPF esta incompleto'
        ];

        $validatedData = $request->validate([
            'cpf' => 'required|unique:customers|size:14',
            'name' => 'required|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'address' => 'required|max:255',
            'state' => 'required|max:100',
            'city' => 'required|max:100',
        ], $errorMessages);

        Customer::create($validatedData);

        return redirect()->route('customers.create')->with('success', 'Cliente criado com sucesso!');
    }

    public function index(Request $request)
    {
        if(empty($request->all())) {
            return view('customers.index', ['customers' => []]);
        };

        $validatedData = $request->validate([
            'cpf' => 'nullable|max:14',
            'name' => 'nullable|max:255',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:M,F',
            'state' => 'nullable|max:100',
            'city' => 'nullable|max:100',
        ]);

        $customers = Customer::query();

        foreach($validatedData as $key => $value) {
            if($value) {
                $customers = $customers->where($key, 'like', "%{$value}%");
            }
        }

        //$customers = $customers->paginate(10);
        $customers = $customers->get();

        return view('customers.index', ['customers' => $customers]);
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {

        $validatedData = $request->validate([
            'cpf' => 'required', Rule::unique('customers')->ignore($customer->id),
            'name' => 'required|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:M,F',
            'address' => 'required|max:255',
            'state' => 'required|max:100',
            'city' => 'required|max:100',
        ]);

        $customer->fill($validatedData);
        $customer->save();

        return redirect()->route('customers.index')->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
