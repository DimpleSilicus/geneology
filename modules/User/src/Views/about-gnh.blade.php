@extends($theme.'.layouts.app')
@section('content')

 <div class="clearfix"></div>
    <div class="jumbotron main-jumbotron">
      <div class="container">
        <div class="content">
          <h1>Connect Generations</h1>
          <p class="margin-bottom">Discover your place in history with Family Tree,<br /> an easy way to preserve your genealogy online. <br/>
            See what others have contributed, and share your family story.</p>        
        </div>
      </div>
    </div>
    <section>
      <div class="container text-center">
        <h2 class="homepage-subheading">About Genealogy Network Hub</h2>
        <p class="lead">Genealogy Network Hub is an organization created with the goal to provide a venue as well as a meaningful portal to discuss current genealogical problems, analyze best practices, and act as a resource for personal family history research. The company motto is, "If it can't be proven, it can't be true," to reiterate the importance of proper sources for family history research. This includes protected sources and proper data integrity, so this site offers guided instructions and detailed guides and resources in order to properly conduct such research, as well as keep it properly.</p>       
      </div>
    </section>
    <section class="background-gray-lightest">
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <div class="post">
              <div class="image"><a href="text.html"><img src="{{ url('/theme') }}/{{$theme}}/images/home/about-gnh-img.jpg" alt="" class="img-responsive"></a></div>
              <h3><a href="text.html">About GNH</a></h3>
              <p class="post__intro">Welcome to this site! Whether you are new to family history, or experienced, we offer services that are designed to assist the user researching their genealogy. </p>
              <p class="read-more"><a href="about-application.html" class="btn btn-green">Continue reading...</a></p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="post">
              <div class="image"><a href="text.html"><img src="{{ url('/theme') }}/{{$theme}}/images/home/gedcom-img.jpg" alt="" class="img-responsive"></a></div>
              <h3><a href="text.html">Upload Gedcom</a></h3>
              <p class="post__intro"> When you upload a family tree file, all of the people in it are placed into a new tree on GNH sites. The name you choose to give your tree will be visible to your guests and other members of GNH sites.</p>
              <p class="read-more"><a href="#" class="btn btn-green">Continue reading...</a></p>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="post">
              <div class="image"><a href="text.html"><img src="{{ url('/theme') }}/{{$theme}}/images/home/services-img.jpg" alt="" class="img-responsive"></a></div>
              <h3><a href="text.html">Services</a></h3>
              <p class="post__intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. </p>
              <p class="read-more"><a href="services.html" class="btn btn-green">Continue reading...</a></p>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection