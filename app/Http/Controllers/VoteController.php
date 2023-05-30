<?php

namespace App\Http\Controllers;

use App\Models\Vote;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class VoteController extends Controller
{
    /**
     * votePertanyaan saves a new state of vote in pertanyaan post by a user
     * 
     * @param Request $request
     * @param Response $response
     * @param Pertanyaan $pertanyaan
     * 
     * @return Response
     */
    public function votePertanyaan(Request $request, Response $response, Pertanyaan $pertanyaan): Response
    {
        $request->validate([
            'pertanyaan' => [
                'required',
                Rule::exists('pertanyaan')->where(function ($query) use ($pertanyaan) {
                    $query->where('id_pertanyaan', $pertanyaan->id_pertanyaan);
                }),
            ],
        ]);

        $vote = new Vote();
        $vote->id_user = auth()->id();
        $vote->id_pertanyaan = $pertanyaan->id_pertanyaan;

        $vote->save();

        $pertanyaan->jumlah_vote += 1;

        $pertanyaan->save();

        return $response->json([
            'message' => 'Vote berhasil!',
            'jumlah_vote' => $pertanyaan->jumlah_vote,
        ]);
    }

    /**
     * voteJawaban saves a new state of vote in jawaban post by a user
     * 
     * @param Request $request
     * @param Response $response
     * @param Jawaban $jawaban
     * 
     * @return Response
     */
    public function storeJawaban(Request $request, Response $response, Jawaban $jawaban): Response
    {
        $request->validate([
            'jawaban' => [
                'required',
                Rule::exists('jawaban')->where(function ($query) use ($jawaban) {
                    $query->where('id_jawaban', $jawaban->id_jawaban);
                }),
            ],
        ]);

        $vote = new Vote();
        $vote->id_user = auth()->id();
        $vote->id_jawaban = $jawaban->id_jawaban;

        $vote->save();

        $jawaban->jumlah_vote += 1;

        $jawaban->save();

        return $response()->json([
            'message' => 'Vote berhasil!',
            'jumlah_vote' => $jawaban->jumlah_vote,
        ]);
    }

    /**
     * unvotePertanyaan remove a state of vote in pertanyaan post by a user
     * 
     * @param Request $request
     * @param Response $response
     * @param Pertanyaan $pertanyaan
     * 
     * @return Response
     */
    public function unvotePertanyaan(Request $request, Response $response, Pertanyaan $pertanyaan): Response
    {
        $request->validate([
            'pertanyaan' => [
                'required',
                Rule::exists('pertanyaan')->where(function ($query) use ($pertanyaan) {
                    $query->where('id_pertanyaan', $pertanyaan->id_pertanyaan);
                }),
            ],
        ]);

        $user = auth()->user();

        $vote = Vote::where('id_user', $user->id_user)
            ->where('id_pertanyaan', $pertanyaan->id_pertanyaan)
            ->firstOrFail();

        $vote->delete();

        $pertanyaan->jumlah_vote -= 1;

        $pertanyaan->save();

        return $response()->json([
            'message' => 'Unvote berhasil!',
            'jumlah_vote' => $pertanyaan->jumlah_vote,
        ]);
    }

    /**
     * unvoteJawaban remove a state of vote in jawaban post by a user
     * 
     * @param Request $request
     * @param Response $response
     * @param Jawaban $jawaban
     * 
     * @return Response
     */
    public function unvotejawaban(Request $request, Response $response, Jawaban $jawaban): Response
    {
        $request->validate([
            'jawaban' => [
                'required',
                Rule::exists('jawaban')->where(function ($query) use ($jawaban) {
                    $query->where('id_jawaban', $jawaban->id_jawaban);
                }),
            ],
        ]);

        $user = auth()->user();

        $vote = Vote::where('id_user', $user->id_user)
            ->where('id_jawaban', $jawaban->id_jawaban)
            ->firstOrFail();

        $vote->delete();

        $jawaban->jumlah_vote -= 1;

        $jawaban->save();

        return $response()->json([
            'message' => 'Unvote berhasil!',
            'jumlah_vote' => $jawaban->jumlah_vote,
        ]);
    }
}
