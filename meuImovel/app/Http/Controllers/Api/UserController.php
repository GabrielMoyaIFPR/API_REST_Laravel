<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function index()
    {
        $user = $this->user->paginate(10);
        
        return response()->json($user, 200);
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        if(!$request->has('password') || !$request->get('password')){
            $message = new ApiMessages('Senha não pode ser nula');
            return response()->json($message->getMessage(), 401);
        }

        Validator::make($data, [
            'mobile_phone' => 'required',
            'phone' => 'required',
        ])->validate();

        try{
            $data['password'] = bcrypt($data['password']);

            $user = $this->user->create($data);
            $user->profile()->create([
                'phone' => $data['phone'],
                'mobile_phone' => $data['mobile_phone']
            ]);

            return response()->json($user, 201);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function show($id)
    {
        $user = $this->user->with('profile')->find($id);
        $user->profile->social_networks = unserialize($user->profile->social_networks);

        if(!$user){
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        return response()->json($user, 200);
    }

    public function update(UserRequest $request, $id)
    {
        $user = $this->user->find($id);

        if(!$user){
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $data = $request->all();
        
        if($request->has('password')){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        Validator::make($data, [
            'profile.mobile_phone' => 'required',
            'profile.phone' => 'required',
        ])->validate();

        try{
            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);

            $user->update($data);
            
            $user->profile()->update($profile);

            return response()->json($user, 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }

    public function destroy($id)
    {
        $user = $this->user->find($id);

        if(!$user){
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        try{
            $user->delete();
            return response()->json(['success' => 'Usuário deletado com sucesso'], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 400);
        }
    }
}
