<section class="section-hero overlay inner-page bg-image" style="background-image: url('/user/images/hero_2.jpg');" id="home-section">
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        @if(request()->is('job-vacancies') || request()->is('agriculture-jobs') || request()->is('fulltime-jobs') )
        <h1 class="text-white font-weight-bold">Job Vacancies</h1>
        <div class="custom-breadcrumbs">
          <a href="/">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>Job Vacancies</strong></span>
        </div>
        @endif
        @if(request()->is('testimonials'))
        <h1 class="text-white font-weight-bold">Testimonials</h1>
        <div class="custom-breadcrumbs">
          <a href="/">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>Testimonials</strong></span>
        </div>
        @endif
        @if(request()->is('about-us'))
        <h1 class="text-white font-weight-bold">About Us</h1>
        <div class="custom-breadcrumbs">
          <a href="/">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>About Us</strong></span>
        </div>
        @endif
        @if(request()->is('register'))
        <h1 class="text-white font-weight-bold">Register</h1>
        <div class="custom-breadcrumbs">
          <a href="/">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>Register</strong></span>
        </div>
        @endif
        @if(request()->is('register-as-recruiter'))
        <h1 class="text-white font-weight-bold">Sign Up</h1>
        <div class="custom-breadcrumbs">
          <a href="/">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>Sign Up as Recruiter</strong></span>
        </div>
        @endif
        @if(request()->is('login'))
        <h1 class="text-white font-weight-bold">Login</h1>
        <div class="custom-breadcrumbs">
          <a href="/">Home</a> <span class="mx-2 slash">/</span>
          <span class="text-white"><strong>Login</strong></span>
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
