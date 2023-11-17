@extends('layouts.app')

@section('content')
    <section class="section-hero overlay inner-page bg-image" style="background-image: url('{{ asset('assets/images/hero_1.jpg') }}'); margin-top: -24px;" id="home-section">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h1 class="text-white font-weight-bold">Update CV</h1>
                    <div class="custom-breadcrumbs">
                        <a href="#">Home</a> <span class="mx-2 slash">/</span>
                        <a href="#">Job</a> <span class="mx-2 slash">/</span>
                        <span class="text-white"><strong>Update CV</strong></span>
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
                            <h2>Update User CV</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-lg-12">
                    <form class="p-4 p-md-5 border rounded" enctype= "multipart/form-data"  method="post" action="{{ route('update.cv') }}">
                        @csrf
                        <h3 class="text-black mb-5 border-bottom pb-2">User details</h3>

                        <div class="form-group">
                            <label for="name">CV</label>
                            <input type="file" name="cv"  class="form-control">
                        </div>

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
