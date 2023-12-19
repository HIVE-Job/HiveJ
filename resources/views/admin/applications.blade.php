@extends('admin.layout.template')
@section('content')
<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Application Management</h1>
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
      @if(session('status'))
      <div class="col-sm-12">
        <div class="alert  alert-success alert-dismissible fade show" role="alert">
          <span class="badge badge-pill badge-success">Success</span> {{session('status')}}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      @endif
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">List of Applications</strong> ({{$total}})
          </div>
          <div class="card-body">
            <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
              <thead class="text-center">
                <tr>
                  <th>Applicant Name</th>
                  <th>Applicant Summary</th>
                  <th class="col-3">Job Summary</th>
                  <th class="col-2">Application Status</th>
                  <th colspan="3">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($applications as $application)
                <tr>
                  <td>{{$application->applicant->name}}</td>
                  <td>
                    <strong>Email:</strong> {{$application->applicant->email}} <br>
                    <strong>Phone :</strong> {{$application->applicant->phone_number}} <br>
                    <strong>Address :</strong> {{$application->applicant->address}} <br>
                  </td>
                  <td>
                    <strong>Partner:</strong> {{$application->job->owner->name}} <br>
                    <strong>Job Category:</strong> {{$application->job->job_category}} <br>
                    <strong>Deadline:</strong> {{ \Carbon\Carbon::parse($application->job->deadline)->locale('en')->formatLocalized('%d %B %Y') }}<br>
                    <strong>Job Status:</strong>
                    @if($application->job->job_status == 'open')
                    <div class="badge badge-success badge-md">Open</div>
                    @elseif($application->job->job_status == 'closed')
                    <div class="badge badge-danger badge-md">Closed</div>
                    @endif
                    <br>
                  </td>
                  <td>
                    @if($application->application_status == 'accepted')
                    <div class="badge badge-success badge-sm">
                      Accepted
                    </div>
                    @elseif($application->application_status == 'rejected')
                    <div class="badge badge-danger badge-sm">
                      Rejected
                    </div>
                    @else
                    <div class="badge badge-warning badge-sm">
                      In Progress
                    </div>
                    @endif
                  </td>
                  <td>
                    <a href="{{route('a.application', ['id'=> $application->id])}}" class="btn btn-warning btn-md"><i class="menu-icon fa fa-pencil"></i> &nbsp;Edit</a>
                  </td>
                  <td>
                    <form action="{{route('a.delete_application', ['id'=> $application->id])}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-md" onclick="return confirm('Are you sure you want to delete this application? ')"><i class="menu-icon fa fa-trash"></i> &nbsp;Delete</button>
                    </form>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 text-right">
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-end">
            <li class="page-item">
              <a class="page-link" style="color: black;" href="{{ $applications->previousPageUrl() }}" aria-label="Previous">
                Previous
              </a>
            </li>
            @foreach ($applications->getUrlRange(1, $applications->lastPage()) as $page => $url)
            <li class="page-item{{ $applications->currentPage() == $page ? ' active' : '' }}">
              <a class="page-link" style="color: black;" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach
            <li class="page-item">
              <a class="page-link" style="color: black;" href="{{ $applications->nextPageUrl() }}" aria-label="Next">
                Next
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div><!-- .animated -->
</div> <!-- .content -->
@endsection
