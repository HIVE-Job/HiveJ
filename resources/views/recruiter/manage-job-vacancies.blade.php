@extends('recruiter.layouts.template')

@section('content')
  @include('recruiter.layouts.hero-section-2')
  <section class="site-section">
    <div class="container">
      <!-- MAIN CONTENT -->
      <h2 class="section-title mb-2 text-center">Manage Job Vacancies</h2>
      @if($vacancies->count() == 0)
        <h3 class="text-center">No job vacancies posted yet.</h3>
        <br>
        <div class="row mb-5 justify-content-center">
          <div class="col-md-8 text-center">
            <a href="{{__('/recruiter/pekerjaan')}}" class="btn btn-primary-cs border-width-2 d-none d-lg-inline-block text-black"><i class="fa fa-plus"></i> Post Job Vacancy </a>
          </div>
        </div>
      @else
        <div class="row mb-5 justify-content-center">
          <div class="col-md-8 text-center">
            @if(session('status'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{session('status')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            <a href="{{__('/recruiter/pekerjaan')}}" class="btn btn-primary-cs border-width-2 d-none d-lg-inline-block text-black"><i class="fa fa-plus"></i> Post Job Vacancy </a>
          </div>
        </div>
        <table class="table table-bordered border-success table-striped">
          <thead class="text-center">
            <tr>
              <th scope="col">No</th>
              <th scope="col">Job Title</th>
              <th scope="col-2">Job Summary</th>
              <th scope="col-2">Number of Applicants</th>
              <th colspan="3" class="text-center" scope="col-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            @php $i = 1; @endphp
            @foreach($vacancies as $vacancy)
              <tr>
                <th scope="row">{{$i}}</th>
                <td>{{ $vacancy->job_title }} </td>
                <td>
                  <strong>Location:</strong> {{ $vacancy->location }} <br>
                  <strong>Application Deadline:</strong> {{ \Carbon\Carbon::parse($vacancy->deadline)->locale('id')->formatLocalized('%d %B %Y') }} <br>
                  <strong>Employment Status:</strong> {{ $vacancy->job_type}} <br>
                  <strong>Salary Offered:</strong> {{$vacancy->salary}} <br>
                </td>
                <td>{{ $vacancy->applications->count()}} Applicants </td>
                <td class="text-center">
                  <a href="{{route('r.edit_job',['id' => $vacancy->id ]) }}" class="btn btn-warning text-black"><i class="fa fa-pencil"></i>&nbsp;Edit</a>
                </td>
                <td class="text-center">
                  <form action="{{ route ('r.delete_job', ['id' => $vacancy->id ]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger-cs" type="submit" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-trash"></i>&nbsp;Delete</button>
                  </form>
                </td>
                <td class="text-center">
                  <a href="{{ route ('r.vacancy', ['id' => $vacancy->id ]) }}" class="btn btn-success text-black"><i class="fa fa-external-link"></i>&nbsp;Preview</a>
                </td>
              </tr>
              @php $i++; @endphp
            @endforeach
          </tbody>
        </table>
      @endif
    </div>
  </section>
@endsection
