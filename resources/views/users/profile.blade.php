@extends('layouts.app')

@section('content')
<section class="section-hero overlay inner-page bg-image" style="background-image:url('{{ asset('assets/images/hero_1.jpg') }}') ;margin-top: -24px; ">
<div class="container mt-5">
    
    <div class="row d-flex justify-content-center">
        
        <div class="col-md-7">
            
            <div class="card p-3 py-4">
            <div class="container">
        @if(\Session::has('update'))
            <div class="alert alert-success">
                <p>{!! \Session::get('update') !!}</p>
            </div>
        @endif
    </div>
                <div class="text-center">
                    <img src="{{asset('assets/images_users/'.$profile->image.'')}}" width="100" class="rounded-circle">
                </div>
                
                <div class="text-center mt-3">
                    <span class="bg-secondary p-1 px-4 rounded text-white">Pro</span>
                    <h5 class="mt-2 mb-0">{{ $profile->name }}</h5>
                    <span>{{ $profile->job_title }}</span>
                    <a href="{{asset('assets/cvs/'.$profile->cv.'')}}" class="btn btn-success btn-block text-white">Download cv</a>
                    <div class="px-4 mt-1">
                        <p class="fonts">{{ $profile->bio }}</p>
                    
                    </div>
                    
                    <h3 class="text-primary  mt-3 h5 pl-3 mb-3 ">Share</h3>
<div class="px-3" style="margin-left:25px">
<a href="{{$profile->facebook}}" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-facebook"></span></a>
<a href="{{$profile->twitter}}#" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-twitter"></span></a>
<a href="{{$profile->linkedin}}" class="pt-3 pb-3 pr-3 pl-0"><span class="icon-linkedin"></span></a>
</div>
</div>
                     
                </div>
                
               
                
                
            </div>
            
        </div>
        
    </div>
    
</div>
</section>
@endsection