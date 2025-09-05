<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Models\Transaction;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    /**
     * Show support services page (form + recent tickets)
     */
    public function create()
    {
        $userId = auth()->id();

        // Counts
        $pendingCount    = SupportTicket::where('user_id', $userId)->where('status', 'pending')->count();
        $processingCount = SupportTicket::where('user_id', $userId)->where('status', 'processing')->count();
        $resolvedCount   = SupportTicket::where('user_id', $userId)->where('status', 'resolved')->count();

        // Tickets by status
        $pendingTickets    = SupportTicket::where('user_id', $userId)->where('status', 'pending')->latest()->get();
        $processingTickets = SupportTicket::where('user_id', $userId)->where('status', 'processing')->latest()->get();
        $resolvedTickets   = SupportTicket::where('user_id', $userId)->where('status', 'resolved')->latest()->get();

        return view('support-services', compact(
            'pendingCount',
            'processingCount',
            'resolvedCount',
            'pendingTickets',
            'processingTickets',
            'resolvedTickets'
        ));
    }

    /**
     * Store new support ticket
     */
    public function store(Request $request)
    {
        // Basic validation
        $request->validate([
            'transaction_ref' => 'required|string',
            'category'        => 'required|string',
            'content'         => 'required|string',
            'attachment'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // ✅ Check if transaction_ref exists in transactions table
        $transaction = Transaction::where('transaction_ref', $request->transaction_ref)->first();

        if (!$transaction) {
            return redirect()->route('support.create')
                ->with('error', 'Transaction ID not found, please try again with the correct transaction ID.');
        }

        // Generate unique ticket ID
        do {
            $ticketId = rand(10000, 99999);
        } while (SupportTicket::where('ticket_id', $ticketId)->exists());
        $performedBy = $user->first_name . ' ' . $user->last_name;

        // Create ticket
        $ticket = SupportTicket::create([
            'ticket_id'       => $ticketId,
            'transaction_ref' => $request->transaction_ref,
            'category'        => $request->category,
            'content'         => $request->content,
            'performed_by'    => $performedBy, 
            'status'          => 'pending',
            'user_id'         => auth()->id(),
        ]);

      // Save attachment if uploaded
if ($request->hasFile('attachment')) {
    // Save file inside storage/app/public/complaints
    $path = $request->file('attachment')->store('complaints', 'public');
    $ticket->attachment = asset('storage/' . $path);
    $ticket->save();
}
        // Send email confirmation
        if ($user = auth()->user()) {
            if (!empty($user->email)) {
                try {
                    Mail::to($user->email)->send(new \App\Mail\ComplaintSubmitted($ticket));
                } catch (\Exception $e) {
                    return redirect()->route('support.create')
                        ->with('error', 'Ticket submitted but email could not be sent.');
                }
            }
        }

        return redirect()->route('support.create')
            ->with('success', 'Your complaint has been submitted. Ticket ID: ' . $ticketId);
    }
}
