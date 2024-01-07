@extends('admin.layout.template')
@section('content')
<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Job Application Management</h1>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="page-header float-right">
      <div class="page-title">
        <ol class="breadcrumb text-right">
          <li><a href="{{route('a.dashboard')}}">Home</a></li>
          <li class="active">Manage Applications</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="content mt-3">
  <div class="animated fadeIn">

    <div class="row">

      <div class="col-lg-4">
        <!-- APPLICANT PROFILE -->
        <div class="card">
          <div class="card-header">
            <strong class="card-title mb-3">Applicant Profile</strong>
          </div>
          <div class="card-body">
            <div class="mx-auto d-block">
              <img class="rounded-circle mx-auto d-block" src="{{asset('/user/images/' . $application->applicant->pfp)}}" alt="Card image cap" style="height:200px;width:200px;">
              <h5 class="text-sm-center mt-2 mb-1">{{$application->applicant->name}}</h5>
              <div class="text-sm-center"><i class="fa fa-envelope"></i> {{$application->applicant->email}}</div>
              <div class="text-sm-center"><i class="fa fa-map-marker"></i> {{$application->applicant->address}}</div>
              <div class="text-sm-center"><i class="fa fa-phone"></i> {{$application->applicant->phone_number}}</div>
            </div>
            <hr>
            <div class="card-text text-sm-center">
              <a href="#"><i class="fa fa-facebook pr-1"></i></a>
              <a href="#"><i class="fa fa-twitter pr-1"></i></a>
              <a href="#"><i class="fa fa-linkedin pr-1"></i></a>
              <a href="#"><i class="fa fa-pinterest pr-1"></i></a>
            </div>
          </div>
        </div>

        <!-- APPLICATION STATUS -->
        <div class="card mt-3">
          <div class="card-header">
            <strong>Application Status</strong>
            @if($application->application_status == 'accepted')
            <span class="badge badge-success badge md">Accepted</span>
            @elseif($application->application_status == 'rejected')
            <span class="badge badge-danger badge md">Rejected</span>
            @else
            <span class="badge badge-warning badge md">In Progress</span>
            @endif
          </div>
          <div class="card-body">
            <label for="select" class="form-control-label">Change Application Status</label>
            <div class="row">

              @if($application->application_status == 'accepted')
              <div class="col-3">
                <form action="{{route('a.update-application', ['id' => $application->id])}}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="status" value="rejected">
                  <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to reject this application? ')"><i class=" fa fa-times-circle"></i>&nbsp;Reject</button>
                </form>
              </div>
              <div class="col-3">
                <form action="{{route('a.update-application', ['id' => $application->id])}}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="status" value="processed">
                  <button class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to mark this application as in progress? ')"><i class="fa fa-spinner"></i>In Progress</button>
                </form>
              </div>
              @elseif($application->application_status == 'rejected')
              <div class="col-4">
                <form action="{{route('a.update-application', ['id' => $application->id])}}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="status" value="accepted">
                  <button class="btn btn-sm btn-success" type="submit" onclick="return confirm('Are you sure you want to accept this application? ')"><i class="fa fa-check-circle"></i>&nbsp;Accept</button>
                </form>
              </div>
              <div class="col-3">
                <form action="{{route('a.update-application', ['id' => $application->id])}}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="status" value="processed">
                  <button class="btn btn-sm btn-warning" type="submit" onclick="return confirm('Are you sure you want to mark this application as in progress? ')"><i class="fa fa-spinner"></i>&nbsp;In Progress</button>
                </form>
              </div>
              @else
              <div class="col-3">
                <form action="{{route('a.update-application', ['id' => $application->id])}}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="status" value="accepted">
                  <button class="btn btn-sm btn-success" type="submit" onclick="return confirm('Are you sure you want to accept this application? ')"><i class="fa fa-check-circle"></i>&nbsp;Accept</button>
                </form>
              </div>
              <div class="col-3">
                <form action="{{route('a.update-application', ['id' => $application->id])}}" method="POST">
                  @csrf
                  @method('PUT')
                  <input type="hidden" name="status" value="rejected">
                  <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to reject this application? ')"><i class="fa fa-times-circle"></i>&nbsp;Reject</button>
                </form>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>

      <!-- JOB INFORMATION -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <strong class="card-title mb-3">Applied Job Information</strong>
          </div>
          <div class="card-body">
            <div class="mx-auto d-block">
              <center>
                <img class="img-fluid" src="{{asset('/user/images/job/' . $application->job->image)}}" style="height:200px;width:360px;">
              </center>
              <h5 class="text-sm-center mt-2 mb-1">{{$application->job->job_title}}</h5>
            </div>
            <hr>
            <div class="card-text text-sm-start">
              <strong>Partner:</strong> {{$application->job->owner->name}}<br>
              <strong>Job Location:</strong> {{$application->job->location}}<br>
            </div>
            <div class="card-text text-sm-start">
              <br>
              <strong>Job Description:</strong><br>
              {!! $application->job->job_description !!}<br>

              <br>
              @if($application->job->responsibilities != null)
              <strong>Responsibilities / Job Desk:</strong><br>
              {!! $application->job->responsibilities !!}<br>
              @endif

              <br>
              @if($application->job->experience != null)
              <strong>Experience + Education:</strong><br>
              {!! $application->job->experience !!}<br>
              @endif

              <br>
              @if($application->job->benefits != null)
              <strong>Other Benefits:</strong><br>
              {!! $application->job->benefits!!}<br>
              @endif

              <br>
              <strong>Offered Salary:</strong><br>
              {{$application->job->salary}}<br><br>

              <strong>Number of Vacancies:</strong><br>
              {{$application->job->vacancy}}<br><br>

              <strong>Job Category:</strong><br>
              {{$application->job->job_category}}<br><br>

              <strong>Deadline:</strong><br>
              {{ \Carbon\Carbon::parse($application->job->deadline)->locale('en')->formatLocalized('%d %B %Y') }}<br><br>

              <strong>Job Status:</strong><br>
              @if($application->job->job_status == 'open')
              <div class="badge badge-success btn-lg">Open</div>
              @elseif($application->job->job_status == 'closed')
              <div class="badge badge-danger btn-lg">Closed</div>
              @endif
              <br>
            </div>
          </div>
          <div class="card-footer justify-content-end">
            <a href="{{url()->previous()}}" class="btn btn-lg btn-light"><i class="fa fa-mail-reply"></i>Back</a>
          </div>
        </div>
      </div>
    </div>

  </div><!-- .animated -->
</div><!-- .content -->
@endsection
