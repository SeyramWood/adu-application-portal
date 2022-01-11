<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Applicant;
use App\Models\Subscriber;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use App\Traits\ApplicantTrait;

class DashboardController extends Controller
{
    use ApplicantTrait;

    public function index()
    {
        return inertia('Dashboard', [
            'applicantCount' => fn () => $this->countApplicants(),
            'latestApplicants' => fn () => $this->getApplicants(3),
            'latestReviewedApplicants' => fn () => $this->getReviewedApplicants(3),
            'subscribers' => fn () => $this->getSubscribers(3),
        ]);
    }
    public function applicants()
    {
        return inertia('Applicant/Applicants', [
            'applicants' => fn () => $this->getApplicants(),
        ]);
    }
    public function reviewedApplicants()
    {
        return inertia('Applicant/ReviewedApplicants', [
            'applicants' => fn () => $this->getReviewedApplicants(),
        ]);
    }
    public function subscribers()
    {
        return inertia('Website/Subscribers', [
            'subscribers' => fn () => $this->getSubscribers(),
        ]);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email:filter|unique:subscribers,email'
        ]);
        Subscriber::create($request->all());
        return response()->json(['ok' => true]);
    }
}
