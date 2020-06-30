<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
     * @return \Illuminate\Http\Response
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRequest $request, User $user)
    {
        $p = '0';
        if ($request->has('p')) {
            $p = $request->input('p');
        }
        return view('admin.users.edit', [
            'user' => $user,
            'p' => $p
        ]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());

        return redirect("admin/users/$user->id")->with('updated', 'El usuario ha sido actualizado correctamente');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $email = $user->email;
        $user->delete();

        return redirect("admin/users")->with('deleted', "El usuario $email ha sido eliminado correctamente");
    }

    /**
     * Funcion busca un usuario en la tabla users
     * y busca coincidencias en los campos name, lastname, email y phone
     *
     * @param string $query texto a buscar
     * @return View Retorna una vista con los resultados de la busqueda cargados
     */
    private function searchUser(string $query)
    {
        $user = User::where(function ($q) use ($query) {
            $q
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('lastname', 'like', '%' . $query . '%')
            ->orWhere('email', 'like', '%' . $query . '%')
            ->orWhere('phone', 'like', '%' . $query . '%');
        });

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
