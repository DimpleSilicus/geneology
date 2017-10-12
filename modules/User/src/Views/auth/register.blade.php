@extends($theme.'.layouts.app')
@section('content')
  <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Sign Up</h2>
        </div>
    </section>
 <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <form id="registrationForm" role="form" method="POST" action="{{ url('user/register') }}" >
                     {!! csrf_field() !!}
                        <div class="col-sm-12 background-gray-lighter padding-30">
                            <h3 class="form-heading">Free Member</h3>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="email">Email ID*</label>
                                @if ($errors->has('email'))
                                <span class="text-danger">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="userName" name="userName"  >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Username">Username*</label>
                                 @if ($errors->has('userName'))
                                <span class="text-danger">
                                    {{ $errors->first('userName') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Password">Password*</label>
                                @if ($errors->has('password'))
                                <span class="text-danger">
                                    {{ $errors->first('password') }}
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" >
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="password_confirmation">Confirm password*</label>
                                @if ($errors->has('password_confirmation'))
                                <span class="text-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-sm-12 margin-T-20">
                                    <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-sm-12 visible-sm margin-T-50"></div>
                <div class="col-xs-12 visible-xs margin-T-50"></div>

                <div class="col-md-6 col-sm-12 col-xs-12">
                    <form>
                        <div class="col-sm-12 background-gray-lighter padding-30">
                            <h3 class="form-heading">Paid Member</h3>
                            <div class="form-group">
                                <input type="text" class="form-control" id="paidMemEmail" name="paidMemEmail" required>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="PaidMemEmail">Email ID*</label>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="paidMemUsername" name="paidMemUsername" required>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="PaidMemUsername">Username*</label>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="paidMemPassword" name="paidMemPassword" required>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="PaidMemPassword">Password*</label>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="PaidMemConfirmPassword" name="PaidMemConfirmPassword" required>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="PaidMemConfirmPassword">Confirm password*</label>
                            </div>
                            <div class="form-group">
                                <select class="form-control has-info" id="gedcom" name="gedcom" placeholder="Placeholder">
                                    <option selected="selected">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label for="Gedcom" class="hasdrodown">Select Gedcom</label>
                            </div>
                            <div class="form-group">
                                <label class="hasdrodown"><strong>Amount: $100</strong></label>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 margin-T-20">
                                    <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!--row end-->
        </div><!--container end-->
    </section>
@endsection
