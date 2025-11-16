<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
            $validated = $request->validate([
                'name' => ['required','string','min:2','max:100', 'unique:categories,name'],
            ]);

            $name = $validated['name'];
            $slug = $this->uniqueSlug($name);

            Category::create([
                'name' => $name,
                'slug' => $slug,
            ]);

            return redirect()
                ->route('admin.categories.index')
                ->with('status', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        // Redirect to edit for now
        return redirect()->route('admin.categories.edit', $category);
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required','string','min:2','max:100',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],
            'slug' => [
                'required','string','min:2','max:120',
                Rule::unique('categories', 'slug')->ignore($category->id),
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            ],
        ]);

        $name = $validated['name'];
        $slug = \Illuminate\Support\Str::slug($validated['slug']);

        $category->update([
            'name' => $name,
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Category deleted.');
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 2;
        while (
            Category::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i;
            $i++;
        }
        return $slug;
    }
}
