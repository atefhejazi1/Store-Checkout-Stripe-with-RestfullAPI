<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function storeId(): int
    {
        return auth()->user()->store->id;
    }

    public function index()
    {
        $products = Product::with('category')
                           ->where('store_id', $this->storeId())
                           ->latest()
                           ->get();

        return view('vendor.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gte:price',
            'status'        => 'required|in:active,draft,archived',
        ]);

        $data['store_id'] = $this->storeId();
        $data['image']    = $this->uploadImage($request);

        Product::create($data);

        return redirect()->route('vendor.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        $categories = Category::all();

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);

        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category_id'   => 'required|exists:categories,id',
            'price'         => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|gte:price',
            'status'        => 'required|in:active,draft,archived',
        ]);

        $oldImage = $product->image;
        $newImage = $this->uploadImage($request);

        if ($newImage) {
            $data['image'] = $newImage;
        }

        $product->update($data);

        if ($oldImage && $newImage) {
            Storage::disk('public')->delete($oldImage);
        }

        return redirect()->route('vendor.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);
        $product->delete();

        return redirect()->route('vendor.products.index')->with('success', 'Product deleted.');
    }

    private function authorizeProduct(Product $product): void
    {
        if ($product->store_id !== $this->storeId()) {
            abort(403);
        }
    }

    private function uploadImage(Request $request): ?string
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        return $request->file('image')->store('products', ['disk' => 'uploads']);
    }
}
