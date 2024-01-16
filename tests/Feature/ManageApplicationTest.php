<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Application;
use App\Models\Job;
use App\Models\Notification;

class ManageApplicationTest extends TestCase
{
    

   
    public function it_can_show_applications(): void
    {
        $this->withoutMiddleware();
 
        $recruiter = new User();
        $recruiter->name = 'Test Recruiter';
        $recruiter->email = 'testrecruiter123455@example.com';
        $recruiter->password = bcrypt('password');
        $recruiter->role = 2;   
        $recruiter->save();

        $this->actingAs($recruiter);

        $response = $this->get(route('r.show_applications'));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_can_show_application_detail(): void
    {
        $this->withoutMiddleware();

        
        $recruiter = new User();
        $recruiter->name = 'Test Recruiter';
        $recruiter->email = 'testrecruiter12345611@example.com';
        $recruiter->password = bcrypt('password');
        $recruiter->role = 2;   
        $recruiter->save();

       
        $application = new Application();
        $application->job_id = 2;  
        $application->applicant_id = 8;   
        $application->application_status = 'pending';
        $application->save();

        $this->actingAs($recruiter);

        $response = $this->get(route('r.application-detail', ['id' => $application->id]));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function it_can_update_application(): void
    {
        $this->withoutMiddleware();

         
        $recruiter = new User();
        $recruiter->name = 'Test Recruiter';
        $recruiter->email = 'testrecruiter1234568@example.com';
        $recruiter->password = bcrypt('password');
        $recruiter->role = 2;   
        $recruiter->save();

         
        $application = new Application();
        $application->job_id = 2;   
        $application->applicant_id = 8;   
        $application->application_status = 'pending';
        $application->save();

        $this->actingAs($recruiter);

        $response = $this->put(route('r.update-application', ['id' => $application->id]), [
            'application_status' => 'accepted',
            'receiver_id' => $application->applicant_id,
        ]);

        $response->assertRedirect(route('r.show_applications'));
        $this->assertDatabaseHas('applications', ['id' => $application->id, 'application_status' => 'accepted']);
    }

    /**
     * @test
     */
}
