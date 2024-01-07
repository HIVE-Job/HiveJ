<section class="home-section section-hero overlay bg-image" style="background-image: url('/user/images/hero_1.jpg');" id="home-section">
  <div class="container">
    <div class="row align-items-center justify-content-center">
      <div class="col-md-12">
        <div class="mb-5 text-center">
          <h1 class="text-white font-weight-bold">Get Your Dream Job Now!</h1>
          <p>Register your account, get a job based on your skills, or join as a partner.</p>
        </div>
        <form method="GET" class="search-jobs-form" action="{{route('g.search')}}">
          @csrf
          <div class="row mb-5">
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
              <input type="text" class="form-control form-control-lg" placeholder="Job Title" name="mainKeyword">
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
              <select class="selectpicker" data-style="btn-white btn-lg" data-width="100%" data-live-search="true" title="Select Location" name="location">
                @foreach($locations as $location)
                <option value="{{$location->location}}">{{$location->location}}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
              <select class="selectpicker" data-style="btn-white btn-lg" data-width="100%" data-live-search="true" title="Select Job Type" name="jobType">
                <option value="part-time">Part Time</option>
                <option value="full-time">Full Time</option>
              </select>
            </div>
            <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-4 mb-lg-0">
              <button type="submit" class="btn btn-primary btn-lg btn-block text-white btn-search"><span class="icon-search icon mr-2"></span>Search Job</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <a href="#next" class="scroll-button smoothscroll">
    <span class=" icon-keyboard_arrow_down"></span>
  </a>
</section>
