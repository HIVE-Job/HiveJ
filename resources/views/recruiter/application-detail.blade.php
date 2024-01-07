@extends('recruiter.layouts.template')

@section('content')
@include('recruiter.layouts.hero-section-2')

<section class="site-section">
  <div class="container">

    <!-- Mini company profile -->
    <div class="row align-items-center mb-5">
      <div class="col-lg-8 mb-4 mb-lg-0">
        <div class="d-flex align-items-center">
          <div class="border p-2 d-inline-block mr-3 rounded">
            <img src="{{ asset('/user/images/' . $application->job->owner->pfp)}}" alt="Image" style="height:150px; width:150px;">
          </div>
          <div>
            <h2>Job Title</h2>
            <div>
              <span class="ml-0 mr-2 mb-2"><span class="icon-briefcase mr-2"></span>{{ $application->job->owner->name}}</span>
              <span class="m-2"><span class="icon-room mr-2"></span> {{$application->job->owner->address}}</span>
              <span class="m-2"><span class="icon-clock-o mr-2"></span><span class="text-primary">{{$application->job->job_type}}</span></span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Job details section -->
    <div class="row">
      <div class="col-lg-8">
        <div class="mb-5">
          <!-- Job illustration image -->
          <figure class="mb-5"><img src="{{ asset('/user/images/job/' . $application->job->image)}}" alt="Image" class="img-fluid rounded"></figure>
          <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-align-left mr-3"></span>Job Description</h3>
          {!! $application->job->job_description !!}
        </div>

        <!-- Applicant's profile summary -->
        <div class="mb-5">
          <h3 class="h5 d-flex align-items-center mb-4 text-primary"><span class="icon-turned_in mr-3"></span>Applicant Information</h3>
          <div class="row mb-5">
            <div class="col-4">
              <img src="{{ asset('/user/images/' . $application->applicant->pfp)}}" alt="Applicant's Photo" class="img-fluid rounded">
            </div>
            <div class="col-8">
              <div class="bg-light p-3 border rounded mb-4">
                <h3 class="text-primary mt-3 h5 pl-3 mb-3 ">Applicant Profile</h3>
                <ul class="list-unstyled pl-3 mb-0">
                  <li class="mb-2"><strong class="text-black">Application Status:</strong> &nbsp;
                    @if($application->application_status == "accepted")
                    <span class="badge badge-success">Accepted</span>
                    @elseif($application->application_status == "rejected")
                    <span class="badge badge-danger">Rejected</span>
                    @else
                    <span class="badge badge-success">Processed</span>
                    @endif
                  </li>
                  <li class="mb-2"><strong class="text-black">Name:</strong> &nbsp;{{$application->applicant->name}}</li>
                  <li class="mb-2"><strong class="text-black">Phone Number:</strong> &nbsp;{{$application->applicant->phone_number}}</li>
                  <li class="mb-2"><strong class="text-black">Email:</strong> &nbsp;{{$application->applicant->email}}</li>
                  <li class="mb-2"><strong class="text-black">Address:</strong> &nbsp;{{$application->applicant->address}}</li>
                  <li class="mb-2"><strong class="text-black">Skills:</strong>
                    @php $userSkills = $application->applicant->userskill @endphp
                    <ul class="list-unstyled m-0 p-0">
                      @foreach($userSkills as $userSkill)
                      <li class="d-flex align-items-start mb-2">
                        <span class="icon-check_circle mr-2 text-muted"></span><span>{{$userSkill->skill->skill_name}}</span> &nbsp;
                      </li>
                      @endforeach
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Action buttons based on application status -->
        @if($application->application_status != "accepted" && $application->application_status != "rejected")
        <div class="row mb-5">
          <div class="col-4">
            <a href="{{ url()->previous() }}" class="btn btn-block btn-light btn-md"><span class="fa fa-mail-reply"></span> &nbsp;Back</a>
          </div>
          <div class="col-4">
            <form action="{{route('r.update-application', ['id' => $application->id ])}}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="application_status" value="accepted">
              <input type="hidden" name="receiver_id" value="{{$application->applicant->id}}">
              <button type="submit" class="btn btn-block btn-danger-cs btn-md" onclick="return confirm('Are you sure you want to reject this application?')"><i class="fa fa-times-circle"></i> Reject Application</button>
            </form>
          </div>
          <div class="col-4">
            <form action="{{route('r.update-application', ['id' => $application->id ])}}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="application_status" value="accepted">
              <input type="hidden" name="receiver_id" value="{{$application->applicant->id}}">
              <button type="submit" class="btn btn-block btn-primary-cs btn-md" onclick="return confirm('Are you sure you want to accept this application?')"><i class="fa fa-check-circle"></i> Accept Application</button>
            </form>
          </div>
        </div>
        @elseif($application->application_status == "rejected")
        <div class="row mb-5">
          <div class="col-4">
            <a href="{{ url()->previous() }}" class="btn btn-block btn-light btn-md"><span class="fa fa-mail-reply"></span> &nbsp;Back</a>
          </div>
          <div class="col-4">
            <form action="{{route('r.update-application', ['id' => $application->id ])}}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="application_status" value="processed">
              <input type="hidden" name="receiver_id" value="{{$application->applicant->id}}">
              <button type="submit" class="btn btn-block btn-secondary btn-md text-black text-sm" onclick="return confirm('Are you sure you want to mark this application as processed?')"><i class="fa fa-clock-o text-black"></i> Mark as Processed</button>
            </form>
          </div>
          <div class="col-4">
            <form action="{{route('r.update-application', ['id' => $application->id ])}}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="application_status" value="accepted">
              <input type="hidden" name="receiver_id" value="{{$application->applicant->id}}">
              <button type="submit" class="btn btn-block btn-primary-cs btn-md" onclick="return confirm('Are you sure you want to accept this application?')"><i class="fa fa-check-circle"></i> Accept Application</button>
            </form>
          </div>
        </div>
        @elseif($application->application_status == "accepted")
        <div class="row mb-5">
          <div class="col-4">
            <a href="{{ url()->previous() }}" class="btn btn-block btn-light btn-md"><span class="fa fa-mail-reply"></span> &nbsp;Back</a>
          </div>
          <div class="col-4">
            <form action="{{route('r.update-application', ['id' => $application->id ])}}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="application_status" value="processed">
              <input type="hidden" name="receiver_id" value="{{$application->applicant->id}}">
              <button type="submit" class="btn btn-block btn-secondary btn-md text-black text-sm" onclick="return confirm('Are you sure you want to mark this application as processed?')"><i class="fa fa-clock-o text-black"></i> Mark as Processed</button>
            </form>
          </div>
          <div class="col-4">
            <form action="{{route('r.update-application', ['id' => $application->id ])}}" method="POST">
              @csrf
              @method('PUT')
              <input type="hidden" name="application_status" value="accepted">
              <input type="hidden" name="receiver_id" value="{{$application->applicant->id}}">
              <button type="submit" class="btn btn-block btn-danger-cs btn-md" onclick="return confirm('Are you sure you want to reject this application?')"><i class="fa fa-times-circle"></i> Reject Application</button>
            </form>
          </div>
        </div>
        @endif
      </div>

      <div class="col-lg-4">
        <div class="bg-light p-3 border rounded mb-4">
          <h3 class="text-primary mt-3 h5 pl-3 mb-3 ">Job Summary</h3>
          <ul class="list-unstyled pl-3 mb-0">
            <li class="mb-2"><strong class="text-black">Published on : <br></strong>
              {{ \Carbon\Carbon::parse($application->job->created_at)->locale('en')->formatLocalized('%d %B %Y') }}
            </li>
            <li class="mb-2"><strong class="text-black">Number of Employees Needed:</strong> <br>
              {{$application->job->vacancy}} People
            </li>
            <li class="mb-2"><strong class="text-black">Employment Status:</strong> <br>
              {{$application->job -> job_type}}
            </li>
            <li class="mb-2"><strong class="text-black">Job Status: </strong> <br>
              @if($application->job->job_status=="open") {{'Open'}}
              @else {{'Closed'}}
              @endif
            </li>
            <li class="mb-2"><strong class="text-black">Job Location:</strong><br> {{$application->job->location}}</li>
            <li class="mb-2"><strong class="text-black">Salary Offer:</strong> <br>{{$application->job->salary}}</li>
            <li class="mb-2"><strong class="text-black">Gender:</strong> <br>{{$application->job->gender}}</li>
            <li class="mb-2"><strong class="text-black">Application Deadline:</strong> <br>
              {{ \Carbon\Carbon::parse($application->job->deadline)->locale('en')->formatLocalized('%d %B %Y') }}
            </li>
          </ul>
        </div>

        <div class="bg-light p-3 border rounded">
          <h3 class="text-primary mt-3 h5 pl-3 mb-3">Share</h3>
          <div class="px-3">
            <a href="https://facebook.com" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-facebook"></span></a>
            <a href="https://twitter.com" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-twitter"></span></a>
            <a href="https://linkedin.com" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-linkedin"></span></a>
            <a href="https://pinterest.com" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-pinterest"></span></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
