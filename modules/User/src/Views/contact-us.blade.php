@extends($theme.'.layouts.app')
@section('content')

<div class="clearfix"></div>
    <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Contact Details</h2>
        </div>
    </section>
    <section class="margin-T-20 min-height-450">
        <div class="container">
            <div class="row">               
                <div class="col-sm-12">
                    <div class="post">
                        <p class="post__intro">
                           <strong>Company Name:</strong> Genealogy Network Hub<br/>
                           <strong>Email: </strong><a href="mailto:samtg@genealogynetworkhub.com">samtg@genealogynetworkhub.com</a> <br />
                           <strong>Contact No:</strong>+18254936578
                        </p>
                    </div>
                </div> <!--col-sm-12 end-->                                             
            </div><!--row end-->
        <div class="row">
            <form>
                <div class="col-sm-12">
                    <strong>Please fill below details to contact us or you have any query.</strong>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <div class="input-group width-100Per">
                        <input type="text" class="form-control" id="ContactFName" required>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactFName">Name</label>
                    </div>                    
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <div class="input-group width-100Per">
                        <input type="text" class="form-control" id="ContactLName" required>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactLName">Last Name</label>
                    </div>                    
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <div class="input-group width-100Per">
                        <input type="email" class="form-control" id="ContactEmail" required>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactEmail">Email</label>
                    </div>
                </div>
                <div class="form-group col-md-3 col-sm-6">
                    <div class="input-group width-100Per">
                        <input type="number" class="form-control" id="ContactNo" required>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactNo">Phone Number</label>
                    </div>
                </div>               
                <div class="col-sm-12">
                    <div class="form-group">
                        <textarea type="text" class="form-control" id="ContactMsg" required></textarea>
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="ContactMsg">Message</label>
                    </div>
                </div>
                <div class="col-sm-12 margin-T-20 margin-B-100">
                    <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                    <button type="button" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
        </div><!--container-->
    </section>
    <!--   *** INTEGRATIONS ***-->

@endsection