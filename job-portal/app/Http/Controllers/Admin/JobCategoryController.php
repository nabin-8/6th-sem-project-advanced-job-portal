<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobCategory;
use Illuminate\Support\Str;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the job categories.
     */
    public function index()
    {
        $categories = JobCategory::withCount('jobs')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new job category.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created job category in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:job_categories',
            'description' => 'nullable|string',
        ]);

        // Generate slug from name
        $validatedData['slug'] = Str::slug($validatedData['name']);

        JobCategory::create($validatedData);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Job category created successfully.');
    }

    /**
     * Show the form for editing the specified job category.
     */
    public function edit(JobCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified job category in storage.
     */
    public function update(Request $request, JobCategory $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:job_categories,name,'.$category->id,
            'description' => 'nullable|string',
        ]);

        // Update slug if name has changed
        if ($category->name !== $validatedData['name']) {
            $validatedData['slug'] = Str::slug($validatedData['name']);
        }

        $category->update($validatedData);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Job category updated successfully.');
    }

    /**
     * Remove the specified job category from storage.
     */
    public function destroy(JobCategory $category)
    {
        // Check if this category has associated jobs
        if ($category->jobs()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category because it has associated jobs.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Job category deleted successfully.');
    }
}
