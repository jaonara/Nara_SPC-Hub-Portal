<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display all available products.
     */
    public function index()
    {
        $products = Product::with('user')
            ->where('status', 'available')
            ->latest()
            ->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'available';

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product posted successfully!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load([
            'user',
            'comments' => fn ($query) => $query->whereNull('parent_id')->with(['user', 'replies.user']),
        ]);

        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing a product.
     */
    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        return view('products.edit', compact('product'));
    }

    /**
     * Update a product.
     */
    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Mark product as sold.
     */
    public function markAsSold(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $product->update([
            'status' => 'sold',
        ]);

        return redirect()
            ->route('products.show', $product)
            ->with('success', 'Product marked as sold!');
    }

    /**
     * Delete a product.
     */
    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully!');
    }
}