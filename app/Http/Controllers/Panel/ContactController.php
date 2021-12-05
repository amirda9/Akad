<?php

namespace App\Http\Controllers\Panel;

use App\Contact;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContactController extends Controller
{

    public function index(Request $request)
    {
        $this->authorize('view contacts');
        $contacts = Contact::orderBy('created_at','desc');

        if($request->search) {
            $contacts = $contacts->where(function($query) use($request) {
                $query->where('name','LIKE',"%$request->search%")
                    ->orWhere('email','LIKE',"%$request->search%")
                    ->orWhere('mobile','LIKE',"%$request->search%");
            });
        }

        if($request->start_date) {
            $start_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d',Str::limit(request('start_date'),10,'')));
            $start_date->startOfDay();
            $contacts = $contacts->where('created_at','>=',$start_date);
        }
        if($request->end_date) {
            $end_date = Carbon::createFromFormat('Y-m-d', Date('Y-m-d',Str::limit(request('end_date'),10,'')));
            $end_date->endOfDay();
            $contacts = $contacts->where('created_at','<=',$end_date);
        }

        switch ($request->status) {
            case 'seen' : {
                $contacts = $contacts->where('seen',true);
                break;
            }
            case 'not_seen' : {
                $contacts = $contacts->where('seen',false);
                break;
            }
        }

        $contacts = $contacts->paginate();
        $contacts->appends($request->query());

        return view('panel.contacts.index')->with([
            'contacts' => $contacts
        ]);
    }


    public function show(Contact $contact)
    {
        $this->authorize('view contacts');
        $contact->update([
            'seen' => true
        ]);
        return view('panel.contacts.show')->with([
            'contact' => $contact
        ]);
    }


    public function destroy(Contact $contact)
    {
        $this->authorize('delete contact');
        $contact->delete();
        return redirect()->route('panel.contacts.index')->with([
            'success' => 'پیام مورد نظر با موفقیت حذف شد'
        ]);
    }


}
