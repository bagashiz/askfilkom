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
                'pertanyaan' => $user->pertanyaan()
                    ->latest()
                    ->paginate(5),
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
                'pertanyaan' => $user->pertanyaan()->latest()
            ]
        );
    }


    /**
     * Index redirects to the user management page by admin.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view(
            'users.index',
            [
                'users' => User::orderBy('is_admin', 'desc')
                ->orderBy('username', 'asc')
                ->paginate(10),
            ]
        );
    }

    /**
     * EditByAdmin redirects to the user profile edit page by admin.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function editByAdmin(User $user): \Illuminate\Contracts\View\View
    {
        return view(
            'users.edit',
            [
                'user' => $user,
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
        // dd($request->input('is_admin'));
        $formFields = $request->validate([
            'username' => ['required', 'min:5', 'max:20'],
            'nama' => ['required', 'min:5', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'is_admin' => ['required', 'boolean'],
        ]);

        $user->update($formFields);

        return redirect('/users')
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
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): \Illuminate\Http\RedirectResponse
    {
        $user->delete();

        return back()
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

            return back()
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

        return redirect('/')
            ->with('success', 'Logout berhasil!');
    }
}
