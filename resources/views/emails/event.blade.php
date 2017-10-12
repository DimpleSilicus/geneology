Hello,
<br>
We have arranged event {{$event_title}}.
<br>
Please Accept/Decline the event.
<br>
<a class="btn btn-primary" href="{{url('/calendar/download/ical/'.$token)}}" role="button">Accept</a>
<a class="btn btn-primary" href="{{url('/calendar/decline/'.$token)}}" role="button">Decline</a>