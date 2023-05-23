<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create redirects to the user registration page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('users.register');
    }

    /**
     * Store saves a new user to the database.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'username' => ['required', 'min:5', 'max:20'],
            'nama' => ['required', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'min:8', 'max:255'],
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user->create($formFields);

        return redirect('/login')
            ->with('success', 'Registrasi berhasil! Silakan login menggunakan akun yang telah dibuat.');
    }

    /**
     * Show redirects to the user profile page by id.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user): \Illuminate\Contracts\View\View
    {
        return view(
            'users.show',
            [
                'user' => $user,
                'pertanyaan' => $user->pertanyaan()->where('id_user', $user->id_user)->latest()->paginate(5),
            ]
        );
    }

    /**
     * Profile redirects to the user profile page by authenticated user.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function profile(Request $request): \Illuminate\Contracts\View\View
    {
        $user = $request->user();

        return view(
            'users.profile',
            [
                'user' => $user,
                'pertanyaan' => $user->pertanyaan()->where('id_user', $user->id_user)->latest()->paginate(5),
            ]
        );
    }


    /**
     * Manage redirects to the user management page.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function manage(User $user): \Illuminate\Contracts\View\View
    {
        $isAdmin = auth()->user()->is_admin;

        if (!$isAdmin) {
            return abort(403);
        }

        return view(
            'users.manage',
            [
                'users' => $user->all(),
            ]
        );
    }

    /**
     * Update updates user profile by admin.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $isAdmin = auth()->user()->is_admin;

        if (!$isAdmin) {
            return abort(403);
        }

        $formFields = $request->validate([
            'username' => ['required', 'min:5', 'max:20'],
            'nama' => ['required', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'is_admin' => ['required', 'boolean'],
        ]);

        if ($isAdmin) {
            $user->where('id_user', $request->id_user)->update($formFields);
        }

        return redirect('/users/manage')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    /**
     * Edit resets redirects to the user password reset page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(): \Illuminate\Contracts\View\View
    {
        return view(
            'users.reset',
        );
    }

    /**
     * Reset resets user password by authenticated user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'password' => ['required', 'confirmed', 'min:8', 'max:255'],
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user->where('id_user', auth()->user()->id_user)->update($formFields);

        return redirect('/profile')
            ->with('success', 'Password berhasil diperbarui!');
    }

    /**
     * Destroy deletes user by admin or authenticated user.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, User $user): \Illuminate\Http\RedirectResponse
    {
        $isAdmin = auth()->user()->is_admin;

        if (!$isAdmin) {
            return abort(403);
        }

        $user->where('id_user', $request->id_user)->delete();

        return redirect('/users/manage')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Login redirects to the user login page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function login(): \Illuminate\Contracts\View\View
    {
        return view('users.login');
    }

    /**
     * Auth authenticates user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function auth(Request $request): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'username' => ['required', 'min:5', 'max:20'],
            'password' => ['required', 'min:8', 'max:255'],
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect()
                ->intended('/')
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah!',
        ])->onlyInput('username');
    }

    /**
     * Logout logs out user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Logout berhasil!');
    }
}
