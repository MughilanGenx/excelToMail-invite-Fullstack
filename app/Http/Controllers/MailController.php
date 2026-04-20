<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitationMail;
use App\Models\ExcelColumnData;
use App\Models\MailLog;
use App\Models\MailLogDetail;

class MailController extends Controller
{
    /** Show the compose form */
    public function compose()
    {
        $records = ExcelColumnData::latest()->get()->map(function ($record) {
            $record->values = $record->explodeValues();
            return $record;
        });

        return view('compose-mail', compact('records'));
    }

    /** Send emails and log every result to the DB */
    public function send(Request $request)
    {
        $request->validate([
            'record_id'      => 'required|exists:excel_column_data,id',
            'name_record_id' => 'nullable|exists:excel_column_data,id',
            'subject'        => 'required|string|max:255',
            'body'           => 'required|string',
            'from_name'      => 'nullable|string|max:255',
            'app_store_link' => 'nullable|url|max:500',
            'play_store_link'=> 'nullable|url|max:500',
        ]);

        // Increase execution time — sending many emails takes time
        set_time_limit(600);

        // --- Email list ---
        $record      = ExcelColumnData::findOrFail($request->record_id);
        $emails      = $record->explodeValues();
        $validEmails = array_values(
            array_filter($emails, fn($e) => filter_var(trim($e), FILTER_VALIDATE_EMAIL))
        );

        if (empty($validEmails)) {
            return back()->with('error', 'No valid email addresses found in the selected record.');
        }

        // --- Name list (optional, paired by index) ---
        $nameValues = [];
        if ($request->name_record_id) {
            $nameRecord = ExcelColumnData::find($request->name_record_id);
            if ($nameRecord) {
                $nameValues = array_values($nameRecord->explodeValues());
            }
        }

        $fromName      = $request->from_name    ?: config('app.name');
        $subject       = $request->subject;
        $body          = $request->body;
        $appStoreLink  = $request->app_store_link  ?: '#';
        $playStoreLink = $request->play_store_link ?: '#';

        // Create the parent log entry
        $log = MailLog::create([
            'subject'   => $subject,
            'from_name' => $fromName,
            'record_id' => $record->id,
            'total'     => count($validEmails),
            'sent'      => 0,
            'failed'    => 0,
        ]);

        $sent   = 0;
        $failed = 0;

        foreach ($validEmails as $index => $email) {
            $email         = trim($email);
            $recipientName = isset($nameValues[$index]) && trim($nameValues[$index]) !== ''
                             ? trim($nameValues[$index]) : '';

            try {
                Mail::to($email)->send(
                    new InvitationMail(
                        $subject, $body, $fromName,
                        $email, $recipientName,
                        $appStoreLink, $playStoreLink
                    )
                );

                MailLogDetail::create([
                    'log_id'         => $log->id,
                    'email'          => $email,
                    'recipient_name' => $recipientName,
                    'status'         => 'sent',
                    'error'          => null,
                ]);

                $sent++;

            } catch (\Exception $e) {
                MailLogDetail::create([
                    'log_id'         => $log->id,
                    'email'          => $email,
                    'recipient_name' => $recipientName,
                    'status'         => 'failed',
                    'error'          => $e->getMessage(),
                ]);

                $failed++;
            }
        }

        // Update totals on the log
        $log->update(['sent' => $sent, 'failed' => $failed]);

        return redirect()->route('mail.report', $log->id);
    }

    /** Show the detailed report for a send session */
    public function report($logId)
    {
        $log     = MailLog::with('details')->findOrFail($logId);
        $allLogs = MailLog::latest()->get(); // sidebar list of all sessions
        return view('mail-report', compact('log', 'allLogs'));
    }
}
