<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Learner;
use App\Models\Certification;
use App\Models\Question;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_learners' => Learner::count(),
            'active_learners' => Learner::where('status', 'active')->count(),
            'total_users' => User::count(),
            'certifications' => Certification::count(),
            'questions' => Question::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
