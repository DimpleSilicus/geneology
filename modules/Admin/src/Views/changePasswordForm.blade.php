@extends('Admin::layouts.app')
@section('content')

<section class="content-header">
    <h1>Change Password</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Change Password</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="panel-default">
            <div class="panel-body">
                @if (isset($message) and $message != '')
                {{$message}}
                @endif

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/change-password') }}">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label">Old Password</label>

                        <div class="col-md-2">
                            <input type="password" class="form-control" name="old_password">
                            @if ($errors->has('old_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('old_password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label">New Password</label>

                        <div class="col-md-2">
                            <input type="password" class="form-control" name="password">
                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-2 control-label">Confirm Password</label>

                        <div class="col-md-2">
                            <input type="password" class="form-control" name="password_confirmation">
                            @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-btn fa-sign-in"></i> Change
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>

@endsection
