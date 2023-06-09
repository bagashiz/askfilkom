<?php

namespace App\Http\Controllers;

use App\Models\Pertanyaan;
use App\Models\Topik;
use Illuminate\Http\Request;

class PertanyaanController extends Controller
{
    /**
     * Index redirects to homepage with latest pertanyaan post
     *
     * @param Pertanyaan $pertanyaan
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view(
            'pertanyaan.index',
            [
                'pertanyaan' => Pertanyaan::with('user', 'topik')
                    ->withCount('jawaban')
                    ->filter(request()->input('search'), request()->input('topik'), request()->input('sort'))
                    ->latest()
                    ->paginate(10)
            ]
        );
    }

    /**
     * Create redirects to create Pertanyaan form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('pertanyaan.create', [
            'topik' => Topik::orderBy('nama')->get(),
        ]);
    }

    /**
     *Store saves a new pertanyaan post to database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'judul' => ['required', 'max:60'],
            'deskripsi' => ['required', 'max:1000'],
            'topik' => ['required', 'array', 'min:1', 'max:3', 'exists:topik,id_topik']
        ]);

        $pertanyaan = new Pertanyaan();
        $pertanyaan->id_user = auth()->id();
        $pertanyaan->judul = $formFields['judul'];
        $pertanyaan->deskripsi = $formFields['deskripsi'];

        $pertanyaan->save();

        $pertanyaan->topik()->attach($formFields['topik']);

        return redirect('/')
            ->with('success', 'Pertanyaan berhasil dibuat!');
    }

    /**
     * Show displays a pertanyaan post
     *
     * @param Pertanyaan $pertanyaan
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Pertanyaan $pertanyaan): \Illuminate\Contracts\View\View
    {
        return view('pertanyaan.show', [
            'pertanyaan' => $pertanyaan->load('user', 'topik'),
            'jawaban' => $pertanyaan->jawaban()->with('user')->latest()->get()
        ]);
    }

    /**
     * Edit redirects to edit pertanyaan form
     *
     * @param Pertanyaan $pertanyaan
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Pertanyaan $pertanyaan): \Illuminate\Contracts\View\View
    {
        if ($pertanyaan->id_user !== auth()->id()) {
            abort(403);
        }

        return view('pertanyaan.edit', [
            'pertanyaan' => $pertanyaan->load('topik'),
            'topik' => Topik::orderBy('nama')->get(),
        ]);
    }

    /**
     * Update updates user's pertanyaan
     *
     * @param Request $request
     * @param Pertanyaan $pertanyaan
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Pertanyaan $pertanyaan): \Illuminate\Http\RedirectResponse
    {
        if ($pertanyaan->id_user !== auth()->id()) {
            abort(403);
        }

        $formFields = $request->validate([
            'judul' => ['required', 'max:60'],
            'deskripsi' => ['required', 'max:1000'],
            'topik' => ['required', 'array', 'min:1', 'max:3', 'exists:topik,id_topik']
        ]);

        $pertanyaan->judul = $formFields['judul'];
        $pertanyaan->deskripsi = $formFields['deskripsi'];

        $pertanyaan->update();

        $pertanyaan->topik()->sync($formFields['topik']);

        return redirect('/pertanyaan/' . $pertanyaan->id_pertanyaan)
            ->with('success', 'Pertanyaan berhasil diperbarui!');
    }

    /**
     * Destroy deletes pertanyaan post
     *
     * @param Pertanyaan $pertanyaan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pertanyaan $pertanyaan): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        if ($pertanyaan->id_user !== $user->id_user && !$user->is_admin) {
            abort(403);
        }

        $pertanyaan->topik()->detach();
        $pertanyaan->delete();

        return redirect('/')
            ->with('success', 'Pertanyaan berhasil dihapus!');
    }
}
