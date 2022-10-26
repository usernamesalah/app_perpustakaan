<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function __invoke(Request $request)
    {
        $notification = Contact::limit(5)
            ->latest()
            ->get();
        return response()->json(['data' => $notification]);
    }
}
