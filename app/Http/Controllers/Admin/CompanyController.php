<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('name')->paginate(10);
        return view('admin.companies.index', compact('companies'));
    }

    public function create()
    {
        return view('admin.companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required','string','min:2','max:150','unique:companies,name'],
            'website' => ['nullable','string','max:255'],
            'email' => ['nullable','email','max:255'],
            'location' => ['nullable','string','max:255'],
            'logo_path' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $slug = $this->uniqueSlug($validated['name']);
        Company::create(array_merge($validated, ['slug' => $slug]));

        return redirect()->route('admin.companies.index')->with('status', 'Company created.');
    }

    public function edit(Company $company)
    {
        return view('admin.companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => ['required','string','min:2','max:150', Rule::unique('companies','name')->ignore($company->id)],
            'website' => ['nullable','string','max:255'],
            'email' => ['nullable','email','max:255'],
            'location' => ['nullable','string','max:255'],
            'logo_path' => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
        ]);

        $slug = $company->name === $validated['name'] ? $company->slug : $this->uniqueSlug($validated['name'], $company->id);
        $company->update(array_merge($validated, ['slug' => $slug]));

        return redirect()->route('admin.companies.index')->with('status', 'Company updated.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('admin.companies.index')->with('status', 'Company deleted.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;
        while (
            Company::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }
        return $slug;
    }
}

