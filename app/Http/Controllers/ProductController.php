<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function search($keywords)
    {
        $product = Product::where('name', 'like', '%' . $keywords . '%')->get();
        return $product;
    }

    public function index()
    {
        $products = Product::all();

        return new ProductResource($products);
    }

    public function dataProduct()
    {
        return [
            'name' => request('name'),
            'slug' => Str::slug(request('name')),
            'desc' => request('desc'),
            'price' => request('price'),
        ];
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($this->dataProduct());
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }



    public function update(ProductRequest $request, Product $product)
    {
        $product->update($this->dataProduct());
        return new ProductResource($product);
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => 'success'
        ]);
    }
}
