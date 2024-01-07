@extends('job-seeker.layouts.template')

@section('content')
@include('job-seeker.layouts.hero-section-2')  
<section class="site-section">
  <div class="container">
    <!-- MAIN CONTENT -->
    <h2 class="section-title mb-2 text-center">My Job Applications</h2>
    @if(session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Success!</strong>  {{session('status')}}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if($applications->count() == 0) 
      <h3 class="text-center">
        <span class="badge badge-danger">
          You haven't applied to any job postings yet.
        </span>
      </h3>
      <br>
      <div class="row mb-5 justify-content-center">
        <div class="col-md-7 text-center">
          <a href="{{url('/user/jobs')}}" class="btn btn-primary-cs border-width-2 d-none d-lg-inline-block"><i class="fa fa-search"></i> Search for Jobs </a>
        </div>
      </div>
    @else
      <table class="table table-striped table-bordered">
        <thead class="text-center">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Job Title</th>
            <th scope="col-2">Job Summary</th>
            <th scope="col">Application Status</th>
            <th colspan="3" class="text-center" scope="col-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach($applications as $application)
          <tr>
            <th scope="row">{{$i}}</th>
            <td>{{$application->job->job_title }} </td>
            <td>
              <strong>Company:</strong>  {{$application->job->owner->name }} <br>
              <strong>Location:</strong>  {{$application->job->location }} <br>
              <strong> Application Deadline :</strong> {{ \Carbon\Carbon::parse($application->job->deadline)->locale('en')->formatLocalized('%d %B %Y') }} <br>
              <strong>Employment Status :</strong>  {{$application->job->job_type}} <br>
              <strong>Offered Salary : </strong> {{$application->job->salary}} <br>
            </td>
            <td>
              @if($application->application_status == "accepted")
                <span class="badge badge-success">Accepted</span>
              @elseif($application->application_status == "rejected")
                <span class="badge badge-danger">Rejected</span>
              @else
                <span class="badge badge-warning">In Progress</span>
              @endif
            </td>
            @if($application->application_status != "accepted" && $application->application_status != "rejected")
            <td class="text-start">
              <form action="{{ route('u.delete-application', ['id' => $application->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="application_id" value="{{$application->id}}">
                <button class="btn btn-danger-cs" type="submit" onclick="return confirm('Are you sure you want to cancel your application? Your application is still being processed by the company!')"><i class="fa fa-times-circle"></i> Cancel Application</button>
              </form>
            </td>
            <td class="text-start">
              <a href="{{route('u.vacancy', ['id' => $application->job->id ])}}" class="btn btn-success text-black"><i class="fa fa-external-link"></i>&nbsp;View Details</a>
            </td>
            @else 
            <td colspan=2 class="text-start">
              <a href="{{route('u.vacancy', ['id' => $application->job->id ])}}" class="btn btn-success text-black"><i class="fa fa-external-link"></i>&nbsp;View Details</a>
            </td>
            @endif
          </tr>
          @php $i++; @endphp
          @endforeach
        </tbody>
      </table>
    @endif

    <div class="row pagination-wrap">
      <div class="col-md-12 text-center text-md-right">
        <div class="custom-pagination ml-auto">
          @if ($applications->onFirstPage())
            <a class="prev disabled">Prev</a>
          @else
            <a href="{{ $applications->previousPageUrl() }}" class="prev">Prev</a>
          @endif
            
          <div class="d-inline-block">
            @foreach ($applications->getUrlRange(1, $applications->lastPage()) as $page => $url)
              <a href="{{ $url }}" class="{{ $page == $applications->currentPage() ? 'active' : '' }}">{{ $page }}</a>
            @endforeach
          </div>
            
          @if ($applications->hasMorePages())
            <a href="{{ $applications->nextPageUrl() }}" class="next">Next</a>
          @else
            <a class="next disabled">Next</a>
          @endif
        </div>
      </div>
    </div>
  </section>
@endsection
