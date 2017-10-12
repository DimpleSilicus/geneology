@extends($theme.'.layouts.app')
@section('content')
<div class="container">
    <div class="left">
        <h2>{{ $pageDetails->name }}</h2>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-default">
                <div class="panel-body">
                    {!! $pageDetails->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
