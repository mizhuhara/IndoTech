<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MyApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $applications = JobApplication::with(['jobListing', 'internship', 'statusHistories'])
            ->where('user_id', $request->user()->id)
            ->latest('id')
            ->get();

        return view('career.applications', [
            'applications' => $applications,
        ]);
    }
}
