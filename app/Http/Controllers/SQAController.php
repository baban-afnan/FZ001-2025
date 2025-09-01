<?php

namespace App\Http\Controllers;

use App\Models\Security;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SQAController extends Controller
{
    /**
     * Store or update user security questions.
     */
    public function update(Request $request)
    {
        $request->validate([
            'security_question_1' => 'required|string|max:255',
            'security_answer_1'   => 'required|string|max:255',
            'security_question_2' => 'required|string|max:255',
            'security_answer_2'   => 'required|string|max:255',
            'security_question_3' => 'required|string|max:255',
            'security_answer_3'   => 'required|string|max:255',
        ]);

        $user = Auth::user();

        // Update or create security record for this user
        Security::updateOrCreate(
            ['user_id' => $user->id],
            [
                'security_question_1' => $request->security_question_1,
                'security_answer_1'   => Crypt::encryptString($request->security_answer_1),
                'security_question_2' => $request->security_question_2,
                'security_answer_2'   => Crypt::encryptString($request->security_answer_2),
                'security_question_3' => $request->security_question_3,
                'security_answer_3'   => Crypt::encryptString($request->security_answer_3),
            ]
        );

        return back()->with('success', ' Security questions updated successfully.');
    }
}
