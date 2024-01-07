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
          <li class="active">Manage Job Vacancies</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="content mt-3">
  <div class="animated fadeIn">

    <div class="row justify-content-start">
      <a href="{{url()->previous()}}" class="btn btn-light btn-md"><i class="fa fa-mail-reply"></i>&nbsp;Back</a> &nbsp;&nbsp;
    </div>
    <br>
    <div class="row">
      <!-- DETAILED INFORMATION -->
      <div class="col-lg-8 col-md-6">
        <div class="card">
          <div class="card-header">
            <strong>Detailed Information about this Job Vacancy</strong>
          </div>
          <form action="{{route('a.update-vacancy', ['id'=> $job->id])}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body card-block">

              <!-- Illustration Image -->
              <div class="form-group">
                <label class=" form-control-label">Illustration Image</label> <br>
                <img src="{{ asset('../user/images/job/' . $job->image) }}" alt="{{$job->image}}"><br>
              </div>
              <div class="form-group">
                <label for="image" class="form-control-label">Change Image</label> <br>
                <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" name="image">
                @error('image')
                <div class="text-danger">{{$message}}</div>
                @enderror
              </div>

              <!-- Job Title -->
              <div class="form-group">
                <label class=" form-control-label" for="job_title">Job Title</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-bold"></i></div>
                  <input class="form-control  @error('job_title') is-invalid @enderror" id="job_title" name="job_title" value="{{old('job_title',$job->job_title)}}">
                  @error('job_title')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Job Description -->
              <div class="form-group">
                <label class=" form-control-label">Job Description</label>
                <div class="input-group">
                  <textarea name="job_description" id="desc" cols="30" rows="10" class="form-control @error('job_description') is-invalid @enderror">
                  {{$job->job_description}}
                  </textarea>
                  @error('job_description')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Responsibilities -->
              <div class="form-group">
                <label class=" form-control-label">Responsibilities / Job Desk</label>
                <div class="input-group">
                  <textarea name="responsibilities" class="@error('responsibilities') is-invalid @enderror" id="resp" cols="30" rows="10">
                  {{$job->responsibilities}}
                  </textarea>
                  @error('responsibilities')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Experience + Education -->
              <div class="form-group">
                <label class=" form-control-label">Experience + Education</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-graduation-cap"></i></div>
                  <textarea name="experience" id="exp" cols="30" rows="10" class="@error('experience') is-invalid @enderror">
                  {{$job->experience}}
                  </textarea>
                  @error('experience')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Benefits -->
              <div class="form-group">
                <label class=" form-control-label">Benefits</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-check-square"></i></div>
                  <textarea name="benefits" id="ben" cols="30" rows="10" class="@error('benefits') is-invalid @enderror">
                  {{$job->benefits}}
                  </textarea>
                  @error('benefits')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Job Location -->
              <div class="form-group">
                <label class=" form-control-label" for="location">Job Location</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-map-marker"></i></div>
                  <input class="form-control @error('location') is-invalid @enderror" value="{{$job->location}}" name="location" id="location">
                  @error('location')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Vacancy -->
              <div class="form-group">
                <label class=" form-control-label" for="vacancy">Number of Employees Needed</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-bar-chart"></i></div>
                  <input class="form-control @error('vacancy') is-invalid @enderror" value="{{old('vacancy', $job->vacancy)}}" name="vacancy" id="vacancy" type="number">
                  @error('vacancy')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Salary -->
              <div class="form-group">
                <label class=" form-control-label" for="salary">Offered Salary</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fa fa-dollar"></i></div>
                  <input class="form-control @error('salary') is-invalid @enderror" value="{{old('salary', $job->salary)}}" name="salary" id="salary">
                  @error('salary')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Gender -->
              <div class="row form-group">
                <div class="col col-md-3"><label for="gender" class=" form-control-label">Gender</label></div>
                <div class="col-12 col-md-9">
                  <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender">
                    <option value="male" @if($job->gender=='male') selected @endif>Male</option>
                    <option value="female" @if($job->gender=='female') selected @endif>Female</option>
                    <option value="not specified" @if($job->gender=='not specified') selected @endif>Not Specified</option>
                  </select>
                  @error('gender')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Job Status: Open/Closed -->
              <div class="row form-group">
                <div class="col col-md-3"><label for="job_status" class=" form-control-label">Job Status</label></div>
                <div class="col-12 col-md-9">
                  <select name="job_status" id="job_status" class="form-control @error('job_status') is-invalid @enderror" name="job_status">
                    <option value="open" @if($job->job_status=='open') selected @endif>Open</option>
                    <option value="closed" @if($job->job_status=='closed') selected @endif>Closed</option>
                  </select>
                  @error('job_status')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Job Category: Freelancer/Fulltime -->
              <div class="row form-group">
                <div class="col col-md-3"><label for="job_category" class=" form-control-label">Job Category</label></div>
                <div class="col-12 col-md-9">
                  <select name="job_category" id="job_category" class="form-control @error('job_category') is-invalid @enderror">
                    <option value="freelancer" @if($job->job_category=='freelancer') selected @endif>Freelancer</option>
                    <option value="fulltime" @if($job->job_category=='fulltime') selected @endif>Fulltime</option>
                  </select>
                  @error('job_category')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Deadline -->
              <div class="row form-group">
                <div class="col col-md-3"><label for="deadline" class="form-control-label">Deadline</label></div>
                <div class="col-12 col-md-9">
                  <input class="form-control @error('deadline') is-invalid @enderror" type="date" id="deadline" name="deadline" value="{{old('deadline', $job->deadline)}}">
                  @error('deadline')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- Submit Button -->
              <div class="text-md-center justify-content">
                <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> &nbsp;Save Changes</button>
              </div>
            </div>

          </form>
          <br><br><br>
        </div>
      </div>
      <!-- PARTNER PROFILE -->
      <div class="col-lg-4 col-md-6">
        <div class="card">
          <div class="card-header">
            <strong class="card-title mb-3">Partner Profile</strong>
          </div>
          <div class="card-body">
            <div class="mx-auto d-block">
              <img class="rounded-circle mx-auto d-block" src="{{ asset('/user/images/' . $job->owner->pfp) }}" alt="Card image cap">
              <h5 class="text-sm-center mt-2 mb-1">{{$job->owner->name}}</h5>
              <div class="location text-sm-center"><i class="fa fa-map-marker"></i> {{$job->owner->address}}</div>
              <div class="location text-sm-center"><i class="fa fa-map-envelope"></i> {{$job->owner->email}}</div>
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
      </div>
    </div>

    <br><br><br>
  </div>
</div><!-- .content -->
@endsection
