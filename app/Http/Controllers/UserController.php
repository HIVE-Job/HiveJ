<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\User;
use App\Models\Job;
use App\Models\Skill;
use App\Models\UserSkill;
use App\Models\Notification;
use Carbon\Carbon;
use App\Rules\DeadlineValidationRule;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use File;


class UserController extends Controller
{
  public function index()
  {
    $posted_job     = Job::where("job_status", "open")->count();
    $candidates     = User::where("role", 3)->count();
    $filled_job     = Application::where('application_status', 'accepted')->count();
    $companies      = User::where("role", 2)->count();
    $listed_jobs    = Job::orderBy('created_at', 'desc')
      ->paginate(10);
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    $job_total = Job::count();
    return view('job-seeker.homepage', compact('posted_job', 'candidates', 'filled_job', 'companies', 'listed_jobs', 'unread_notif', 'job_total'));
  }

  public function get_vacancies()
  {
    $vacancies = Job::orderBy('created_at', 'desc')->paginate(25);
    $vacancies_total = Job::count();
    $available_vacancies = Job::where('job_status', 'open')->count();
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('job-seeker.vacancies', compact('vacancies', 'vacancies_total', 'available_vacancies', 'unread_notif'));
  }

  public function get_vacancy($id)
  {
    $vacancy = Job::find($id);

    // Replace the <ol> tags with the desired HTML code
    $responsibilities = $vacancy->responsibilities;

    $responsibilities = str_replace('<ol>', '<ul class="list-unstyled m-0 p-0">', $responsibilities);
    $responsibilities = str_replace('</ol>', '</ul>', $responsibilities);
    $responsibilities = str_replace('<li>', '<li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span>', $responsibilities);

    // Retrieve the content from the database
    $experience = $vacancy->experience;

    // Replace the <ol> tags with the desired HTML code
    $experience = str_replace('<ol>', '<ul class="list-unstyled m-0 p-0">', $experience);
    $experience = str_replace('</ol>', '</ul>', $experience);
    $experience = str_replace('<li>', '<li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span>', $experience);

    // Retrieve the content from the database
    $benefits = $vacancy->benefits;

    // Replace the <ol> tags with the desired HTML code
    $benefits = str_replace('<ol>', '<ul class="list-unstyled m-0 p-0">', $benefits);
    $benefits = str_replace('</ol>', '</ul>', $benefits);
    $benefits = str_replace('<li>', '<li class="d-flex align-items-start mb-2"><span class="icon-check_circle mr-2 text-muted"></span>', $benefits);
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('job-seeker.vacancy', compact('vacancy', 'unread_notif', 'responsibilities', 'experience', 'benefits'));
  }

  public function get_applications()
  {
    $applications = Application::where('applicant_id', Auth::id())->paginate(20);
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('job-seeker.applications', compact('applications', 'unread_notif'));
  }

  public function get_notifications()
  {
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    $notifications = Notification::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->paginate(20);
    return view('job-seeker.notifications', compact('notifications', 'unread_notif'));
  }

  public function get_profile()
  {
    $userSkills = Auth::user()->userskill;
    $registeredSkills = $userSkills->pluck('skill_id')->toArray();
    $skills = Skill::whereNotIn('id', $registeredSkills)->get();
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();

    return view('job-seeker.profile', compact('userSkills', 'skills', 'unread_notif'));
  }


  public function get_freelancer_vacancies()
  {
    $vacancies = Job::where('job_category', 'freelancer')->orderBy('created_at', 'desc')->paginate(25);
    $vacancies_total = Job::where('job_category', 'freelancer')->count();
    $available_vacancies = Job::where('job_category', 'freelancer')->where('job_status', 'open')->count();
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('job-seeker.vacancies-freelancer', compact('vacancies', 'vacancies_total', 'available_vacancies', 'unread_notif'));
  }

  public function get_fulltime_vacancies()
  {
    $vacancies = Job::where('job_category', 'fulltime')->orderBy('created_at', 'desc')->paginate(25);
    $vacancies_total = Job::where('job_category', 'fulltime')->count();
    $available_vacancies = Job::where('job_category', 'fulltime')->where('job_status', 'open')->count();
    $unread_notif = Notification::where('receiver_id', Auth::id())->where('status', 'Unread')->count();
    return view('job-seeker.vacancies-fulltime', compact('vacancies', 'vacancies_total', 'available_vacancies', 'unread_notif'));
  }

  public function create_application(Request $request)
  {
    // Create and save the application
    $application = new Application;
    $application->applicant_id = $request->applicant_id;
    $application->job_id = $request->job_id;
    $application->application_status = "processed";
    $application->save();

    $job = Job::find($request->job_id);

    $notif = new Notification;
    $notif->receiver_id = $request->company_id;
    $notif->notification_title = "Application by " . Auth::user()->name;
    $notif->notification_text = "A new application for the job " . $job->job_title . " has been received. The application is marked as processed. Please manage your applications regularly.";
    $notif->status = "Unread";
    $notif->save();

    // Redirect back to the previously accessed link
    return redirect()->back();
  }

  public function mark_as_read(Request $request)
  {
    $rcv_id = $request->receiver_id;
    $notifications = Notification::where('receiver_id', $rcv_id)->where('status', 'Unread')->get();

    foreach ($notifications as $notification) {
      $notification->status = 'Read';
      $notification->save();
    }

    return redirect()->route('u.notifications');
  }

  public function delete_application($id)
  {
    Application::where('id', $id)->delete();
    return redirect('/user/application')->with('status', "Application has been deleted.");
  }

  public function update_profile(Request $request)
  {
    // Validate the request
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

    // Update user data
    $user->name = $request->name;
    $user->address = $request->address;
    $user->phone_number = $request->phone_number;

    if ($request->hasFile('pfp')) {
      // Define image location in the local path
      $location = public_path('/user/images/');

      // Delete the existing file
      $existingFile = $location . '/' . $user->pfp;
      if (file_exists($existingFile)) {
        unlink($existingFile);
      }

      // Take the image file and save it to the local server
      $request->file('pfp')->move($location, $request->file('pfp')->getClientOriginalName());

      // Save the file name in the database
      $user->pfp = $request->file('pfp')->getClientOriginalName();
    }

    // Save the updated user
    $user->save();

    // Redirect or return a response
    // You can modify this based on your application's needs
    return redirect()->route('u.profile')->with('status', 'Profile has been updated!');
  }

  public function create_skill(Request $request)
  {
    // Validate the request
    $request->validate([
      'skill_id' => 'required',
    ]);

    $userSkill = new UserSkill();
    $userSkill->skill_id  = $request->skill_id;
    $userSkill->user_id   =  Auth::user()->id;
    $userSkill->save();

    return redirect('/user/profile')->with('status', "One skill has been added to your profile.");
  }

  public function create_skill_2(Request $request)
  {
    // Validate the request
    $request->validate([
      'skill_name' => 'required|min:3|max:64',
    ]);

    $skill = new Skill;
    $skill->skill_name = $request->skill_name;
    $skill->save();

    $userSkill = new UserSkill();
    $userSkill->skill_id  = $skill->id;
    $userSkill->user_id   =  Auth::user()->id;
    $userSkill->save();

    return redirect('/user/profile')->with('status', "One skill has been added to your profile.");
  }

  public function delete_skill($id)
  {
    UserSkill::where('skill_id', $id)->delete();
    return redirect('/user/profile')->with('status', "One skill has been removed from your profile.");
  }

  public function updateCV(Request $request){

    $oldCV = User::find(Auth::user()->id);


    if(File::exists(public_path('assets/cvs/'.$oldCV->cv))){
        File::delete(public_path('assets/cvs/'.$oldCV->cv));
    }else{

    }



        $destinationPath = 'assets/cvs/';
        $mycv = $request->cv->getClientOriginalName();
        $request->cv->move(public_path($destinationPath),$mycv);

        $oldCV->update([

            "cv" => $mycv
        ]);

        return redirect('/user/profile/')->with('update','CV updated successfully');


       }

public function viewCV()
{
    $user = Auth::user();

    if ($user->cv) {
        $cvPath = public_path('assets/cvs/' . $user->cv);

        if (file_exists($cvPath)) {

            return response()->file($cvPath);
        } else {

            return response()->json(['error' => 'CV not found'], 404);
        }
    } else {

        return response()->json(['error' => 'CV not available for this user'], 404);
    }
}

}

