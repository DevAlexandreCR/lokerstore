<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if ($request->has('query')) {
            $query = $request->input('query');
            return $this->searchUser($query);
        } else {
            return view('admin.users.index', [
                'users' => $this->user->paginate(12)
            ]);
        }
    }

    /**
     * Display the specified user.
     *
     * @param  User  $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  User  $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(UserRequest $request, User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'input_name' => $request->input('input_name') // variable que le dice a la vista cual input mostrar
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \App\Http\Request\UserRequest  $request
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());

        return redirect( route('users.show', ['user' => $user->id]))->with('user-updated', 'User has been updated success');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect("admin/users")->with('user-deleted', "User has been deleted success");
    }

    /**
     * Funcion busca un usuario en la tabla users
     * y busca coincidencias en los campos name, lastname, email y phone
     *
     * @param string $query texto a buscar
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View Retorna una vista con los resultados de la busqueda cargados
     */
    private function searchUser(string $query)
    {
        $user = User::FindUserByNameEmailOrPhone($query);
        if ($user->count() > 0) {
            return view('admin.users.index', [
                'users' => $user->paginate(9),
                'user_found' => "Mostrando resultados para: $query"
            ]);
        } else {
            return view('admin.users.index', [
                'users' => $user->paginate(9),
                'user_not_found' => "No se encontraron resultados para $query"
            ]);
        }
    }
}
