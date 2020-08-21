<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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
     * @param Request $request
     * @return View
     */
    public function index(Request $request) : View
    {
        $search =  $request->get('search');

        return $this->searchUser($search);
    }

    /**
     * Display the specified user.
     *
     * @param  User  $user
     * @return View
     */
    public function show(User $user) : View
    {
        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified user.
     * @param UserRequest $request
     * @param User $user
     * @return View
     */
    public function edit(UserRequest $request, User $user) : View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'input_name' => $request->input('input_name') // variable que le dice a la vista cual input mostrar
        ]);
    }

    /**
     * Update the specified user in storage.
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user) : RedirectResponse
    {
        $user->update($request->all());

        return redirect( route('users.show', ['user' => $user]))->with('user-updated', 'User has been updated success');
    }

    /**
     * Remove the specified user from storage.
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user) : RedirectResponse
    {
        $user->delete();

        return redirect("admin/users")->with('user-deleted', "User has been deleted success");
    }


    /**
     * Funcion busca un usuario en la tabla users
     * y busca coincidencias en los campos name, lastname, email y phone
     *
     * @param string|null $search
     * @return View
     */
    private function searchUser(?string $search) : View
    {
        if ($this->user->search($search)->count() > 0) {
            return view('admin.users.index', [
                'users' => $this->user->search($search)->paginate(10),
                'user_found' => "Mostrando resultados para: $search"
            ]);
        } else {
            return view('admin.users.index', [
                'users' => $this->user->search($search)->paginate(10),
                'user_not_found' => "No se encontraron resultados para $search"
            ]);
        }
    }
}
