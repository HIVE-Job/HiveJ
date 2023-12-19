@extends('admin.layout.template')
@section('content')
<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Job Management</h1>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="page-header float-right">
      <div class="page-title">
        <ol class="breadcrumb text-right">
          <li><a href="{{route('a.dashboard')}}">Home</a></li>
          <li class="active">Manage Jobs</li>
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
            <strong class="card-title">Job Listings</strong> ({{$total}})
          </div>
          <div class="card-body">
            <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
              <thead class="text-center">
                <tr>
                  <th>Job Title</th>
                  <th>Partner Information</th>
                  <th>Application Statistics</th>
                  <th colspan="3">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($jobs as $job)
                <tr>
                  <td>{{$job->job_title}}</td>
                  <td>
                    <strong>Partner Name:</strong> {{$job->owner->name}} <br>
                    <strong>Email:</strong> {{$job->owner->email}} <br>
                    <strong>Phone Number:</strong> {{$job->owner->phone_number}} <br>
                    <strong>Address:</strong> {{$job->owner->address}} <br>
                  </td>
                  <td class="col-3">
                    <strong>Total Applicants:</strong> {{$job->applications->count()}} <br>
                    <strong>Applications Accepted:</strong>
                    @php
                    $total = $job->applications()->where('application_status', 'accepted')->count();
                    @endphp
                    @if($total > 0){{ $total }}
                    @else 0
                    @endif

                    <br>
                    <strong>Applications Rejected:</strong>
                    @php
                    $total = $job->applications()->where('application_status', 'rejected')->count();
                    @endphp
                    @if($total > 0){{ $total }}
                    @else 0
                    @endif

                    <br>
                    <strong>Applications Processed:</strong>
                    @php
                    $total = $job->applications()->where('application_status', 'processed')->count();
                    @endphp
                    @if($total > 0){{ $total }}
                    @else 0
                    @endif
                    <br>

                    <strong>Status:</strong>
                    @if($job->job_status == 'open')
                    <span class="badge badge-sm badge-success">
                      Open
                    </span>
                    @elseif($job->job_status == 'closed')
                    <span class="badge badge-sm badge-danger">
                      Closed
                    </span>
                    @endif
                    <br>
                  </td>
                  <td>
                    <a href="{{route('a.vacancy', ['id'=> $job->id])}}" class="btn btn-warning btn-sm"><i class="menu-icon fa fa-pencil"></i> &nbsp;Edit</a>
                  </td>
                  <td>
                    <form action="{{route('a.delete_job', ['id'=> $job->id])}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this job? All applications for this job will also be deleted. Understand the consequences before you proceed.')"><i class="menu-icon fa fa-trash"></i> &nbsp;Delete</button>
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
              <a class="page-link" style="color: black;" href="{{ $jobs->previousPageUrl() }}" aria-label="Previous">
                Previous
              </a>
            </li>
            @foreach ($jobs->getUrlRange(1, $jobs->lastPage()) as $page => $url)
            <li class="page-item{{ $jobs->currentPage() == $page ? ' active' : '' }}">
              <a class="page-link" style="color: black;" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach
            <li class="page-item">
              <a class="page-link" style="color: black;" href="{{ $jobs->nextPageUrl() }}" aria-label="Next">
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
