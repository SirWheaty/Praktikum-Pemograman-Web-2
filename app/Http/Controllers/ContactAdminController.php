<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\View\View;

class ContactAdminController extends Controller
{
    public function index(): View
    {
        $contacts = Contact::query()->latest()->paginate(10);

        return view('post.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact): View
    {
        $contact->update(['is_read' => true]);

        return view('post.contacts.show', compact('contact'));
    }
}
