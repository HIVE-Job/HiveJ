<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class GuestCanViewJobsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testGuestCanViewJobs()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('http://localhost:8000/')  
                    ->assertSee('Job Offers')
                    ->assertSee('Open Positions Still Available')
                    ->assertVisible('.job-listing');
        });
    }

    public function testGuestCanViewJobDetails()
{
    $this->browse(function (Browser $browser) {
        $browser->visit('http://localhost:8000/vacancy/2')
                ->assertSee('Job Summary')
                ->assertSee('Job Description')
                ->assertSee('Responsibilities')
                ->assertSee('Application Deadline');
                
    });
}

}
