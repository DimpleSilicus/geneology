@extends($theme.'.layouts.app')
@section('content')
<section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Apps</h2>
        </div>
    </section>
    <section class="light-gray-bg padding-B-100">
        <div class="container app-content">
            <div class="row padding-TB-20 border-bttm white-bg">
				@if (Auth::user()->type == 1)
                <div class="col-sm-4 right-bdr text-center">
                    <a href="{{ url('/picture-app/list') }}">
                        <img src="{{ url('/theme') }}/{{$theme}}/images/app/pik-app-ico.png" /><br />
                        <h3>Picture App</h3>
                    </a>                   
                </div>
                <div class="col-sm-4 right-bdr text-center">
                    <a href="{{ url('/video-app/list') }}">
                        <img src="{{ url('/theme') }}/{{$theme}}/images/app/video-app-ico.png" /><br />
                        <h3>Video App</h3>
                    </a>
                </div>
				@endif 
				@if (isset(Auth::user()->type))
                <div class="col-sm-4 text-center">
                    <a href="{{ url('tutorial-app/list') }}">
                        <img src="{{ url('/theme') }}/{{$theme}}/images/app/tutorial-app-ico.png" /><br />
                        <h3>Tutorial App</h3>
                    </a>
                </div>
				@endif
            </div><!--row end-->   
            @if (Auth::user()->type == 1)
            <div class="row padding-TB-20 white-bg">
                <div class="col-sm-4 right-bdr text-center">
                    <a href="{{ url('journal-app/list') }}">
                        <img src="{{ url('/theme') }}/{{$theme}}/images/app/journal-app-ico.png" /><br />
                        <h3>Journal App</h3>
                    </a>
                </div>
                <div class="col-sm-4 right-bdr text-center">
                    <a href="{{ url('event-app/list') }}">
                        <img src="{{ url('/theme') }}/{{$theme}}/images/app/event-app-ico.png" /><br />
                        <h3>Event App</h3>
                    </a>
                </div>
                <div class="col-sm-4 text-center">
                    <a href="{{ url('resource-app/list') }}">
                        <img src="{{ url('/theme') }}/{{$theme}}/images/app/resource-app-ico.png" /><br />
                        <h3>Resource App</h3>
                    </a>
                </div>
            </div><!--row end-->      
            @endif
        </div><!--container end-->
    </section>
@endsection