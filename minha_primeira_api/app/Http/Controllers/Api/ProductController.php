<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function index(Request $request)
    {

        $products = $this->product;
        $productRepository = new ProductRepository($products, $request);

        if($request->has('conditions')){
            $productRepository->selectConditions($request->get('conditions'));
        }

        if($request->has('fields')){
            $productRepository->selectFilter($request->get('fields'));
        }

        // return response()->json($products);
        return new ProductCollection($productRepository->getResult()->paginate(10));
    }

    public function show($id)
    {
        $product = $this->product->find($id);

        // return response()->json($product);
        return new ProductCollection($product->paginate(10));
    }

    public function save(ProductRequest $request) 
    {
        $data = $request->all();
        $product = $this->product->create($data);

        return response()->json($product);
        
    }

    public function update(ProductRequest $request) 
    {
        $data = $request->all();
        $product = $this->product->find($data['id']);
        $product->update($data);

        return response()->json($product);
    }

    public function delete($id)
    {
        $product = $this->product->find($id);
        $product->delete();

        return response()->json(['data' => ['msg' => 'Produto removido com sucesso']]);
    }
}
