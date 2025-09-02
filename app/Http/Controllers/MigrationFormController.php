<?php

namespace App\Http\Controllers;

use App\Models\MigrationForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MigrationFormController extends Controller
{
    public function store(Request $request)
    {
        // Check if user already submitted form
        $existingForm = MigrationForm::where('user_id', Auth::id())->latest()->first();

        if ($existingForm) {
            if ($existingForm->status === 'pending') {
                return back()->with('error', 'Your form is under review.');
            }
            if ($existingForm->status === 'resolved') {
                return back()->with('error', 'You are already an agent.');
            }
        }

        // Validate form
        $validated = $request->validate([
            'business_name'    => 'required|string|max:255',
            'business_address' => 'required|string|max:255',
            'business_email'   => 'required|email|max:255',
            'state'            => 'required|string|max:100',
            'lga'              => 'required|string|max:100',
            'address'          => 'required|string|max:255',
            'nearest_bustop'   => 'required|string|max:255',
            'office_image'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nepa_bill'        => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
            'cac_upload'       => 'nullable|mimes:pdf,jpeg,png,jpg|max:2048',
        ]);

        // Generate reference number
        $validated['reference'] = 'MIG-' . strtoupper(uniqid());

        // Save uploaded files with absolute URL
        if ($request->hasFile('office_image')) {
            $path = $request->file('office_image')->store('migration_files', 'public');
            $validated['office_image'] = url(Storage::url($path));
        }

        if ($request->hasFile('nepa_bill')) {
            $path = $request->file('nepa_bill')->store('migration_files', 'public');
            $validated['nepa_bill'] = url(Storage::url($path));
        }

        if ($request->hasFile('cac_upload')) {
            $path = $request->file('cac_upload')->store('migration_files', 'public');
            $validated['cac_upload'] = url(Storage::url($path));
        }

        // Attach user ID
        $validated['user_id'] = Auth::id();

        // Default status when submitting
        $validated['status'] = 'pending';

        // Store in DB
        $form = MigrationForm::create($validated);

        // Send custom email to user
        Mail::send('emails.migration_custom', [
            'user'      => Auth::user(),
            'reference' => $validated['reference'],
            'form'      => $form,
        ], function ($message) {
            $message->to(Auth::user()->email)
                    ->subject('Migration Form Submitted Successfully');
        });

        return back()->with('success', 'Migration form submitted successfully! Your reference: ' . $validated['reference']);
    }
}
