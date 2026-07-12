<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Plainte;
use App\Support\PlainteStatut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create(Plainte $plainte)
    {
        if ($plainte->id_user !== Auth::id()) {
            abort(403);
        }

        if ($plainte->statut !== PlainteStatut::RESOLUE) {
            return redirect()->route('complaints.show', $plainte)
                ->with('error', 'Le feedback n\'est disponible que pour les plaintes résolues.');
        }

        if ($plainte->feedbacks()->where('id_user', Auth::id())->exists()) {
            return redirect()->route('complaints.show', $plainte)
                ->with('info', 'Vous avez déjà donné votre avis.');
        }

        return view('feedback.create', [
            'plainte' => $plainte,
            'complaint' => $plainte,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'complaint_id' => 'required|exists:plaintes,id',
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string|max:1000',
        ]);

        $plainte = Plainte::findOrFail($request->complaint_id);

        if ($plainte->id_user !== Auth::id()) {
            abort(403);
        }

        Feedback::create([
            'id_plainte' => $plainte->id,
            'id_user' => Auth::id(),
            'note' => $request->note,
            'comment' => $request->commentaire,
        ]);

        return redirect()->route('complaints.show', $plainte)->with('success', 'Merci pour votre feedback !');
    }
}
