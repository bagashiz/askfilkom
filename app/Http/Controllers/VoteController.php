<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Http\RedirectResponse;

class VoteController extends Controller
{
    /**
     * votePertanyaan saves a new state of vote in pertanyaan post by a user
     *
     * @param Pertanyaan $pertanyaan
     * @return RedirectResponse
     */
    public function votePertanyaan(Pertanyaan $pertanyaan): RedirectResponse
    {
        $user = auth()->user();

        if ($pertanyaan->hasVotedByUser($user)) {
            return redirect()->back()->withErrors([
                'message' => 'Anda sudah memberikan vote pada pertanyaan ini.',
            ]);
        }

        $vote = new Vote();
        $vote->id_user = $user->id_user;
        $pertanyaan->vote()->save($vote);

        $pertanyaan->increment('jumlah_vote');

        return back()
            ->with('success', 'Vote berhasil!');
    }

    /**
     * voteJawaban saves a new state of vote in jawaban post by a user
     *
     * @param Jawaban $jawaban
     * @return RedirectResponse
     */
    public function voteJawaban(Jawaban $jawaban): RedirectResponse
    {
        $user = auth()->user();

        if ($jawaban->hasVotedByUser($user)) {
            return redirect()->back()->withErrors([
                'message' => 'Anda sudah memberikan vote pada jawaban ini.',
            ]);
        }

        $vote = new Vote();
        $vote->id_user = $user->id_user;
        $jawaban->vote()->save($vote);

        $jawaban->increment('jumlah_vote');

        return back()
            ->with('success', 'Vote berhasil!');
    }

    /**
     * unvotePertanyaan remove a state of vote in pertanyaan post by a user
     *
     * @param Pertanyaan $pertanyaan
     * @return RedirectResponse
     */
    public function unvotePertanyaan(Pertanyaan $pertanyaan): RedirectResponse
    {
        $user = auth()->user();

        if (!$pertanyaan->hasVotedByUser($user)) {
            return redirect()->back()->withErrors([
                'message' => 'Anda belum memberikan vote pada pertanyaan ini.',
            ]);
        }

        $pertanyaan->vote()
            ->where('id_user', $user->id_user)
            ->delete();

        $pertanyaan->decrement('jumlah_vote');

        return back()
            ->with('success', 'Unvote berhasil!');
    }

    /**
     * unvoteJawaban remove a state of vote in jawaban post by a user
     *
     * @param Jawaban $jawaban
     * @return RedirectResponse
     */
    public function unvoteJawaban(Jawaban $jawaban): RedirectResponse
    {
        $user = auth()->user();

        if (!$jawaban->hasVotedByUser($user)) {
            return redirect()->back()->withErrors([
                'message' => 'Anda belum memberikan vote pada jawaban ini.',
            ]);
        }

        $jawaban->vote()
            ->where('id_user', $user->id_user)
            ->delete();

        $jawaban->decrement('jumlah_vote');

        return back()
            ->with('success', 'Unvote berhasil!');
    }
}
