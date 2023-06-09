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
            'topik' => Topik::orderBy('nama', 'asc')
                ->paginate(10)
        ]);
    }

    /**
     * Store saves a new topik to database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $regex = '/^[a-zA-Z0-9\s]+$/';

        $formFields = $request->validate([
            'nama' => ['required', 'max:15', 'regex:' . $regex],
        ]);

        $topik = new Topik();
        $topik->nama = $formFields['nama'];
        $topik->save();

        return redirect('/topik')
            ->with('success', 'Topik berhasil dibuat!');
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
        $regex = '/^[a-zA-Z0-9\s]+$/';

        $formFields = $request->validate([
            'nama' => ['required', 'max:15', 'regex:' . $regex],
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
