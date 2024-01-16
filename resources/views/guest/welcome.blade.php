@extends('guest.layouts.template')

@section('content')
@include('guest.layouts.hero-section')
<!-- Site Statistics -->
<section class="py-5 bg-image overlay-primary fixed overlay" id="next" style="background-image: url('user/images/hero_1.jpg');">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-2 text-white">HIVE Site Statistics</h2>
        <p class="lead text-white">Here is the number of jobs, applicants, accepted applications, and partners who have joined Hive.</p>
      </div>
    </div>
    <div class="row pb-0 block__19738 section-counter">

      <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
        <div class="d-flex align-items-center justify-content-center mb-2">
          <strong class="number" data-number="{{$candidates}}">0</strong>
        </div>
        <span class="caption">Applicants</span>
      </div>

      <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
        <div class="d-flex align-items-center justify-content-center mb-2">
          <strong class="number" data-number="{{$job_total}}">0</strong>
        </div>
        <span class="caption">Job Offers</span>
      </div>

      <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
        <div class="d-flex align-items-center justify-content-center mb-2">
          <strong class="number" data-number="{{$filled_job}}">0</strong>
        </div>
        <span class="caption">Applications Accepted</span>
      </div>

      <div class="col-6 col-md-6 col-lg-3 mb-5 mb-lg-0">
        <div class="d-flex align-items-center justify-content-center mb-2">
          <strong class="number" data-number="{{$companies}}">0</strong>
        </div>
        <span class="caption">Partners/Companies</span>
      </div>

    </div>
  </div>
</section>
<!-- End of Site Statistics -->


<section class="site-section">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-md-7 text-center">
        <h2 class="section-title mb-2">{{$job_total}} Job Offers</h2>
        <span class="badge badge-success mb-3">
          <h2>{{$open_job}} Open Positions Still Available</h2>
        </span>
      </div>
    </div>



    <!-- job list -->
    <ul class="job-listings mb-5">
      @foreach($listed_jobs as $listed_job)
      <li class="job-listing d-block d-sm-flex pb-3 pb-sm-0 align-items-center">
        <a href="{{route('g.vacancy', ['id'=>$listed_job->id])}}"></a>
        <div class="job-listing-logo">
          <img src="{{ asset('user/images/job/' . $listed_job->image) }}" alt="company_logo" class="img-fluid">
        </div>
        <div class="job-listing-about d-sm-flex custom-width w-100 justify-content-between mx-4">
          <div class="job-listing-position custom-width w-50 mb-3 mb-sm-0">
            <h2>{{$listed_job->job_title}}</h2>
            <strong>{{$listed_job->owner->name}}</strong>
          </div>
          <div class="job-listing-location mb-3 mb-sm-0 custom-width w-25">
            <span class="icon-room"></span> {{$listed_job->location}}
          </div>
          <div class="job-listing-meta">
            @if($listed_job->job_status == "closed")
            <span class="badge badge-danger">{{$listed_job->job_status}}</span>
            @else
            <span class="badge badge-success">{{$listed_job->job_status}}</span>
            @endif
          </div>
        </div>
      </li>
      @endforeach
    </ul>
    <!-- end of job list -->

    <!-- pagination -->
    <div class="row pagination-wrap">
      <div class="col-md-6 text-center text-md-left mb-4 mb-md-0">
        <span>{{ (($listed_jobs->currentPage() - 1) * $listed_jobs->perPage()) + 1 }}-
          {{ min($listed_jobs->currentPage() * $listed_jobs->perPage(), $job_total) }} Of {{$job_total}} Jobs</span>
      </div>
      <div class="col-md-6 text-center text-md-right">
        <div class="custom-pagination ml-auto">
          @if ($listed_jobs->onFirstPage())
          <a class="prev disabled">Prev</a>
          @else
          <a href="{{ $listed_jobs->previousPageUrl() }}" class="prev">Prev</a>
          @endif

          <div class="d-inline-block">
            @foreach ($listed_jobs->getUrlRange(1, $listed_jobs->lastPage()) as $page => $url)
            <a href="{{ $url }}" class="{{ $page == $listed_jobs->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
          </div>

          @if ($listed_jobs->hasMorePages())
          <a href="{{ $listed_jobs->nextPageUrl() }}" class="next">Next</a>
          @else
          <a class="next disabled">Next</a>
          @endif
        </div>
      </div>
    </div>
    <!-- end of pagination -->
  </div>
</section>

<!-- Another Sign-Up Hero -->
<section class="py-5 bg-image overlay-primary fixed overlay" style="background-image: url('user/images/hero_1.jpg');">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h2 class="text-white">Need a Job?</h2>
        <p class="mb-0 text-white lead">Register your account and get a job that matches your skills.</p>
      </div>
      <div class="col-md-3 ml-auto">
        <a href="/register" class="btn btn-warning btn-block btn-lg">Sign Up Now</a>
      </div>
    </div>
  </div>
</section>
<!-- End of Another Sign-Up Hero -->



<!-- Short Partner Testimonial -->
<section class="bg-light pt-5 testimony-full">
  <div class="owl-carousel single-carousel">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center text-center text-lg-left">
          <blockquote>
            <p>&ldquo;Almost like with the selected, easily refused, unknown troubles, accusations of free pains, they reject it in pain, working towards those who experience the pleasures of repudiation.&rdquo;</p>
            <p><cite> &mdash; Corey Woods, @Dribbble</cite></p>
          </blockquote>
        </div>
        <div class="col-lg-6 align-self-end text-center text-lg-right">
          <img src="user/images/person_transparent_2.png" alt="Image" class="img-fluid mb-0">
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-lg-6 align-self-center text-center text-lg-left">
          <blockquote>
            <p>&ldquo;Almost like with the selected, easily refused, unknown troubles, accusations of free pains, they reject it in pain, working towards those who experience the pleasures of repudiation.&rdquo;</p>
            <p><cite> &mdash; Chris Peters, @Google</cite></p>
          </blockquote>
        </div>
        <div class="col-lg-6 align-self-end text-center text-lg-right">
          <img src="user/images/person_transparent.png" alt="Image" class="img-fluid mb-0">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End of Short Partner Testimonial -->

@endsection
