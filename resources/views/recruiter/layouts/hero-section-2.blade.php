<section class="section-hero overlay inner-page bg-image" style="background-image: url('/user/images/hero_3.jpeg');" id="home-section">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                @if(request()->is('/recruiter/job'))
                <h1 class="text-white font-weight-bold">Create Job Vacancy</h1>
                <div class="custom-breadcrumbs">
                    <a href="{{__('r.homepage')}}">Home</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong>Create New Job Vacancy</strong></span>
                </div>
                @endif

                @if(request()->is('/recruiter/manage-job-vacancies') || request()->is('/recruiter/manage-job-vacancies/*'))
                <h1 class="text-white font-weight-bold">Manage Job Vacancies</h1>
                <div class="custom-breadcrumbs">
                    <a href="{{__('r.homepage')}}">Home</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong>Manage Job Vacancies</strong></span>
                </div>
                @endif

                @if(request()->is('/recruiter/notifikasi'))
                <h1 class="text-white font-weight-bold">Notifications</h1>
                <div class="custom-breadcrumbs">
                    <a href="{{__('r.homepage')}}">Home</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong>Notifications</strong></span>
                </div>
                @endif

                @if(request()->is('/recruiter/manage-job-applications') || request()->is('/recruiter/manage-job-applications/*'))
                <h1 class="text-white font-weight-bold">Manage Job Applications</h1>
                <div class="custom-breadcrumbs">
                    <a href="{{__('r.homepage')}}">Home</a> <span class="mx-2 slash">/</span>
                    <span class="text-white"><strong>Manage Job Applications</strong></span>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

