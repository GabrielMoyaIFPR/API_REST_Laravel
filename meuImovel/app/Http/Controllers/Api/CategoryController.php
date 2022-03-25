<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->paginate(10);

        return response()->json($categories, 200);
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        try{
            $category = $this->category->create($data);
            return response()->json($category, 201);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function show($id)
    {
        $category = $this->category->find($id);

        if(!$category){
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }

        return response()->json($category, 200);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = $this->category->find($id);

        if(!$category){
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }

        $data = $request->all();

        try{
            $category = $this->category->find($id)->update($data);
            return response()->json($category, 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        $category = $this->category->find($id);

        if(!$category){
            return response()->json(['error' => 'Categoria não encontrada'], 404);
        }

        try{
            $category = $this->category->find($id)->delete();
            return response()->json($category, 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function realStates($id){
        
        try{
            $category = $this->category->findOrFail($id);
            return response()->json(['data'=> $category->realStates], 200);
            
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
