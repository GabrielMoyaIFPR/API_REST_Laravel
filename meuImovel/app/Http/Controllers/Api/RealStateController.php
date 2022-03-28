<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;
use App\Models\User;
use Illuminate\Http\Request;

class RealStateController extends Controller
{

    private $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index()
    {
        $realState = auth('api')->user()->real_state();

        return response()->json($realState->paginate(10), 200);
    }

    public function store(RealStateRequest $request )
    {
        $data = $request->all();
        $images = $request->file('images');

        try{
            $data['user_id'] = auth('api')->user()->id();
            $realState = $this->realState->create($data);
            if(isset($data['categories']) && count($data['categories'])){
                $realState->categories()->sync($data['categories']);
            }

            if($images){
                $imagesUploaded = [];
                foreach ($images as $image){
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json($realState, 201);

        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function show($id)
    {
        $realState = auth('api')->user()->real_state()->with('photos')->find($id);

        if(!$realState){
            return response()->json(['error' => 'Imóvel não encontrado'], 404);
        }

        return response()->json($realState, 200);
    }

    public function update(RealStateRequest $request, $id)
    {
        $realState =  auth('api')->user()->real_state()->find($id);

        if(!$realState){
            return response()->json(['error' => 'Imóvel não encontrado'], 404);
        }

        $data = $request->all();
        $images = $request->file('images');

        try{
            $realState->update($data);
            if(isset($data['categories']) && count($data['categories'])){
                $realState->categories()->sync($data['categories']);
            }
            if($images){
                $imagesUploaded = [];
                foreach ($images as $image){
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => false];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

            return response()->json($realState, 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        $realState =  auth('api')->user()->real_state()->find($id);

        if(!$realState){
            return response()->json(['error' => 'Imóvel não encontrado'], 404);
        }

        try{
            $realState->delete();
            return response()->json(['success' => 'Imóvel removido com sucesso'], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }
}
