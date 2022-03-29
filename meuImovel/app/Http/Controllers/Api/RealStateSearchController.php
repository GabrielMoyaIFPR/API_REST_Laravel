<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use Illuminate\Http\Request;
use App\Repository\RealStateRepository;

class RealStateSearchController extends Controller
{
    private $realState;
    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index(Request $request)
    {
        $repository = new RealStateRepository($this->realState);

        if($request->has('conditions')){
            $repository->selectConditions($request->get('conditions'));
        }

        if($request->has('fields')){
            $repository->selectFilter($request->get('fields'));
        }

        $repository->setLocation($request->all(['state','city']));

        return response()->json(['data' => $repository->getResult()->paginate(10)], 200);
    }

    public function show($id)
    {
        try{
            $realState = $this->realState->with('addresses')->with('photos')->findOrFail($id);
            return response()->json(['data' => $realState], 200);

        }catch(\Exception $e){
            return response()->json([
                'error' => 'Não foi possível encontrar o imóvel.',
                'message' => $e->getMessage()
            ], 404);
        }
    }

}
