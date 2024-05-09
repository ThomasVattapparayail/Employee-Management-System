<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use Brick\Math\BigInteger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Integer;

class CompanyController extends Controller
{
    public function index()
    {
        $companys = Company::all();
        return view('company.home', compact('companys'));
    }

    public function create()
    {
       return view('company.createCompany'); 
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'nullable',
            'logo' => 'nullable|image|mimes:png,jpeg,jpg',
            'website' => 'nullable',
            
        ]);

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageDimensions = getimagesize($image->getPathname());
            $minWidth = 100;
            $minHeight = 100;
            if ($imageDimensions[0] < $minWidth || $imageDimensions[1] < $minHeight) {
                return redirect()->back()->withErrors(['logo' => "The logo must be at least {$minWidth}x{$minHeight} pixels."]);
            }
        }

       $company= new Company();
       $company->name=$request->name;
       $company->email=$request->email;
       $company->website=$request->website;

       if ($request->hasFile('logo'))
        {
            $logoPath = $request->file('logo')->store('logos', 'public'); 
            $company->logo = $logoPath;
        }

        $company->save();

        return redirect()->route('home')->with('success', 'company created successfully.');
    }

    public function edit(Company $company)
    {
        return view('company.editcompany', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'nullable',
            'logo' => 'nullable|image|mimes:png,jpeg,jpg',
            'website' => 'nullable',
        ]);

        
    if ($request->hasFile('logo')) {
        $image = $request->file('logo');
        $imageDimensions = getimagesize($image->getPathname());
        $minWidth = 100;
        $minHeight = 100;
        if ($imageDimensions[0] < $minWidth || $imageDimensions[1] < $minHeight) {
            return redirect()->back()->withErrors(['logo' => "The logo must be at least {$minWidth}x{$minHeight} pixels."]);
        }
    }

    $company->update($validatedData);

    if ($request->hasFile('logo')) {
        if ($company->logo) {
            Storage::disk('public')->delete($company->logo);
        }
        $logoPath = $request->file('logo')->store('logos', 'public');
        $company->update(['logo' => $logoPath]);
    }

        return redirect()->route('home')->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('home')->with('success', 'Inventory item deleted successfully.');
    }

    public function companyApi()
    {
        
        $company = Company::all();
        return response()->json($company);
    }
  

}
