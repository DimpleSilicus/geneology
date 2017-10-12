@extends($theme.'.layouts.outer')
@section('content')

<section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Admin Panel</h2>
        </div>
    </section>
   
	<section>
        <div class="container" >
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12" style=" margin:0px 0px 0px 300px;" >
					<form id="adminLogin"  role="form" method="POST" action="{{ url('login') }}">
                     {!! csrf_field() !!}
                        <div class="col-sm-12 background-gray-lighter padding-30">
                            <h3 class="form-heading">Admin Login</h3>
							
                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}" >
                                <input type="text" class="form-control" value="{{ old('username') }}"  id="username" name="username" >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Username">Username *</label>
                                 @if ($errors->has('username'))
                                <span class="text-danger">
                                    <strong id="form-errors-username">{{ $errors->first('username') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" >
                                <input type="password" class="form-control"  id="password" name="password" >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Password">Password *</label>
                                @if ($errors->has('password'))
                                <span class="text-danger">
                                    <strong id="form-errors-password">{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                       
                            <div class="row">
                                <div class="col-sm-12 margin-B-20">
                                        <button type="submit" class="btn btn-raised btn-green pull-right">LOGIN</button>
                                        <a href="{{url('admin/forgotpassword')}}" class="pull-right margin-R-20 margin-T-10 forgot-pw"><u>Forgot Password?</u> </a>
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