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
          <li><a href="{{route('a.dashboard')}}">Dashboard</a>/</li>
          <li class="active">Manage Candidates</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="content mt-3">
  <div class="animated fadeIn">

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">User Information</strong>
          </div>
          <div class="card-body">
            <div id="pay-invoice">
              <div class="card-body">
                <hr>
                <form action="{{route('a.update-candidate', ['id'=> $candidate->id])}}" method="POST">
                  @csrf
                  @method("PUT")

                  <!-- preview profile picture -->
                  <div class="form-group text-center">
                    <h4>User Profile</h4>
                    <img src="{{ asset('/admin/images/' . $candidate->pfp) }}" alt="Profile Picture" style="width:200px; height:200px;">
                  </div>

                  <!-- name -->
                  <div class="form-group">
                    <label for="name" class="control-label mb-1">User Name</label>
                    <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" aria-required="true" aria-invalid="false" value="{{old('name', $candidate->name)}}">
                    @error('name')
                    <div class="text-danger text-sm">{{$message}}</div>
                    @enderror
                  </div>

                  <!-- email -->
                  <div class="form-group">
                    <label for="email" class="control-label mb-1">Email</label>
                    <input id="email" name="email" type="text" class="form-control @error('email') is-invalid @enderror" aria-required="true" aria-invalid="false" value="{{old('email', $candidate->email)}}">
                    @error('email')
                    <div class="text-danger text-sm">{{$message}}</div>
                    @enderror
                  </div>

                  <!-- phone number -->
                  <div class="form-group">
                    <label for="phone_number" class="control-label mb-1">Phone Number / WhatsApp</label>
                    <input id="phone_number" name="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" value="{{old('phone_number', $candidate->phone_number)}}">
                    @error('phone_number')
                    <div class="text-danger text-sm">{{$message}}</div>
                    @enderror
                  </div>

                  <!-- address -->
                  <div class="form-group">
                    <label for="address" class="control-label mb-1">Address</label>
                    <input id="address" name="address" type="text" class="form-control @error('address') is-invalid @enderror" aria-required="true" aria-invalid="false" value="{{old('address', $candidate->address)}}">
                    @error('address')
                    <div class="text-danger text-sm">{{$message}}</div>
                    @enderror
                  </div>

                  <!-- select role -->
                  <div class="row form-group">
                    <div class="col col-md-3"><label for="role" class=" form-control-label">Select Role</label></div>
                    <div class="col-12 col-md-9">
                      <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                        <option value="1" @if($candidate->role === 1) selected @endif>Administrator</option>
                        <option value="2" @if($candidate->role === 2) selected @endif>Partner</option>
                        <option value="3" @if($candidate->role === 3) selected @endif>User (Applicant)</option>
                      </select>
                      @error('role')
                      <div class="text-danger text-sm">{{$message}}</div>
                      @enderror
                    </div>
                  </div>
                  <br><br>
                  <div class="row">
                    <div class="col-6">
                      <a href="{{url()->previous()}}" class="btn rounded btn-light btn-lg btn-secondary btn-block"><i class="fa fa-mail-reply fa-lg"></i>&nbsp;
                        Back
                      </a>
                    </div>
                    <div class="col-6">
                      <button type="submit" class="btn btn-lg rounded btn-primary btn-block"><i class="fa fa-save fa-lg"></i>&nbsp;
                        Save Changes
                      </button>
                    </div>
                  </div>
                  <br><br>
                </form>
              </div>
            </div>
          </div>
        </div> <!-- .card -->
      </div>
      <!--/.col-->

    </div><!-- .animated -->
  </div><!-- .content -->
  @endsection
