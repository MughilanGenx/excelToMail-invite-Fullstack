<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use App\Models\ExcelColumnData;

class MailController extends Controller
{
    /**
     * Show the compose form.
     * Lists all saved email records so the user can pick one.
     */
    public function compose()
    {
        $records = ExcelColumnData::latest()->get()->map(function ($record) {
            $record->values = $record->explodeValues();
            return $record;
        });

        return view('compose-mail', compact('records'));
    }

    /**
     * Send the email to all addresses from the selected saved record.
     */
    public function send(Request $request)
    {
        $request->validate([
            'record_id'   => 'required|exists:excel_column_data,id',
            'subject'     => 'required|string|max:255',
            'body'        => 'required|string',
            'from_name'   => 'nullable|string|max:255',
        ]);

        $record = ExcelColumnData::findOrFail($request->record_id);

        // Explode the stored comma-separated string → array of email addresses
        $emails = $record->explodeValues();

        // Filter to valid email addresses only
        $validEmails = array_filter($emails, fn($e) => filter_var(trim($e), FILTER_VALIDATE_EMAIL));

        if (empty($validEmails)) {
            return back()->with('error', 'No valid email addresses found in the selected record.');
        }

        $fromName  = $request->from_name ?: config('app.name');
        $subject   = $request->subject;
        $body      = $request->body;

        $sent    = 0;
        $failed  = 0;
        $failedList = [];

        foreach ($validEmails as $email) {
            $email = trim($email);
            try {
                Mail::to($email)->send(new InvitationMail($subject, $body, $fromName));
                $sent++;
            } catch (\Exception $e) {
                $failed++;
                $failedList[] = $email . ' (' . $e->getMessage() . ')';
            }
        }

        $message = "✅ {$sent} email(s) sent successfully.";
        if ($failed > 0) {
            $message .= " ⚠️ {$failed} failed.";
        }

        return redirect()->route('mail.compose')
            ->with('success', $message)
            ->with('failed_list', $failedList);
    }
}
