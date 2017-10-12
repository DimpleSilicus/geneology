@extends($theme.'.layouts.app')

@section('content')
<div class="clearfix"></div>
<div class="container">
<h1>All @USample@</h1>

<p><button class="btn btn-primary btn-xs open-modal" id="btnAdd" value="">Add new @LSample@</button></p>
<table id="recordGrid" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            @CREAT_HEAD_CONTENT@
            <th>View</th>
            <th>Edit</th>            
            <th>Delete</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            @CREAT_HEAD_CONTENT@
            <th>View</th>
            <th>Edit</th>            
            <th>Delete</th>
        </tr>
    </tfoot>    
</table>

    <!-- End of Table-to-load-the-data Part -->
    <!-- Modal (Pop up when detail button clicked) -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">@USample@ Editor</h4>
                </div>
                <div class="modal-body">
                    {{ Form::open(array('name'=>'frm@USample@', 'id'=>'frm@USample@')) }}
                    @CREAT_FORM_CONTENT@
                    {{ Form::close() }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes</button>
                    <input type="hidden" id="id" name="id" value="0">
                </div>
            </div>
        </div>
    </div>
    <!-- End of Table-to-load-the-data Part -->
    <!-- Modal (Pop up when detail button clicked) -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">@USample@ View</h4>
                </div>
                <div class="modal-body">
                    @CREAT_VIEW_CONTENT@
                </div>
            </div>
        </div>
    </div>
    <meta name="_token" content="{!! csrf_token() !!}" />
</div>
@endsection

