<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::with('rol')->get();
    return response()->json($users);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $user = new User();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->rol_id = $request->input('rol_id');
    $user->password = Hash::make($request->input('password'));
    $user->company_id = $request->input('company_id');
    $user->save();
    return response()->json($user);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Module  $user
   * @return \Illuminate\Http\Response
   */
  public function show(User $user)
  {
    return response()->json($user);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Module  $user
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, User $user)
  {
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    //$user->password = Hash::make($request->input('password'));
    $user->rol_id = $request->input('rol_id');
    //$user->company_id = $request->input('company_id');
    $user->save();
    return response()->json($user);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Module  $user
   * @return \Illuminate\Http\Response
   */
  public function destroy(User $user)
  {
    $user->delete();
    return response()->json([], 204);
  }

  public function login(Request $request)
  {
    $username = $request->input('username');
    $password = $request->input('password');
    $user = User::where('name', '=', $username)->first();
    if (!$user) {
      return response()->json(['message'=>'El usuario no existe'],404);
    }
    if ($user->name !== $username || !Hash::check($password, $user->password)) {
      return response()->json(['message'=>'Credenciales incorrectas'], 401);
    }

    //$permission = new Permission();
    $user_permissions = Permission::with('module.parent')->where('rol_id', '=', $user->rol_id)->get();
    //$permission->getPermissionsByRol($user->rol_id);

    return response()->json([
      'id' => $user->id,
      'name' => $user->name,
      'email' => $user->email,
      'rol_id' => $user->rol_id,
      'company_id' => $user->company_id,
      'permissions' => $user_permissions
    ]);
  }
  public function passwordChange(Request $request,$id)
  {
    $user=User::find($id);
    $user->password=Hash::make($request->password);
    $user->save();
    return response()->json([],204);
  }
}
