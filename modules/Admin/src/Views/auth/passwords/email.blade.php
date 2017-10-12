@extends($theme.'.layouts.outer')
@section('content')

<section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Forgot Password</h2>
        </div>
    </section>
    <section class="min-height-450">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Forgot Password</li>
                    </ol>
                </div>
            </div>
			
			
			<div class="col-sm-12 background-gray-lighter padding-30" style=" ">
			<div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel-default">
                    <div class="panel-body">
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                            {!! csrf_field() !!}

                            
                                <label class="col-md-4">E-Mail Address</label>
							<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">	

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-green margin-B-20" >
                                        <i class="fa fa-btn fa-envelope"></i>Send Password Reset Link
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
		</div>
           
			

        </div><!--container end-->
    </section>
	

@endsection