<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::where('deleted_at', null)->get();
        return view('admin.contacts.index')->with(['contacts' => $contacts]);
    }

    public function show(Contact $contact)
    {
        $contact->read_at = now();
        $contact->save();

        return view('admin.contacts.show')->with(['contact' => $contact]);
    }

    public function softDelete(Contact $contact)
    {
        $contact->softDelete();
        return redirect()->route('admin.contacts.index')->with(['success' => 'Le contact a été mis dans la corbeille.']);
    }

    public function restore(Contact $contact)
    {
        $contact->restore();
        return redirect()->route('admin.contacts.index')->with(['success' => 'Le contact a été restauré.']);
    }

    public function delete(Contact $contact)
    {
        $contact->forceDelete();
        return redirect()->route('admin.contacts.index')->with(['success' => 'Le contact a été supprimé définitivement.']);
    }
}
