<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\User;
use App\Models\Job;
use App\Models\Notification;
use Carbon\Carbon;
use App\Rules\DeadlineValidationRule;
use Illuminate\Validation\Rule;

class RecruiterController extends Controller
{
  public function index()
  {
    $company_id = Auth::id();
    $posted_job = Job::where("job_owner_id", $company_id)->count();
    $app1 = Application::where('application_status', 'accepted')
      ->whereHas('Job', function ($query) use ($company_id) {
        $query->where('job_owner_id', $company_id);
      })
      ->count();
    $app2 = Application::where('application_status', 'processed')
      ->whereHas('Job', function ($query) use ($company_id) {
        $query->where('job_owner_id', $company_id);
      })
      ->count();

    $app3 = Application::where('application_status', 'rejected')
      ->whereHas('Job', function ($query) use ($company_id) {
        $query->where('job_owner_id', $company_id);
      })
      ->count();

    $listed_jobs = Job::where('job_owner_id', $company_id)
      ->orderBy('created_at', 'asc')
      ->paginate(10);

    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('recruiter.homepage', compact('posted_job', 'app1', 'app2', 'app3', 'listed_jobs', 'unread_notif'));
  }

  // JOB MANAGEMENT
  public function show_job_vacancies()
  {
    $vacancies = Job::where('job_owner_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('recruiter.manage-job-vacancies', compact('vacancies', 'unread_notif'));
  }

  public function get_vacancy($id)
  {
    $vacancy = Job::find($id);
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    $responsibilities = $vacancy->responsibilities;

    $responsibilities = str_replace('<ol>', '<ul class="list-unstyled m-0 p-0">', $responsibilities);
    $responsibilities = str_replace('</ol>', '</ul>', $responsibilities);
    $responsibilities = str_replace('<li>', '<li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span>', $responsibilities);

    $experience = $vacancy->experience;
    $experience = str_replace('<ol>', '<ul class="list-unstyled m-0 p-0">', $experience);
    $experience = str_replace('</ol>', '</ul>', $experience);
    $experience = str_replace('<li>', '<li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span>', $experience);

    $benefits = $vacancy->benefits;
    $benefits = str_replace('<ol>', '<ul class="list-unstyled m-0 p-0">', $benefits);
    $benefits = str_replace('</ol>', '</ul>', $benefits);
    $benefits = str_replace('<li>', '<li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span>', $benefits);

    return view('recruiter.vacancy', compact('vacancy', 'responsibilities', 'experience', 'benefits', 'unread_notif'));
  }

  public function create_new_job()
  {
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('recruiter.create_new_job', compact('unread_notif'));
  }

  public function store_new_job(Request $request)
  {
    $request->validate([
      'job_title'         => 'required|min:5|max:64',
      'job_description'   => 'required|min:64',
      'job_category'      => 'required',
      'location'          => 'required|min:5|max:128',
      'job_type'          => 'required',
      'responsibilities'  => 'nullable|min:5',
      'experience'        => 'nullable|min:5',
      'benefits'          => 'nullable|min:5',
      'vacancy'           => 'required|min:1',
      'salary'            => 'required|min:5',
      'gender'            => 'required',
      'deadline'          => ['required', new DeadlineValidationRule],
      'image'             => 'image|mimes:jpeg,jpg,png|max:4096'
    ]);

    $currentTime = Carbon::now();

    $job = new Job();
    $job->job_title = $request->job_title;
    $job->job_description = $request->job_description;
    $job->job_category = $request->job_category;
    $job->location = $request->location;
    $job->job_owner_id = $request->job_owner_id;
    $job->job_status = "open";
    $job->job_type  = $request->job_type;
    $job->responsibilities = $request->responsibilities;
    $job->experience = $request->experience;
    $job->benefits = $request->benefits;
    $job->vacancy = $request->vacancy;
    $job->salary = $request->salary;
    $job->gender = $request->gender;
    $job->deadline = $request->deadline;
    $job->created_at = $currentTime;
    $job->updated_at = $currentTime;

    if ($request->hasFile('image')) {
      $location = public_path('/user/images/job');
      $request->file('image')->move($location, $request->file('image')->getClientOriginalName());
      $job->image = $request->file('image')->getClientOriginalName();
    }
    $job->save();

    return redirect('/recruiter/manage-job-vacancies')->with('status', 'Job vacancy added successfully!');
  }

  public function edit_job($id)
  {
    $job = Job::find($id);
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('recruiter.edit_job', compact('job', 'unread_notif'));
  }

  public function update_job(Request $request, $id)
  {
    $job = Job::findOrFail($id);

    $validatedData = $request->validate([
      'job_title'         => 'required|min:5|max:64',
      'job_description'   => 'required|min:64',
      'job_category'      => 'required',
      'job_status'        => 'required',
      'location'          => 'required|min:5|max:128',
      'job_type'          => 'required',
      'responsibilities'  => 'nullable|min:5',
      'experience'        => 'nullable|min:5',
      'benefits'          => 'nullable|min:5',
      'vacancy'           => 'required|min:1',
      'salary'            => 'required|min:3',
      'gender'            => 'required',
      'deadline'          => ['required', new DeadlineValidationRule],
      'image'             => 'image|mimes:jpeg,jpg,png|max:4096'
    ]);

    $job->update($validatedData);

    if ($request->hasFile('image')) {
      $location = public_path('/user/images/job');
      $existingFile = $location . '/' . $job->image;
      if (file_exists($existingFile)) {
        unlink($existingFile);
      }
      $request->file('image')->move($location, $request->file('image')->getClientOriginalName());
      $job->image = $request->file('image')->getClientOriginalName();
    }

    $job->save();
    return redirect('/recruiter/manage-job-vacancies')->with('status', 'Job vacancy has been updated.');
  }

  public function delete_job($id)
  {
    $applications = Application::where('job_id', $id)->get();

    foreach ($applications as $application) {
      $notif = new Notification;
      $notif->receiver_id = $application->applicant_id;
      $notif->notification_title = "Notification of job deletion.";
      $notif->notification_text = "Your application for the job " . $application->job->job_title . " provided by partner " . Auth::user()->name . " has been canceled because this job was deleted by the partner for certain reasons.";
      $notif->status = "Unread";
      $notif->save();
    }

    Application::where('job_id', $id)->delete();
    Job::find($id)->delete();
    return redirect('/recruiter/manage-job-vacancies')->with('status', "Post successfully deleted.");
  }

  // APPLICATION MANAGEMENT
  public function show_applications()
  {
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    $id = Auth::id();
    $applications = Application::whereHas('Job', function ($query) use ($id) {
      $query->where('job_owner_id', $id);
    })->get();
    return view('recruiter.manage-job-applications', compact('applications', 'unread_notif'));
  }

  public function application($id)
  {
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    $application = Application::where('id', $id)->first();
    return view('recruiter.application-detail', compact('application', 'unread_notif'));
  }

  public function update_application(Request $request, $id)
  {
    $application = Application::find($id);
    $job = Job::find($application->job_id);
    $application->application_status = $request->application_status;
    $application->save();

    if ($request->application_status == 'accepted' || $request->application_status == 'rejected') {
      $notif = new Notification;
      $notif->receiver_id = $request->receiver_id;
      if ($request->application_status == 'accepted') {
        $notif->notification_title = "Congratulations! Your application has been accepted.";
        $notif->notification_text = "Your application for the job " . $job->job_title . " provided by partner " . Auth::user()->name . " has been accepted. Check your email and WhatsApp regularly for further information.";
      } else if ($request->application_status == 'rejected') {
        $notif->notification_title = "Oh no! Your application has been rejected.";
        $notif->notification_text = "Your application for the job " . $job->job_title . " provided by partner " . Auth::user()->name . " has been rejected. Don't give up! There are other jobs you can try. Good luck!";
      }
      $notif->status = "Unread";
      $notif->save();
    }
    return redirect()->route('r.show_applications')->with('status', 'Application status updated successfully.');
  }

  // NOTIFICATIONS
  public function get_notifications()
  {
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    $notifications = Notification::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->paginate(20);
    return view('recruiter.notifications', compact('notifications', 'unread_notif'));
  }

  public function mark_as_read(Request $request)
  {
    $rcv_id = $request->receiver_id;
    $notifications = Notification::where('receiver_id', $rcv_id)->where('status', 'Unread')->get();

    foreach ($notifications as $notification) {
      $notification->status = 'Read';
      $notification->save();
    }

    return redirect()->route('r.notifications');
  }
  // END NOTIFICATIONS

  // PROFILE
  public function get_profile()
  {
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('recruiter.profile', compact('unread_notif'));
  }

  public function update_profile(Request $request)
  {
    $request->validate([
      'name' => 'required|min:5|max:64',
      'address' => 'required|min:3',
      'phone_number' => [
        'required',
        Rule::unique('users', 'phone_number')->ignore(Auth::user()->id),
        'min:12',
        'max:15',
      ],
      'image' => 'image|mimes:jpeg,jpg,png|max:4096',
    ]);

    $user = User::find(Auth::user()->id);

    $user->name = $request->name;
    $user->address = $request->address;
    $user->phone_number = $request->phone_number;

    if ($request->hasFile('pfp')) {
      $location = public_path('/user/images');
      $existingFile = $location . '/' . $user->pfp;
      if (file_exists($existingFile)) {
        unlink($existingFile);
      }
      $request->file('pfp')->move($location, $request->file('pfp')->getClientOriginalName());
      $user->pfp = $request->file('pfp')->getClientOriginalName();
    }

    $user->save();
    return redirect()->route('r.profile')->with('status', 'Profile has been updated!');
  }
  // END PROFILE
}

