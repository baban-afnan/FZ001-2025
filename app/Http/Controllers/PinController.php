<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Security;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PinController extends Controller
{
    /**
     * Request OTP and store it in Security table
     */
    public function requestOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found']);
        }

        // Generate OTP (8 digits)
        $otp = random_int(10000000, 99999999);

        // Store OTP securely in Security table
        Security::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp' => Hash::make($otp), // hash OTP for verification
                'otp_plain' => $otp,       // optional: store plain OTP for audit/debug (encrypt in prod!)
                'otp_expires_at' => Carbon::now()->addMinutes(2),
                'transaction_pin' => null,
            ]
        );

        // Send OTP via styled email
        Mail::to($user->email)->send(new OtpMail($otp));

        return back()->with('otp_sent', true)->with('message', 'OTP has been sent to your email.');
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:8'
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email not found']);
        }

        $security = Security::where('user_id', $user->id)->first();

        if (!$security || !$security->otp_expires_at || Carbon::parse($security->otp_expires_at)->isPast()) {
            return back()->withErrors(['otp' => 'OTP expired, request a new one.']);
        }

        if (!Hash::check($request->otp, $security->otp)) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // Clear OTP after verification
        $security->update([
            'otp' => null,
            'otp_plain' => null,
            'otp_expires_at' => null,
        ]);

        session(['otp_verified_user' => $user->id]);

        return back()->with('otp_verified', true)->with('message', 'OTP verified successfully. Proceed to set PIN.');
    }

    /**
     * Create new PIN after OTP verification
     */
    public function create(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:4|confirmed'
        ]);

        $userId = session('otp_verified_user');
        if (!$userId) {
            return back()->withErrors(['otp' => 'OTP verification required']);
        }

        $security = Security::where('user_id', $userId)->first();
        if (!$security) {
            return back()->withErrors(['security' => 'Security record not found']);
        }

        // Save PIN in securities table
        $security->update([
            'transaction_pin' => Hash::make($request->pin),
        ]);

        // Clear session
        session()->forget('otp_verified_user');

        return back()->with('status', 'PIN created successfully');
    }

    /**
     * Reset PIN - request OTP after checking old PIN
     */
    public function reset(Request $request)
    {
        $request->validate([
            'old_pin' => 'required|digits:4',
        ]);

        $user = Auth::user();
        $security = Security::where('user_id', $user->id)->first();

        if (!$security || !Hash::check($request->old_pin, $security->transaction_pin)) {
            return back()->withErrors(['old_pin' => 'Old PIN is incorrect']);
        }

        // Generate new OTP
        $otp = random_int(10000000, 99999999);

        $security->update([
            'otp' => Hash::make($otp),
            'otp_plain' => $otp, // optional
            'otp_expires_at' => Carbon::now()->addMinutes(2),
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));

        return back()->with('reset_otp_sent', true)->with('message', 'A reset OTP has been sent to your email.');
    }
}
