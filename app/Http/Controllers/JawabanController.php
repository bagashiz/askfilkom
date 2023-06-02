<?php

namespace App\Http\Controllers;

use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

class JawabanController extends Controller
{
    /**
     * Create redirects to create jawaban form
     *
     * @param Pertanyaan $pertanyaan
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Pertanyaan $pertanyaan): \Illuminate\Contracts\View\View
    {
        return view('jawaban.create', [
            'pertanyaan' => $pertanyaan
        ]);
    }

    /**
     * Store saves a new jawaban post to database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $formFields = $request->validate([
            'id_user' => ['required',  'exists:user,id_user'],
            'id_pertanyaan' => ['required', 'exists:pertanyaan,id_pertanyaan'],
            'deskripsi' => ['required', 'max:1000']
        ]);

        $jawaban = new Jawaban();
        $jawaban->id_user = $formFields['id_user'];
        $jawaban->id_pertanyaan = $formFields['id_pertanyaan'];
        $jawaban->deskripsi = $formFields['deskripsi'];

        $jawaban->save();

        return redirect('/pertanyaan/' . $jawaban->pertanyaan->id_pertanyaan)
            ->with('success', 'Jawaban berhasil ditambahkan!');
    }

    /**
     * Edit redirects to edit jawaban form
     *
     * @param Jawaban $jawaban
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Jawaban $jawaban): \Illuminate\Contracts\View\View
    {
        if ($jawaban->id_user !== auth()->id()) {
            abort(403);
        }

        return view('jawaban.edit', [
            'pertanyaan' => $jawaban->pertanyaan(),
            'jawaban' => $jawaban,
        ]);
    }

    /**
     * Update updates an existing jawaban post
     *
     * @param Request $request
     * @param Jawaban $jawaban
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Jawaban $jawaban): \Illuminate\Http\RedirectResponse
    {
        if ($jawaban->id_user !== auth()->id()) {
            abort(403);
        }

        $formFields = $request->validate([
            'deskripsi' => ['required', 'max:1000']
        ]);

        $jawaban->deskripsi = $formFields['deskripsi'];

        $jawaban->save();

        return redirect('/pertanyaan/' . $jawaban->pertanyaan->id_pertanyaan)
            ->with('success', 'Jawaban berhasil diperbarui!');
    }

    /**
     * Destroy deletes an existing jawaban post
     *
     * @param Jawaban $jawaban
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Jawaban $jawaban): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        if ($jawaban->id_user !== $user->id_user && !$user->is_admin) {
            abort(403);
        }

        $jawaban->delete();

        return redirect('/pertanyaan/' . $jawaban->pertanyaan->id_pertanyaan)
            ->with('success', 'Jawaban berhasil dihapus!');
    }
}
