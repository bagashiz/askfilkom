<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class VoteController extends Controller
{
    /**
     * votePertanyaan saves a new state of vote in pertanyaan post by a user
     *
     * @param Pertanyaan $pertanyaan
     * @return JsonResponse
     */
    public function votePertanyaan(Pertanyaan $pertanyaan): JsonResponse
    {
        $vote = new Vote();
        $vote->id_user = auth()->id();
        $vote->id_pertanyaan = $pertanyaan->id_pertanyaan;

        $vote->save();

        $pertanyaan->jumlah_vote += 1;

        $pertanyaan->update();

        return response()->json([
            'message' => 'Vote berhasil!',
            'jumlah_vote' => $pertanyaan->jumlah_vote,
        ]);
    }

    /**
     * voteJawaban saves a new state of vote in jawaban post by a user
     *
     * @param Jawaban $jawaban
     * @return JsonResponse
     */
    public function voteJawaban(Jawaban $jawaban): JsonResponse
    {
        $vote = new Vote();
        $vote->id_user = auth()->id();
        $vote->id_jawaban = $jawaban->id_jawaban;

        $vote->save();

        $jawaban->jumlah_vote += 1;

        $jawaban->update();

        return response()->json([
            'message' => 'Vote berhasil!',
            'jumlah_vote' => $jawaban->jumlah_vote,
        ]);
    }

    /**
     * unvotePertanyaan remove a state of vote in pertanyaan post by a user
     *
     * @param Pertanyaan $pertanyaan
     * @return JsonResponse
     */
    public function unvotePertanyaan(Pertanyaan $pertanyaan): JsonResponse
    {
        $user = auth()->user();

        try {
            $vote = Vote::where('id_user', $user->id_user)
                ->where('id_pertanyaan', $pertanyaan->id_pertanyaan)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Unvote gagal!',
            ], 404);
        }

        $vote->delete();

        $pertanyaan->jumlah_vote -= 1;

        $pertanyaan->update();

        return response()->json([
            'message' => 'Unvote berhasil!',
            'jumlah_vote' => $pertanyaan->jumlah_vote,
        ]);
    }

    /**
     * unvoteJawaban remove a state of vote in jawaban post by a user
     *
     * @param Jawaban $jawaban
     * @return JsonResponse
     */
    public function unvoteJawaban(Jawaban $jawaban): JsonResponse
    {
        $user = auth()->user();

        try {
            $vote = Vote::where('id_user', $user->id_user)
                ->where('id_jawaban', $jawaban->id_jawaban)
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Unvote gagal!',
            ], 404);
        }

        $vote->delete();

        $jawaban->jumlah_vote -= 1;

        $jawaban->update();

        return response()->json([
            'message' => 'Unvote berhasil!',
            'jumlah_vote' => $jawaban->jumlah_vote,
        ]);
    }
}
