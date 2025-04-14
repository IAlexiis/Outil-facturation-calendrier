<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Auth::user()->companies;
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    if (!Auth::check()) {
        abort(401, 'Non connecté');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'adress' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'siret' => 'nullable|string|max:14',
    ]);

    $company = Company::create([
        'name' => $request->name,
        'adress' => $request->adress,
        'email' => $request->email,
        'siret' => $request->siret,
        'user_id' => Auth::id(), 
    ]);

    return redirect()->route('companies.index')->with('success', 'Entreprise ajoutée avec succès.');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        
        $this->authorizeCompany($company);
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $this->authorizeCompany($company);

        $request->validate([
            'name' => 'required|string|max:255',
            'adress' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'siret' => 'nullable|string|max:14',
        ]);

        $company->update($request->all());

        return redirect()->route('companies.index')->with('success', 'Entreprise mise à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $this->authorizeCompany($company);
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Entreprise supprimée.');
    }

    public function authorizeCompany(Company $company)
    {
        if($company->user_id !== Auth::id())
        {
            abort(403);
        }
    }
}
