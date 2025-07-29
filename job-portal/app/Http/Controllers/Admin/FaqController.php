<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the FAQs.
     */
    public function index()
    {
        $faqs = Faq::orderBy('order')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new FAQ.
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Store a newly created FAQ in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_published' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        // Set default for published status if not provided
        if (!isset($validatedData['is_published'])) {
            $validatedData['is_published'] = false;
        }

        Faq::create($validatedData);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ created successfully.');
    }

    /**
     * Show the form for editing the specified FAQ.
     */
    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Update the specified FAQ in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $validatedData = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'is_published' => 'boolean',
            'order' => 'required|integer|min:0',
        ]);

        // Set default for published status if not provided
        if (!isset($validatedData['is_published'])) {
            $validatedData['is_published'] = false;
        }

        $faq->update($validatedData);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ updated successfully.');
    }

    /**
     * Toggle the published status of the specified FAQ.
     */
    public function togglePublished(Faq $faq)
    {
        $faq->is_published = !$faq->is_published;
        $faq->save();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ status updated successfully.');
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ deleted successfully.');
    }

    /**
     * Reorder FAQs.
     */
    public function reorder(Request $request)
    {
        $validatedData = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'required|integer|exists:faqs,id',
        ]);

        foreach ($validatedData['ids'] as $index => $id) {
            Faq::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
