<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmailsssssss(Request $request)
    {

        // $request->validate([
        //     'subject' => 'required|string',
        //     'body' => 'required|string',
        //     'selectedEmployees' => 'required|array',
        //     'file' => 'file|mimes:pdf,docx|max:2048',
        // ]);

        $subject = $request->input('subject');
        $body = $request->input('body');
        $selectedEmployees = json_decode($request->input('selectedEmployees'));

        // Handle file attachment (if provided)
        $file = $request->file('file');
        $filePath = null;
        if ($file) {
            $filePath = $file->store('attachments');
        }

        foreach ($selectedEmployees as $recipientId) {
            $recipient = Employe::find($recipientId);
            if ($recipient) {
                Mail::to($recipient->email)->send(new SendEmail($subject, $body, $filePath));
            }
        }

        return response()->json(['message' => 'Emails sent successfully'], 200);
    }

    public function sendEmail(Request $request)
    {
        $data = 'hello suraj babu';
        Mail::to('surajkohar826@gmail.com')->send(new TestEmail($data));

    }
}