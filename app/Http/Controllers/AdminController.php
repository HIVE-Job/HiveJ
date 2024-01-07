<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Application;
use App\Models\Job;
use App\Models\UserSkill;
use App\Models\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $partners = User::where('role', 2)->count();
        $candidates = User::where('role', 3)->count();
        $jobs = Job::count();
        $apps = Application::count();
        $employed = Application::where('application_status', 'accepted')->count();
        $open = Job::where('job_status', 'open')->count();

        $today = Carbon::today()->toDateString(); // Get the current date in the format 'Y-m-d'

        $new_users = User::whereDate('created_at', $today)->count();
        return view('admin.dashboard', compact('partners', 'candidates', 'jobs', 'apps', 'employed', 'open', 'new_users'));
    }

    // USER MANAGEMENT
    public function get_admins()
    {
        $admins = User::where('role', 1)->orderBy('created_at', 'desc')->paginate(20);
        $total = User::where('role', 1)->count();
        return view('admin.admins', compact('admins', 'total'));
    }

    public function get_admin($id)
    {
        $admin = User::find($id);
        return view('admin.admin', compact('admin'));
    }

    public function create_admin()
    {
        return view('admin.add_admin');
    }

    public function store_new_admin(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'pfp' => 'image|mimes:jpeg,jpg,png|max:4096',
        ]);

        $admin = new User();
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->role = 1;
        if ($request->hasFile('pfp')) {
            // Define image location in local path
            $location = public_path('/user/images/');

            // Take the image file and save it to the local server
            $request->file('pfp')->move($location, $request->file('pfp')->getClientOriginalName());

            // Save the file name in the database
            $admin->pfp = $request->file('pfp')->getClientOriginalName();
        }

        $admin->save();
        return redirect()->route('a.admins')->with('status', 'A new admin has been successfully added.');
    }

    public function get_partners()
    {
        $partners = User::where('role', 2)->orderBy('created_at', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
        $total = User::where('role', 2)->count();
        return view('admin.partners', compact('partners', 'total'));
    }

    public function get_partner($id)
    {
        $partner = User::find($id);
        return view('admin.partner', compact('partner'));
    }

    public function get_applicants()
    {
        $candidates = User::where('role', 3)->orderBy('created_at', 'desc')->paginate(25);
        $total = User::where('role', 3)->count();
        return view('admin.applicants', compact('candidates', 'total'));
    }

    public function get_applicant($id)
    {
        $candidate = User::find($id);
        return view('admin.applicant', compact('candidate'));
    }

    public function update_user(Request $request, $id)
    {
        $user = User::find($id);
        $old_role = $user->role;
        $request->validate([
            'name' => 'required|min:5|max:64',
            'address' => 'nullable|min:3',
            'phone_number' => [
                'nullable',
                Rule::unique('users', 'phone_number')->ignore($user->id),
                'min:12',
            ],
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($user->id),
                'min:8',
                'max:64',
            ],
            'role' => 'required',
        ]);

        // Handle case if the user is a candidate but after updating, the role is not a candidate anymore
        // Delete their application and userskills first
        if ($old_role == 3 && $request->role != 3) {
            Application::where('applicant_id', $user->id)->delete();
            UserSkill::where('user_id', $user->id)->delete();
        } elseif ($old_role == 2 && $request->role != 2) {
            // Handle case if the user is a partner but after updating, the role is not a partner anymore
            // Delete all applications toward the jobs they've made, and then delete all related jobs before updating their role
            $jobs = Job::where('job_owner_id', $user->id)->get();
            if (!empty($jobs)) {
                foreach ($jobs as $job) {
                    Application::where('job_id', $job->id)->delete();
                    $job->delete();
                }
            }
        }

        // Update the user attributes with the validated data
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->role = $request->role;
        $user->save();

        if ($user->role == 1) {
            return redirect()->route('a.admins')->with('status', 'User successfully updated.');
        } elseif ($user->role == 2) {
            return redirect()->route('a.partners')->with('status', 'User successfully updated.');
        } else {
            return redirect()->route('a.applicants')->with('status', 'User successfully updated.');
        }
    }





  public function delete_user(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        // Handle the case when the user with the given ID is not found
        return redirect()->back()->with('status', 'User not found.');
    }

    if ($user->role == 1) {
        // Handle the case when the user is an admin
        $user->delete();
        return redirect()->route('a.admins')->with('status', 'User has been deleted.');
    } elseif ($user->role == 2) {
        // Handle the case when the user is a partner
        $jobs = Job::where('job_owner_id', $id)->get();

        foreach ($jobs as $job) {
            Application::where('job_id', $job->id)->delete();
            $job->delete();
        }

        $user->delete();
        return redirect()->route('a.partners')->with('status', 'User has been deleted.');
    } else {
        // Handle the case when the user is an applicant
        Application::where('applicant_id', $id)->delete();
        UserSkill::where('user_id', $id)->delete();
        $user->delete();

        return redirect()->route('a.applicants')->with('status', 'User has been deleted.');
    }
}
// END USER MANAGEMENT

// JOB MANAGEMENT
public function get_vacancies()
{
    $jobs = Job::orderBy('created_at', 'desc')->orderBy('updated_at', 'desc')->paginate(25);
    $total = Job::count();
    return view('admin.vacancies', compact('jobs', 'total'));
}

public function get_vacancy($id)
{
    $job = Job::find($id);
    return view('admin.vacancy', compact('job'));
}

public function update_job(Request $request, $id)
{
    // Retrieve the job based on the provided ID
    $job = Job::find($id);

    // Create notification for partner
    $notif = new Notification;
    $notif->receiver_id = $job->owner->id;
    $notif->notification_title = "Notification: Job Update";
    $notif->notification_text = "Your job with the title " . $job->job_title . " has been updated by AquaTani administrator. Please wait for further confirmation or contact AquaTani administrator for more information.";
    $notif->save();

    // Update the job attributes with the validated data
    $job->job_title = $request->job_title;
    $job->job_description = $request->job_description;
    $job->job_category = $request->job_category;
    $job->job_status = $request->job_status;
    $job->location = $request->location;
    $job->job_type = $request->job_type;
    $job->responsibilities = $request->responsibilities;
    $job->experience = $request->experience;
    $job->benefits = $request->benefits;
    $job->vacancy = $request->vacancy;
    $job->salary = $request->salary;
    $job->gender = $request->gender;
    $job->deadline = $request->deadline;

    if ($request->hasFile('image')) {
        // Define the image location on the local path
        $location = public_path('/user/images/job');

        // Delete the existing file
        $existingFile = $location . '/' . $job->image;
        if (file_exists($existingFile)) {
            unlink($existingFile);
        }

        // Move the uploaded image to the local server
        $request->file('image')->move($location, $request->file('image')->getClientOriginalName());

        // Store the image file name in the database
        $job->image = $request->file('image')->getClientOriginalName();
    }

    $job->save();

    return redirect()->route('a.vacancies')->with('status', 'Job has been updated.');
}

public function delete_job($id)
{
    $job = Job::find($id);
    $applications = Application::where('job_id', $id)->get();
    foreach ($applications as $application) {
        $j = Job::find($application->job->id);
        // Check if applicant_id exists and is not null
        if (!is_null($application->applicant_id)) {
            $notif = new Notification;
            $notif->receiver_id = $application->applicant_id;
            $notif->notification_title = "Notification: Job Deletion";
            $notif->notification_text = "Your application for the job " . $j->job_title . " provided by partner " . $j->owner->name . " has been canceled because this job has been deleted by AquaTani administrator. Contact the partner for more information.";
            $notif->save();
        }
    }

    // Notification to the partner
    $n = new Notification;
    $n->receiver_id = $job->owner->id;
    $n->notification_title = "Notification: Job Deletion";
    $n->notification_text = "The job " . $job->job_title . " you provided has been deleted by AquaTani administrator. Wait for detailed information from AquaTani or contact AquaTani for more information.";
    $n->save();

    // Delete the illustration photo
    $location = public_path('/user/images/job');

    // Delete the existing file
    $existingFile = $location . '/' . $job->image;
    if (file_exists($existingFile)) {
        unlink($existingFile);
    }

    Application::where('job_id', $id)->delete();
    Job::find($id)->delete();
    return redirect()->route('a.vacancies')->with('status', "Job has been deleted");
}
// END JOB MANAGEMENT

// APPLICATION MANAGEMENT
public function get_applications()
{
    $applications = Application::orderBy('created_at', 'desc')->orderBy('updated_at', 'desc')->paginate(10);
    $total = Application::count();
    return view('admin.applications', compact('applications', 'total'));
}

public function get_application($id)
{
    $application = Application::find($id);
    return view('admin.application', compact('application'));
}

public function update_application(Request $request, $id)
{
    $application = Application::find($id);
    $job = Job::find($application->job->id);
    $application->application_status = $request->status;
    $application->save();

    $notif = new Notification;
    $notif->receiver_id = $application->applicant_id;
    $notif->status = "Unread";

    if ($request->status == 'accepted') {
        $notif->notification_title = "Congratulations! Your application has been accepted.";
        $notif->notification_text = "Your application for the job " . $job->job_title . " by partner " . $job->owner->name . " has been accepted. Note that this acceptance is by AquaTani administrator. Please wait for further information directly from the partner or ask the job provider directly.";
        $notif->save();
    } else if ($request->status == 'rejected') {
        $notif->notification_title = "Oh no! Your application has been rejected.";
        $notif->notification_text = "Your application for the job " . $job->job_title . " by partner " . $job->owner->name . " has been rejected. Note that this rejection is by AquaTani administrator. Please wait for further information or ask the job provider directly.";
        $notif->save();
    }

    return redirect()->route('a.applications')->with('status', 'Application status has been updated.');
}

public function delete_application($id)
{
    $application = Application::find($id);
    $job = Job::find($application->job->id);

    $notif = new Notification;
    $notif->receiver_id = $application->applicant_id;
    $notif->notification_title = "Oh no! Your application for the job " . $job->job_title . " by partner " . $job->owner->name . " has been deleted by the administrator. Please contact the partner for more information.";
    Application::where('id', $id)->delete();
    return redirect()->route('a.applications')->with('status', "Job application has been deleted.");
}
// END APPLICATION MANAGEMENT

// PROFILE MANAGEMENT
public function get_profile()
{
    return view('admin.profile');
}

public function update_profile(Request $request)
{
    // Validate request
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
        // Define image location in local path
        $location = public_path('/user/images');

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
    return redirect()->route('a.profile')->with('status', 'Profile has been updated!');
}
// END PROFILE MANAGEMENT
}
