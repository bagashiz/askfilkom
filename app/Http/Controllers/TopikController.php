<?php

namespace App\Http\Controllers;

use App\Models\Topik;
use Illuminate\Http\Request;

class TopikController extends Controller
{
    /**
     * Index shows all topik
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('topik.index', [
            'topik' => Topik::all()
        ]);
    }

    /**
     * Create redirects to create topik form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('topik.create');
    }

    /**
     * Store saves a new topik to database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'nama' => ['required', 'max:15'],
        ]);

        $topik = new Topik();
        $topik->nama = $formFields['nama'];
        $topik->save();

        return redirect('/topik')
            ->with('success', 'Topik berhasil dibuat!');
    }

    /**
     * Edit redirects to edit topik form
     *
     * @param Topik $topik
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Topik $topik): \Illuminate\Contracts\View\View
    {
        return view('topik.edit', [
            'topik' => $topik
        ]);
    }

    /**
     * Update saves an edited topik to database
     *
     * @param Request $request
     * @param Topik $topik
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Topik $topik): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'nama' => ['required', 'max:15'],
        ]);

        $topik->nama = $formFields['nama'];
        $topik->save();

        return redirect('/topik')
            ->with('success', 'Topik berhasil diperbarui!');
    }

    /**
     * Destroy deletes a topik from database
     *
     * @param Topik $topik
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Topik $topik): \Illuminate\Http\RedirectResponse
    {
        $topik->delete();

        return redirect('/topik')
            ->with('success', 'Topik berhasil dihapus!');
    }
}
