@extends('job-seeker.layouts.template')

@section('content')
    @include('job-seeker.layouts.hero-section-2')
    <section class="site-section services-section bg-light block__62849" id="next-section">
      <div class="container">

        <div class="row justify-content-center">
          <div class="col-8 col-md-8 col-lg-8 mb-4 mb-lg-5">
            @if(session('status'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong>  {{session('status')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif
            <form method="POST" action="{{route('u.update-profile')}}" enctype="multipart/form-data" class="p-4 p-md-5 border rounded bg-white">
              <center><h3 class="section-title">User Profile</h3></center>
              <br>
              @csrf
              @method('patch')
              <center><img src="/user/images/{{Auth()->user()->pfp}}" alt="" style="height:200px; width:200px"></center>
              <br><br>

              <!-- user pfp -->
              <div class="form-group">
                <div class="mb-3">
                  <label for="formFile" class="form-label">Change Profile Picture</label>
                  <input class="form-control @error('pfp') is-invalid @enderror" type="file" name="pfp" onchange="previewImage(event)" value="{{old('pfp', Auth()->user()->pfp)}}">
                  <div class="image-preview hidden">
                    <img id="preview-image" src="#" alt="Preview Image" />
                  </div>
                  @error('pfp')
                    <div class="text-danger text-sm">{{$message}}</div>
                  @enderror
                </div>
              </div>

              <!-- name -->
              <div class="form-group">
              <label for="name">User Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required value="{{old('name', Auth()->user()->name)}}">
              @error('name')
                <div class="text-danger text-sm">{{$message}}</div>
              @enderror
              </div>

              <!-- address -->
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" required value="{{old('address', Auth()->user()->address)}}">
                @error('address')
                  <div class="text-danger text-sm">{{$message}}</div>
                @enderror
              </div>

              <!-- phone number -->
              <div class="form-group">
                <label for="phone_number">Phone Number (Linked with WhatsApp)</label>
                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{old('phone_number', Auth()->user()->phone_number)}}">
                @error('phone_number')
                  <div class="text-danger text-sm">{{$message}}</div>
                @enderror
              </div>

              <div class="row align-items-end mb-5">
                <div class="col-12">
                  <button type="submit" class="btn btn-block btn-primary-cs btn-md"><i class="fa fa-save"></i> &nbsp; Save Changes</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-8 col-md-8 col-lg-8 mb-4 mb-lg-5">
          <center><h3 class="section-title">Skills List</h3></center>
          <div class="p-4 p-md-5 border rounded bg-white">
          <h4>Current skills list:</h4> <br>
            <ul class="list-unstyled m-0 p-0">
              @foreach($userSkills as $userSkill)
                <li class="d-flex align-items-start mb-2">
                  <span class="icon-check_circle mr-2 text-muted"></span><span>{{$userSkill->skill->skill_name}}</span> &nbsp;
                  <form action="{{ route('u.delete-skill', ['id' => $userSkill->skill->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this skill? Skills are considered in your job applications!')"><i class="fa fa-times-circle text-danger"></i></button>
                  </form>
                </li>
              @endforeach
            </ul>
          </div>

            <form method="POST" action="{{route('u.create-skill')}}" enctype="multipart/form-data" class="p-4 p-md-5 border rounded bg-white">
              <h5>Choose from the existing skills list</h5>
              <br>
              @csrf

              <!-- skill id -->
              <div class="form-group">
                <label for="name">User Name</label>
                <select class="selectpicker border rounded @error('skill_id') is-invalid @enderror" id="skill_id" name="skill_id" data-style="btn-black" data-width="100%" data-live-search="true" title="Select skill" required>
                  @foreach($skills as $skill)
                  <option value="{{$skill->id}}">{{$skill->skill_name}}</option>
                  @endforeach
                </select>
                @error('skill_id')
                  <div class="text-danger text-sm">{{$message}}</div>
                @enderror
              </div>

              <div class="row align-items-end mb-5">
                <div class="col-12">
                  <button type="submit" class="btn btn-block btn-primary-cs btn-md"><i class="fa fa-save"></i> &nbsp; Save Changes</button>
                </div>
              </div>
            </form>

            <form method="POST" action="{{route('u.create-skill-2')}}" enctype="multipart/form-data" class="p-4 p-md-5 rounded bg-white">
              <h5>Or define a new skill not listed</h5>
              <br>
              @csrf

              <!-- skill name -->
              <div class="form-group">
                <label for="name">Skill</label>
                <input type="text" class="form-control @error('skill_name') is-invalid @enderror" id="skill_name" name="skill_name" required value="{{old('skill_name')}}">
                @error('skill_name')
                  <div class="text-danger text-sm">{{$message}}</div>
                @enderror
              </div>

              <div class="row align-items-end mb-5">
                <div class="col-12">
                  <button type="submit" class="btn btn-block btn-primary-cs btn-md"><i class="fa fa-save"></i> &nbsp; Save Changes</button>
                </div>
              </div>
            </form>
          </div>
        </div>


      </div>
      <div class="container">
        @if(\Session::has('update'))
            <div class="alert alert-success">
                <p>{!! \Session::get('update') !!}</p>
            </div>
        @endif
    </div>
      <div class="row justify-content-center">
        <div class="col-8 col-md-8 col-lg-8 mb-4 mb-lg-5">
        <center><h3 class="section-title">Manage CV</h3></center>
                    <form class="p-4 p-md-5 border rounded" enctype= "multipart/form-data"  method="post" action="{{ route('update.cv') }}">
                        @csrf
                       <div class="form-group">
                            <label for="name">CV</label>
                            <input type="file" name="cv"  class="form-control">
                        </div>

                        <div class="col-lg-4 ml-auto">
                            <div class="row">
                                <div class="col-6">
                                    <button type="Update" class="btn btn-block btn-primary btn-md">Update</button>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('view.cv') }}" class="btn btn-block btn-primary btn-md">View CV</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>
@endsection
