<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;
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
        $realState = $this->realState->paginate(10);

        return response()->json($realState, 200);
    }

    public function store(RealStateRequest $request )
    {
        $data = $request->all();

        try{
            $realState = $this->realState->create($data);
            return response()->json($realState, 201);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $realState = $this->realState->find($id);

        if(!$realState){
            return response()->json(['error' => 'Imóvel não encontrado'], 404);
        }

        return response()->json($realState, 200);
    }

    public function update(RealStateRequest $request, $id)
    {
        $realState = $this->realState->find($id);

        if(!$realState){
            return response()->json(['error' => 'Imóvel não encontrado'], 404);
        }

        $data = $request->all();

        try{
            $realState->update($data);
            return response()->json($realState, 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        $realState = $this->realState->find($id);

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
