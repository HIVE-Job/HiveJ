<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RecruiterTest extends TestCase
{
     

    /**
     * @test
     */
    public function it_can_store_new_job(): void
    {
        $this->withoutMiddleware();

        // Create a new recruiter manually
        $recruiter = new User();
        $recruiter->name = 'Test Recruiter';
        $recruiter->email = 'testrecruiter12345@example.com';
        $recruiter->password = bcrypt('password');
        $recruiter->role = 2;  // Set the role to 2 for recruiter
        $recruiter->save();

        $this->actingAs($recruiter);

        $jobData = [
            'job_title' => 'Test Job',
            'job_description' => 'This is a test job description. It is designed to be long enough to pass the validation rules.',
            'job_category' => 'fulltime',
            'location' => 'SriLanka',
            'job_type' => 'part-time',
            'responsibilities' => 'Test Responsibilities',
            'experience' => 'Test Experience',
            'benefits' => 'Test Benefits',
            'vacancy' => 5,
            'salary' => 'Test Salary',
            'gender' => 'Male',
            'deadline' => now()->addDays(7)->format('Y-m-d'),
            'job_owner_id' => $recruiter->id,
        ];

        $response = $this->post(route('r.create_new_job'), $jobData);

        $response->assertRedirect(route('r.show_vacancies'));
        $this->assertDatabaseHas('jobs', ['job_title' => 'Test Job']);
    }
}


