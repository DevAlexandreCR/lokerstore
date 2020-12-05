<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\IndexRequest;
use App\Http\Requests\Web\Users\UserRequest;
use App\Interfaces\UsersInterface;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    protected UsersInterface $users;

    public function __construct(UsersInterface $users)
    {
        $this->users = $users;

        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the users.
     * @param IndexRequest $request
     * @return View
     */
    public function index(IndexRequest $request): View
    {
        $users = $this->users->search($request);
        $search =  $request->get('search');
        if ($users->count() > 0) {
            return view('admin.users.index', [
                'users' => $users,
                'user_found' => trans('messages.found', ['search' => $search]),
            ]);
        }

        return view('admin.users.index', [
            'users' => $users,
            'user_not_found' => trans('messages.search_not_found', ['search' => $search]),
        ]);
    }

    /**
     * Display the specified user.
     *
     * @param  User  $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified user.
     * @param UserRequest $request
     * @param User $user
     * @return View
     */
    public function edit(UserRequest $request, User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'input_name' => $request->input('input_name'), // variable que le dice a la vista cual input mostrar
        ]);
    }

    /**
     * Update the specified user in storage.
     * @param UserRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $this->users->update($request, $user);

        return redirect(route(
            'users.show',
            ['user' => $user]
        ))
            ->with('success', trans('messages.crud', [
                'resource' => trans_choice('users.user', 1, ['user_count' => '']),
                'status' => trans('fields.updated')
            ]));
    }

    /**
     * Remove the specified user from storage.
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->users->destroy($user);

        return redirect('admin/users')->with('success', trans('messages.crud', [
            'resource' => trans_choice('users.user', 1, ['user_count' => '']),
            'status' => trans('fields.deleted')
        ]));
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function resend(User $user): RedirectResponse
    {
        $user->sendEmailVerificationNotification();

        return back()->with('status', trans('passwords.email_resend'));
    }
}
