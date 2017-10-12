@extends('Admin::layouts.app')
@section('content')
<section class="content-header">
    <h1>Page Category List</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pages</li>
        <li class="active">Page Category List</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="item  col-xs-4 col-lg-4">
            <h3><a href="javascript:void(0)" id="showContentDiv" class="btn btn-success"><i class="fa fa-plus"></i>{{isset($pageCategoryDetails->id) ? 'Edit' : 'Add'}}  Page Category</a></h3>
        </div>
    </div>
    <div class="panel-default">
        <div class="panel-body">
            <div id="fromDiv" style="border: 1px solid #ddd;padding: 10px;display: {{isset($pageCategoryDetails->id) ? 'block' : 'none'}};">
                <div class="tab-wrap">
                    <div class="media">

                        <div class="parrent media">
                            <div class="tab-content">
                                <div class="tab-pane active in col-sm-8" id="tab1">
                                    <div class="media">
                                        <form id="addGroupForm" class="contact-form" action="{{ URL::to('/') }}/admin/pages/savePageCategory" method="post" name="crud_form" >
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label>Category Name *</label>
                                                    <input type="text" name="name" id="name" class="form-control" required="required" value="{{isset($pageCategoryDetails->name) ? $pageCategoryDetails->name : ''}}">
                                                </div>
                                                <span style="color: red;">{{ $errors->first('name', 'Please enter category name') }}</span>
                                                <div class="form-group">
                                                    <label>Status</label>
                                                    <input type="checkbox" name="status" id="status" @if((isset($pageCategoryDetails) && $pageCategoryDetails->status == 1)) checked @endif>
                                                </div>
                                                <div class="form-group">
                                                    {!! csrf_field() !!}
                                                    <input type="hidden" name="id" id="id" class="form-control" required="required" value="{{isset($pageCategoryDetails->id) ? $pageCategoryDetails->id : ''}}">
                                                    <input type="submit" name="submit" value="{{isset($pageCategoryDetails->id) ? 'Update' : 'Save'}}" class="btn btn-primary" required="required">
                                                    <a href="{{url('/admin/pages/category/list')}}" class="btn btn-danger cancel_btn">Cancel</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div> <!--/.tab-content-->
                        </div> <!--/.media-body-->
                    </div> <!--/.media-->
                </div>
            </div>

            <div style="border: 1px solid #ddd;padding: 10px;margin-top: 10px;">
                <table id="records" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
