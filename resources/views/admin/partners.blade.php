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
          <li class="active">Manage Partners</li>
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
            <strong class="card-title">List of Partners</strong> ({{$total}})
          </div>
          <div class="card-body">
            <table id="bootstrap-data-table-export" class="table table-striped table-bordered">
              <thead class="text-center">
                <tr>
                  <th>Partner Name</th>
                  <th>Profile Summary</th>
                  <th>Jobs Provided</th>
                  <th colspan="2">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($partners as $partner)
                <tr>
                  <td>{{$partner->name}}</td>
                  <td>
                    <strong>Email :</strong> {{$partner->email}} <br>
                    <strong>Phone :</strong>
                    @if($partner->phone_number != null ) {{$partner->phone_number}}
                    @else -
                    @endif
                    <br>
                    <strong>Address :</strong>
                    @if($partner->address != null ) {{$partner->address}}
                    @else -
                    @endif
                    <br>
                  </td>
                  <td>
                    @php $nb = $partner->jobs->count() @endphp
                    {{$nb}}
                  </td>
                  <td>
                    <a href="{{route('a.partner', ['id'=> $partner->id])}}" class="btn btn-warning btn-md"><i class="menu-icon fa fa-pencil"></i> &nbsp;Edit</a>
                  </td>
                  <td>
                    <form action="{{route('a.delete_partner', ['id'=> $partner->id])}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this partner? All jobs and job applications associated with this partner will also be deleted. Understand this consequence before you delete the partner.')"><i class="menu-icon fa fa-trash"></i> &nbsp;Delete</button>
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
              <a class="page-link" style="color: black;" href="{{ $partners->previousPageUrl() }}" aria-label="Previous">
                Previous
              </a>
            </li>
            @foreach ($partners->getUrlRange(1, $partners->lastPage()) as $page => $url)
            <li class="page-item{{ $partners->currentPage() == $page ? ' active' : '' }}">
              <a class="page-link" style="color: black;" href="{{ $url }}">{{ $page }}</a>
            </li>
            @endforeach
            <li class="page-item">
              <a class="page-link" style="color: black;" href="{{ $partners->nextPageUrl() }}" aria-label="Next">
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
