<?php

namespace App\Http\Controllers;

use App\Imports\EmailsImport;
use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use App\Mail\EmailManager;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{
    public function index(Request $request)
    {
        $filter_by = $request->filter_by ?? null;
        $users = User::query()
            ->when($filter_by, function ($query, $filter_by) {
                if ($filter_by == 'email_verified') {
                    return $query->where('email_verified_at', '!=', null);
                } elseif ($filter_by == 'phone_verified') {
                    return $query->where('phone_verified_at', '!=', null);
                } elseif ($filter_by == 'website') {
                    return $query->where('registered_from', 'website');
                } elseif ($filter_by == 'mobile') {
                    return $query->where('registered_from', 'mobile');
                } else {
                    return $query;
                }
            })
            ->get();

        return view('newsletters.index', compact('users', 'filter_by'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'content' => 'required',
            'emails_file' => 'mimes:xlsx,xls,csv|max:2048',
        ]);
        if (env('MAIL_USERNAME') != null) {
            $emails = json_decode($request->emails);
            if (count($emails) > 0) {
                $emails = array_map(function ($email) {
                    return $email->value;
                }, $emails);
            } else {
                $emails = [];
            }

            if ($request->has('user_emails')) {
                $emails[] = $request->user_emails;
            }

            $excelFile = $request->file('emails_file');
            if ($excelFile) {
                $emails = array_merge($emails, Excel::toArray(new EmailsImport(), $excelFile)[0]);
            }

            if ($request->has('subscriber_emails')) {
                $emails = array_merge($emails, $request->subscriber_emails);
            }

            $emails = array_unique($emails) ?: [];

            //validate all emails
            $emails = array_map(function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
            }, $emails);
            $emails = array_filter($emails, function ($email) {
                return $email !== null;
            });

            if (!empty($emails)) {
                foreach ($emails as $email) {
                    $array['view'] = 'emails.newsletter';
                    $array['subject'] = $request->subject;
                    $array['from'] = env('MAIL_FROM_ADDRESS');
                    $array['content'] = $request->get('content');

                    try {
                        defer(function () use ($email, $array) {
                            Mail::to($email)->send(new EmailManager($array));
                        });
                    } catch (\Exception $e) {
                        return back()->with('error', $e->getMessage());
                    }
                }
            }
        } else {

            return back()->with('error', 'Please configure SMTP first');
        }
        return back()->with('success', 'Newsletter has been sent');
    }


    //    public function testEmail(Request $request){
    //        $array['view'] = 'emails.newsletter';
    //        $array['subject'] = "SMTP Test";
    //        $array['from'] = env('MAIL_FROM_ADDRESS');
    //        $array['content'] = "This is a test email.";
    //
    //        try {
    //            Mail::to($request->email)->queue(new EmailManager($array));
    //        } catch (\Exception $e) {
    //            return response()->json(['error' => $e->getMessage()]);
    //        }
    //
    //        flash(translate('An email has been sent.'))->success();
    //        return back();
    //    }
}
