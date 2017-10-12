@extends($theme.'.layouts.outer')
@section('content')

<section class="background-maroon heading-section">
    <div class="container">
        <h2 class="heading">Manage User</h2>
    </div>
</section>
<section class="min-height-450">
    <div class="container">
        <div class="row">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has($msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
                @endforeach
            </div>
            <div class="col-sm-6">

                <div class="form-group col-md-6 col-sm-12 padding-LR-0">
                    <div class="input-group width-100Per">
                        <input type="text" class="form-control width-90Per" id="SearchName1" required name="SearchName1" />
                        <span class="form-highlight"></span>
                        <span class="form-bar"></span>
                        <label class="float-label" for="SearchName1">Search</label>
                        <label class="input-group-addon modal-datepicker-ico border-bttm" for="SearchName1">
                            <span id="idSearchUser" class="glyphicon glyphicon glyphicon-search"></span>
                        </label>
                        <span class="text-danger" id="searchname-div"><strong id="form-errors-searchname"></strong>
                    </div>
                </div>

            </div>
        </div> <!--row end-->
        <div class="row">
            <div class="col-sm-12" id="searchUserResultDiv">
                <div class="table-responsive margin-T-10">
                    <table class="table" id="searchUserResultTable">
                        <thead>
                            <tr style="background: #dce0e4;">
                                <th>Username</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th colspan="2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--container end-->
</section>


<div id="Subscription" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Subscription Plan Detail</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="col-sm-12">
                        <table class="table" id="SubscriptionTable">
                            <thead>
                                <tr style="background: #dce0e4;">
                                    <th>Package name</th>
                                    <th>Package Description </th>
                                    <th>Amount</th>
                                    <th>Gedcom Files</th>
                                    <th>Created date</th>
                                    <th>Transaction Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>                        
                    </div>
                </form>
            </div>
            <div class="clearfix"></div>            
        </div>
    </div>
</div>
@endsection