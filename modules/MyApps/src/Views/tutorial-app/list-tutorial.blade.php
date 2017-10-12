@extends($theme.'.layouts.app')
@section('content')


 <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Tutorial App</h2>
        </div>
    </section>
    <section class="min-height-450">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('myapps/apps') }}">Apps</a></li>
                        <li class="breadcrumb-item active">Tutorial App</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 col-sm-6 margin-T-20">
                    <div class="input-group width-100Per">
                        <input type="text" class="form-control width-90Per" id="SearchName" required name="SearchName" />
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="SearchName">Search</label>
                        <label class="input-group-addon modal-datepicker-ico border-bttm" for="SearchName">
                            <span id="idSearch" class="glyphicon glyphicon glyphicon-search"></span>
                        </label>
                        <span class="text-danger" id="searchname-div"><strong id="form-errors-searchname"></strong></span>
                    </div>
                </div>
            </div><!--row end-->
                     
                     <!-- div Display Search Result -->
                     <div id="searchResultDiv" >       		    
       				 </div>
       				 <!-- div end here -->
		
        </div><!--container end-->
    </section>

@endsection