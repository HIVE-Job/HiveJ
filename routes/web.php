<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RecruiterController;

Route::get('/register-as-recruiter', [GuestController::class, 'register']);
Route::get('/', [GuestController::class, 'index'])->name('welcome');
Route::get('/vacancy/{id}', [GuestController::class, 'get_vacancy'])->name('g.vacancy');
Route::get('/vacancy', [GuestController::class, 'get_vacancies'])->name('g.vacancies');
Route::get('/search', [GuestController::class, 'searchVacancies'])->name('g.search');
Route::get('/vacancy-freelancer', [GuestController::class, 'get_freelancer_vacancies'])->name('g.freelancer-vacancies');
Route::get('/vacancy-fulltime', [GuestController::class, 'get_fulltime_vacancies'])->name('g.fulltime-vacancies');
Route::get('/about-us', function () {
    return view('guest.about');
})->name('g.about');
Route::get('/testimoni', function () {
    return view('guest.testimoni');
})->name('g.testimonial');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('a.dashboard');
    Route::get('admin/manage-admins', [AdminController::class, 'get_admins'])->name('a.admins');
    Route::get('admin/manage-partners', [AdminController::class, 'get_partners'])->name('a.partners');
    Route::get('admin/manage-applicants', [AdminController::class, 'get_applicants'])->name('a.applicants');
    Route::get('admin/manage-applicant/{id}', [AdminController::class, 'get_applicant'])->name('a.applicant');
    Route::get('admin/manage-admin/{id}', [AdminController::class, 'get_admin'])->name('a.admin');
    Route::get('admin/manage-partner/{id}', [AdminController::class, 'get_partner'])->name('a.partner');
    Route::put('admin/manage-admin/{id}', [AdminController::class, 'update_user'])->name('a.update-admin');
    Route::put('admin/manage-partner/{id}', [AdminController::class, 'update_user'])->name('a.update-partner');
    Route::put('admin/manage-applicant/{id}', [AdminController::class, 'update_user'])->name('a.update-candidate');
    Route::delete('/admin/manage-admin/{id}/delete', [AdminController::class, 'delete_user'])->name('a.delete_admin');
    Route::delete('/admin/manage-partner/{id}/delete', [AdminController::class, 'delete_user'])->name('a.delete_partner');
    Route::delete('/admin/manage-applicant/{id}/delete', [AdminController::class, 'delete_user'])->name('a.delete_candidate');
    Route::get('admin/manage-job-vacancies', [AdminController::class, 'get_vacancies'])->name('a.vacancies');
    Route::get('admin/manage-job-vacancy/{id}', [AdminController::class, 'get_vacancy'])->name('a.vacancy');
    Route::delete('admin/manage-job-vacancy/{id}', [AdminController::class, 'delete_job'])->name('a.delete_job');
    Route::put('/admin/manage-job-vacancy/{id}', [AdminController::class, 'update_job'])->name('a.update-vacancy');
    Route::get('admin/manage-job-applications', [AdminController::class, 'get_applications'])->name('a.applications');
    Route::get('admin/manage-job-application/{id}', [AdminController::class, 'get_application'])->name('a.application');
    Route::put('admin/manage-job-application/{id}', [AdminController::class, 'update_application'])->name('a.update-application');
    Route::delete('admin/manage-job-application/{id}', [AdminController::class, 'delete_application'])->name('a.delete_application');
    Route::get('admin/profile', [AdminController::class, 'get_profile'])->name('a.profile');
    Route::put('/admin/profile', [AdminController::class, 'update_profile'])->name('a.update-profile');
    Route::get('/admin/create-admin', [AdminController::class, 'create_admin'])->name('a.create_admin');
    Route::post('/admin/create-admin', [AdminController::class, 'store_new_admin'])->name('a.store_new_admin');
});


Route::middleware('auth', 'recruiter')->group(function () {
    Route::get('/recruiter/homepage', [RecruiterController::class, 'index'])->name('r.homepage');
Route::get('/recruiter/job', [RecruiterController::class, 'create_new_job']);
Route::get('/recruiter/job/{id}', [RecruiterController::class, 'get_vacancy'])->name('r.vacancy');
Route::post('/recruiter/job', [RecruiterController::class, 'store_new_job'])->name('r.create_new_job');
Route::get('/recruiter/manage-job-vacancies', [RecruiterController::class, 'show_job_vacancies'])->name('r.show_vacancies');
    Route::get('/recruiter/manage-job-applications', [RecruiterController::class, 'show_applications'])->name('r.show_applications');
    Route::get('/recruiter/manage-job-vacancies/{id}', [RecruiterController::class, 'edit_job'])->name('r.edit_job');
    Route::patch('/recruiter/manage-job-vacancies/{id}', [RecruiterController::class, 'update_job'])->name('r.update-job');
    Route::delete('/recruiter/manage-job-vacancies/{id}/delete', [RecruiterController::class, 'delete_job'])->name('r.delete_job');
    Route::get('/recruiter/notifikasi', [RecruiterController::class, 'get_notifications'])->name('r.notifications');
    Route::get('/recruiter/manage-job-applications/{id}', [RecruiterController::class, 'application'])->name('r.application-detail');
    Route::put('/recruiter/manage-job-applications/{id}', [RecruiterController::class, 'update_application'])->name('r.update-application');
    Route::get('/recruiter/profile', [RecruiterController::class, 'get_profile'])->name('r.profile');
    Route::patch('/recruiter/profile', [RecruiterController::class, 'update_profile'])->name('r.update-profile');
    Route::post('/recruiter/notifikasi', [RecruiterController::class, 'mark_as_read'])->name('r.mark-as-read');

});

Route::middleware('auth', 'user')->group(function () {
    Route::get('/user/homepage', [UserController::class, 'index'])->name('u.homepage');
    Route::get('/user/vacancy', [UserController::class, 'get_vacancies'])->name('u.vacancies');
    Route::get('/user/vacancy-freelancer', [UserController::class, 'get_freelancer_vacancies'])->name('u.freelancer-vacancies');
    Route::get('/user/vacancy-fulltime', [UserController::class, 'get_fishery_vacancies'])->name('u.fulltime-vacancies');
    Route::get('/user/vacancy/{id}', [UserController::class, 'get_vacancy'])->name('u.vacancy');
    Route::get('/user/application', [UserController::class, 'get_applications'])->name('u.applications');
    Route::get('/user/notifikasi', [UserController::class, 'get_notifications'])->name('u.notifications');
    Route::get('/user/profile', [UserController::class, 'get_profile'])->name('u.profile');
    Route::post('/user/application', [UserController::class, 'create_application'])->name('u.apply');
    Route::post('/user/notifikasi', [UserController::class, 'mark_as_read'])->name('u.mark-as-read');
    Route::delete('/user/application/{id}/delete', [UserController::class, 'delete_application'])->name('u.delete-application');
    Route::delete('/user/skill/{id}/delete', [UserController::class, 'delete_skill'])->name('u.delete-skill');
    Route::patch('/user/profile', [UserController::class, 'update_profile'])->name('u.update-profile');
    Route::post('/user/create-skill', [UserController::class, 'create_skill'])->name('u.create-skill');
    Route::post('/user/create-skill/v2', [UserController::class, 'create_skill_2'])->name('u.create-skill-2');
    Route::post('editcv', [UserController::class, 'updateCV'])->name('update.cv');
    Route::get('/user/view-cv',[UserController::class, 'viewCV'])->name('view.cv');
});

require __DIR__ . '/auth.php';
