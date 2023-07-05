<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::query();

        $filters = ['name', 'price', 'quantity', 'category', 'status'];
        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                if ($filter === 'category') {
                    $query->whereHas('categories', function ($categoryQuery) use ($request) {
                        $categoryQuery->where('category_id', $request->input('category'));
                    });
                } else {
                    $query->where("products.$filter", $request->input($filter));
                }
            }
        }

        $sortField = $request->input('sort_field', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortField, $sortOrder);

        $products = $query->paginate(10);

        return view('product.index', compact('products'))->with('categories', Category::all());
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product = new Product();
        $product->fill($request->all());
        $imageName = time().'.'.$request->image->extension();
        $request->image->storeAs('images', $imageName);
        $product->image = $imageName;
        $product->save();
        $product->categories()->sync($request->input('categories'));

        return redirect()->route('product.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $validated = $request->validated();
        $product = Product::findOrFail($id);

        $product->fill($request->only('name', 'price', 'quantity', 'status'));

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            Storage::delete('public/images/' . $product->image);
            $product->image = $imageName;
        }
        $product->save();
        $product->categories()->sync($request->input('categories', []));
        return redirect()->route('product.index')
            ->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')
            ->with('success', 'Product deleted successfully.');
    }
}
