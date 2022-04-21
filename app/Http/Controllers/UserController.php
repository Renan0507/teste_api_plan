<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function create(CreateUserRequest $request)
    {
        $validated = $request->validated();

        $file = $request->file('image');
        $file_diretory = $file->store('images');
        
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->phone = $validated['phone'];
        $user->image = $file_diretory;

        $user->save();

        return response()->json($user, 200);
    }

    public function read()
    {
        $users = User::paginate(20);

        if(empty($users['data'])) {
            throw new NotFoundHttpException('Nenhum usuário encontrado');
        }

        return response()->json($users, 200);
    }

    public function findById($id)
    {
        $user = User::find($id);

        if(!$user) {
            throw new NotFoundHttpException('Usuário não encontrado');
        }

        return response()->json($user, 200);
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::find($id);

        if(!$user) {
            throw new NotFoundHttpException('Usuário não encontrado');
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->phone = $validated['phone'];

        if($request->hasFile('image')) {

            Storage::disk('public')->delete($user->image);

            $file = $request->file('image');
            $file_diretory = $file->store('images');

            $user->image = $file_diretory;
        }

        $user->save();

        return response()->json($user, 200);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if(!$user) {
            throw new NotFoundHttpException('Usuário não encontrado');
        }

        $user->delete();

        return response()->json('Usuário '.$id.' deletado com sucesso', 200);
    }
}
