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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        if($users->count() <= 0) {
            throw new NotFoundHttpException('Nenhum usuário encontrado');
        }

        return response()->json($users, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
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
        $user->image = $file_diretory;

        $user->save();

        $user->image = $image_link;

        return response()->json($user, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if(!empty($validated['password'])) 
            $user->password = Hash::make($validated['password']);
        $user->setPhone($validated['phone']);
        
        $image_link = $user->image;
        
        if($request->hasFile('image')) {

            Storage::disk('public')->delete($user->image);

            $file = $request->file('image');
            $file_diretory = $file->store('images');
            $image_link = Storage::url($file_diretory);

            $user->image = $file_diretory;
        }

        $user->save();

        $user->image = $image_link;

        return response()->json($user, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json($user, 200);
    }
}
