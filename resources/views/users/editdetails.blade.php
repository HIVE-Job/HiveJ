@extends('layouts.app')

@section('content')
    <section class="section-hero overlay inner-page bg-image" style="background-image: url('{{ asset('assets/images/hero_1.jpg') }}'); margin-top: -24px;" id="home-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1 class="text-white font-weight-bold">Update Profile</h1>
                    <div class="custom-breadcrumbs">
                        <a href="#">Home</a> <span class="mx-2 slash">/</span>
                        <a href="#">Job</a> <span class="mx-2 slash">/</span>
                        <span class="text-white"><strong>Update Profile</strong></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        @if(\Session::has('update'))
            <div class="alert alert-success">
                <p>{!! \Session::get('update') !!}</p>
            </div>
        @endif
    </div>

    <section class="site-section">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="d-flex align-items-center">
                        <div>
                            <h2>Update Profile</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-12">
                    <form class="p-4 p-md-5 border rounded" method="post" action="{{ route('update.details') }}">
                        @csrf
                        <h3 class="text-black mb-5 border-bottom pb-2">User details</h3>

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ $userDetails->name }}" class="form-control" id="name" placeholder="Name">
                        </div>
                        @if($errors->has('name'))
                          <p class="alert alert-danger">{{ $errors->first('name') }}</p>
                          @endif
                        <div class="form-group">
                            <label for="job_title">Job Title</label>
                            <input type="text" value="{{ $userDetails->job_title }}" name="job_title" class="form-control" id="job_title" placeholder="Job Title">
                        </div>
                        @if($errors->has('job_title'))
                          <p class="alert alert-danger">{{ $errors->first('job_title') }}</p>
                          @endif
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea name="bio" id="bio" cols="30" rows="7" class="form-control" placeholder="Bio...">{{ $userDetails->bio }}</textarea>
                        </div>
                        @if($errors->has('bio'))
                          <p class="alert alert-danger">{{ $errors->first('bio') }}</p>
                          @endif
                        <div class="form-group">
                            <label for="facebook">Facebook</label>
                            <input type="text" value="{{ $userDetails->facebook }}" name="facebook" class="form-control" id="facebook" placeholder="Facebook Link">
                        </div>
                        @if($errors->has('facebook'))
                          <p class="alert alert-danger">{{ $errors->first('facebook') }}</p>
                          @endif
                        <div class="form-group">
                            <label for="twitter">Twitter</label>
                            <input type="text" value="{{ $userDetails->twitter }}" name="twitter" class="form-control" id="twitter" placeholder="Twitter Link">
                        </div>
                        @if($errors->has('twitter'))
                          <p class="alert alert-danger">{{ $errors->first('twitter') }}</p>
                          @endif
                        <div class="form-group">
                            <label for="linkedin">LinkedIn</label>
                            <input type="text" value="{{ $userDetails->linkedin }}" name="linkedin" class="form-control" id="linkedin" placeholder="LinkedIn">
                        </div>
                        @if($errors->has('linkedin'))
                          <p class="alert alert-danger">{{ $errors->first('linkedin') }}</p>
                          @endif
                        <div class="col-lg-4 ml-auto">
                            <div class="row">
                                <div class="col-6">
                                    <button type="Update" class="btn btn-block btn-primary btn-md">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
