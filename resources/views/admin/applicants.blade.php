@extends('admin.layout.template')
@section('content')
<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>User Management</h1>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="page-header float-right">
      <div class="page-title">
        <ol class="breadcrumb text-right">
          <li><a href="{{route('a.dashboard')}}">Home</a></li>
          <li class="active">Manage Applicants</li>
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
            <strong class="card-title">List of Users</strong>
            ({{$total}})
          </div>
          <div class="card-body">
            <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
              <thead class="text-center">
                <tr>
                  <th>Applicant Name</th>
                  <th>Summary Information</th>
                  <th>Applications Accepted</th>
                  <th colspan="2">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($candidates as $candidate)
                <tr>
                  <td>{{$candidate->name}}</td>
                  <td>
                    <strong>Email:</strong> {{$candidate->email}} <br>
                    <strong>Phone Number:</strong>
                    @if($candidate->phone_number != null)
                    {{$candidate->phone_number}}
                    @else
                    Not registered
                    @endif
                    <br>
                    <strong>Address:</strong>
                    @if($candidate->phone_number != null)
                    {{$candidate->address}}
                    @else
                    Not registered
                    @endif
                    <br>
                    <br>
                  </td>
                  @php($nb = $candidate->applications->where('application_status','accepted')->count())
                  <td>{{$nb}}</td>
                  <td>
                    <a href="{{route('a.applicant', ['id'=> $candidate->id])}}" class="btn btn-warning btn-md"><i class="menu-icon fa fa-pencil"></i> &nbsp;Edit</a>
                  </td>
                  <td>
                    <form action="{{route('a.delete_candidate', ['id'=> $candidate->id])}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-md" onclick="return confirm('Are you sure you want to delete this candidate? Please note that all applications made by this user will also be permanently deleted. Understand the consequences of this action before you proceed.')"><i class="menu-icon fa fa-trash"></i> &nbsp;Delete</button>
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
              <a class="page-link" style="color: black;" href="{{ $candidates->previousPageUrl() }}" aria-label="Previous">
                Previous
              </a>
            </li>
            @foreach ($candidates->getUrlRange(1, $candidates->lastPage()) as $page => $url)
            <li class="page-item{{ $candidates->currentPage() == $page ? ' active' : '' }}">
              <a class="page-link" style="color: black;" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach
            <li class="page-item">
              <a class="page-link" style="color: black;" href="{{ $candidates->nextPageUrl() }}" aria-label="Next">
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
