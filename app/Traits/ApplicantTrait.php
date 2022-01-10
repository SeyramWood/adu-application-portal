<?php

namespace App\Traits;

use App\Models\Review;
use App\Models\Applicant;
use App\Models\Subscriber;
use App\Models\Subscribers;
use Illuminate\Console\Application;

/**
 * ApplicantTrait
 */
trait ApplicantTrait
{
  public function countApplicants()
  {
    return [];
    return [
      'total' => Applicant::count(),
      'inProgress' => Applicant::whereNotIn('status', ['completed'])->count(),
      'completed' => Applicant::whereIn('status', ['completed'])->count(),
      'scholarship' => Applicant::where('scholarship', '!=', '')->count(),
      'reviewed' => Review::count()
    ];
  }

  public function getApplicants($limit = null)
  {
    return [];
    if ($limit) {
      return Applicant::select('id', 'first_name', 'last_name', 'email', 'desired_major')
        ->limit($limit)
        ->orderByDesc('id')->get();
    }
    return Applicant::select('id', 'first_name', 'last_name', 'email', 'contact_number', 'desired_major')
      ->orderByDesc('id')->get();
  }
  public function getReviewedApplicants($limit = null)
  {
    return [];
    if ($limit) {
      return Review::join('applicants', 'applicants.id', '=', 'reviews.applicant_id')
        ->where('applicants.scholarship', '!=', '')
        ->select(
          'reviews.id',
          'reviews.reviewer_name',
          'applicants.first_name',
          'applicants.last_name',
          'applicants.email',
          'applicants.contact_number',
          'applicants.desired_major'
        )
        ->limit($limit)
        ->orderByDesc('reviews.id')->get();
    }
    return Review::join('applicants', 'applicants.id', '=', 'reviews.applicant_id')
      ->where('applicants.scholarship', '!=', '')
      ->select(
        'reviews.id',
        'reviews.reviewer_name',
        'applicants.first_name',
        'applicants.last_name',
        'applicants.gender',
        'applicants.date_of_birth',
        'applicants.email',
        'applicants.contact_number',
        'applicants.desired_major',
        'applicants.city',
        'applicants.citizenship',
        'applicants.authentication_code',
        'applicants.guardian_one_name',
        'applicants.guardian_one_email',
        'applicants.guardian_one_phone_number',
        'applicants.guardian_two_name',
        'applicants.guardian_two_email',
        'applicants.guardian_two_phone_number',
      )
      ->limit($limit)
      ->orderByDesc('reviews.id')->get();
  }

  public function filterApplicants($keys)
  {
    $terms = explode(',', $keys);
    $status = [];
    $scholarship = null;
    $reviewed = null;
    foreach ($terms as  $value) {
      if ($value === 'In-Progress') {
        array_push($status, '');
      }
      if ($value === 'Completed') {
        array_push($status, 'completed');
      }
      if ($value === 'Scholarship') {
        $scholarship = true;
      }
      if ($value === 'Reviewed') {
        $reviewed = true;
      }
    }
    // dd($status, $scholarship, $reviewed);
    if ($reviewed) {
      if ($scholarship) {
        if (count($status)) {
          return Review::join('applicants', 'applicants.id', '=', 'reviews.applicant_id')
            ->whereIn('applicants.status', $status)
            ->where('applicants.scholarship', '!=', '')
            ->select(
              'reviews.id',
              'reviews.reviewer_name',
              'applicants.first_name',
              'applicants.last_name',
              'applicants.email',
              'applicants.contact_number',
              'applicants.desired_major'
            )
            ->orderByDesc('reviews.id')->get();
        }
        return Review::join('applicants', 'applicants.id', '=', 'reviews.applicant_id')
          ->where('applicants.scholarship', '!=', '')
          ->select(
            'reviews.id',
            'reviews.reviewer_name',
            'applicants.first_name',
            'applicants.last_name',
            'applicants.email',
            'applicants.contact_number',
            'applicants.desired_major'
          )
          ->orderByDesc('reviews.id')->get();
      }
      return Review::join('applicants', 'applicants.id', '=', 'reviews.applicant_id')
        ->select(
          'reviews.id',
          'reviews.reviewer_name',
          'applicants.first_name',
          'applicants.last_name',
          'applicants.email',
          'applicants.contact_number',
          'applicants.desired_major'
        )
        ->orderByDesc('reviews.id')->get();
    } elseif ($scholarship) {
      if (count($status)) {
        return Applicant::whereIn('status', $status)
          ->where('scholarship', '!=', '')
          ->select('id', 'first_name', 'last_name', 'email', 'contact_number', 'desired_major')
          ->orderByDesc('id')->get();
      }
      return Applicant::where('scholarship', '!=', '')
        ->select('id', 'first_name', 'last_name', 'email', 'contact_number', 'desired_major')
        ->orderByDesc('id')->get();
    } else {
      return Applicant::whereIn('status', $status)
        ->select('id', 'first_name', 'last_name', 'email', 'contact_number', 'desired_major')
        ->orderByDesc('id')->get();
    }
  }

  public function getSubscribers($limit = null)
  {
    if ($limit) {
      return Subscriber::limit($limit)
        ->orderByDesc('id')->get();
    }
    return Subscriber::all();
  }
}
