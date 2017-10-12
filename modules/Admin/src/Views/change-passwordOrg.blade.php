@extends($theme.'.layouts.outer')
@section('content')


  <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Change Password</h2>
        </div>
    </section>
    <section class="min-height-450">
        <div class="container">
		
		<!--
		<div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
        </div>
		-->
			
           
            <div class="row" id="searchResultDiv" style="" >
                <div class="col-sm-12">
                    
                     
					<div class="row">
						<div class="panel-default">
							<div class="panel-body">
								@if (isset($message) and $message != '')
								{{$message}}
								@endif

								<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/change-password') }}">
									{!! csrf_field() !!}
									<label class="col-md-2 control-label">Old Password</label>
									<div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
										<div class="col-md-4">
											<input type="password" class="form-control" name="old_password">
											@if ($errors->has('old_password'))
											<span class="help-block">
												<strong>{{ $errors->first('old_password') }}</strong>
											</span>
											@endif
										</div>
									</div>
									
									<label class="col-md-2 control-label">New Password</label>
									<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
										<div class="col-md-4">
											<input type="password" class="form-control" name="password">
											@if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
											</span>
											@endif
										</div>
									</div>
									
									<label class="col-md-2 control-label">Confirm Password</label>
									<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
										<div class="col-md-4">
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
											<button type="submit" class="btn btn-green margin-B-20" >
												<i class="fa fa-btn fa-sign-in"></i> Change
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