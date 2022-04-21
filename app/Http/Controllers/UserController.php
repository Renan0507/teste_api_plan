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
        $image_link = Storage::url($file_diretory);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->setPhone($validated['phone']);
        $user->image = $image_link;

        $user->save();

        return response()->json($user, 200);
    }

    public function read()
    {
        $users = User::all();

        if($users->count() <= 0) {
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
        if(!empty($validated['password'])) 
            $user->password = Hash::make($validated['password']);
        $user->setPhone($validated['phone']);

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

        return response()->json($user, 200);
    }
}
