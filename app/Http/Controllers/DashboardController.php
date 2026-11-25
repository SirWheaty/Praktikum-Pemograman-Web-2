<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'messageCount' => Contact::count(),
            'unreadMessageCount' => Contact::where('is_read', false)->count(),
        ]);
    }
}
