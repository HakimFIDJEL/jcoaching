<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;

class ContactController extends Controller
{
    public function index() {
        $contacts = Contact::all();
        return view('admin.contacts.index')->with(['contacts' => $contacts]);
    }

    public function show(Contact $contact) {
        $contact->read_at = now();
        $contact->save();

        return view('admin.contacts.show')->with(['contact' => $contact]);
    }

    public function softDelete(Contact $contact) {
        $contact->delete();
        return redirect()->route('admin.contacts.index')->with(['success' => 'Le contact a été mis dans la corbeille.']);
    }

    public function restore(int $id) {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->restore();
        return redirect()->back()->with(['success' => 'Le contact a été restauré.']);
    }

    public function delete(int $id) {
        $contact = Contact::withTrashed()->findOrFail($id);
        $contact->forceDelete();
        return redirect()->back()->with(['success' => 'Le contact a été supprimé définitivement.']);
    }
}
