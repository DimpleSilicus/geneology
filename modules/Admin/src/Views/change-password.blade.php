@extends($theme.'.layouts.outer')
@section('content')


  <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Change Password</h2>
        </div>
    </section>
	
    	
	<section>
        <div class="container" >
            <div class="row" >
                <div class="col-md-6 col-sm-12 col-xs-12" style=" margin:0px 0px -50px 300px;" >
								@if (isset($message) and $message != '')
								{{$message}}
								@endif
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/change-password') }}">
                     {!! csrf_field() !!}
                        <div class="col-sm-12 background-gray-lighter padding-30">
                            <h3 class="form-heading">Change Password</h3>
							
						
							
                            <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                <input type="password" class="form-control" name="old_password">
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
								<label class="float-label" for="Old Password">Old Password *</label>
									@if ($errors->has('old_password'))
									<span class="text-danger">
										<strong>{{ $errors->first('old_password') }}</strong>
									</span>
									@endif
                            </div>
							
							<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input type="password" class="form-control"  id="password" name="password" >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
								<label class="float-label" for="New Password">New Password *</label>
                                @if ($errors->has('password'))
									<span class="text-danger">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
                            </div>
							
							<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <input type="password" class="form-control" name="password_confirmation">
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
								<label class="float-label" for="Confirm Password">Confirm Password *</label>
                                    @if ($errors->has('password_confirmation'))
										<span class="text-danger">
										     <strong>{{ $errors->first('password_confirmation') }}</strong>
										</span>
										@endif
                            </div>
                       
                            <div class="form-group">
								<div class="col-md-2 col-md-offset-2">
										<button type="submit" class="btn btn-green margin-B-20" >
										<i class="fa fa-btn fa-sign-in"></i> Change
										</button>
										</div>
								</div>
							</div>	
                        </div>
                    </form>
                </div>

                <div class="col-sm-12 visible-sm margin-T-50"></div>
                <div class="col-xs-12 visible-xs margin-T-50"></div>

              
            </div><!--row end-->
        </div><!--container end-->
    </section>
	
@endsection