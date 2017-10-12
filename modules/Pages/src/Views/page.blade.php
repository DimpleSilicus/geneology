@extends('Admin::layouts.app')
@section('content')
<section class="content-header">
    <h1>Page List</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pages</li>
        <li class="active">Page List</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="item  col-xs-4 col-lg-4">
            <h3><a href="javascript:void(0)" id="showContentDiv" class="btn btn-success"><i class="fa fa-plus"></i>{{isset($pageDetails->id) ? 'Edit' : 'Add'}}  Page</a></h3>
        </div>
    </div>
    <div class="panel-default">
        <div class="panel-body">
            <div id="fromDiv" style="border: 1px solid #ddd;padding: 10px;display: {{isset($pageDetails->id) ? 'block' : 'none'}};">
                <div class="tab-wrap">
                    <div class="media">
                        <div class="parrent pull">
                            <ul class="nav nav-tabs">
                                <li class="active" id="page"><a href="#tab1" data-toggle="tab" class="analistic-01">Page</a></li>
                                <li class="" id="meta"><a href="#tab2" data-toggle="tab" class="analistic-02">Meta</a></li>
                                <li class="" id="setting"><a href="#tab3" data-toggle="tab" class="tehnical">Setting</a></li>
                            </ul>
                        </div>
                        <div class="parrent media">
                            <div class="tab-content">
                                <div class="tab-pane active in col-sm-8" id="tab1">
                                    <div class="media">
                                        <form id="page_form" class="contact-form" action="{{ URL::to('/') }}/admin/pages/savePage" method="post" name="page_form" >
                                            <div class="col-sm-6 form-group" style="padding-left: 0px;">
                                                <label>Name *</label>
                                                <input type="text" name="name" id="name" class="form-control" required="required" value="{{isset($pageDetails->name) ? $pageDetails->name : ''}}">
                                            </div>
                                            <span style="color: red;">{{ $errors->first('name', 'Please enter name') }}</span>
                                            <div class="col-sm-6 form-group">
                                                <label>Slug *</label>
                                                <input type="text" name="slug" id="slug" class="form-control" required="required" value="{{isset($pageDetails->slug) ? $pageDetails->slug : ''}}">
                                            </div>
                                            <span style="color: red;">{{ $errors->first('slug', 'Please enter slug') }}</span>
                                            <div class="form-group">
                                                <label>Content</label>
                                                <textarea id="content" name="content" rows="15" cols="30" style="width: 10%" class="tinymce">{{isset($pageDetails->content) ? $pageDetails->content : ''}}</textarea>
                                            </div>
                                            <span style="color: red;">{{ $errors->first('content', 'Please enter content') }}</span>
                                    </div>
                                </div>
                                <div class="tab-pane col-sm-5" id="tab2">
                                    <div class="media">
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Meta Title *</label>
                                                <input type="text" name="metaTitle" id="metaTitle" class="form-control" required="required" value="{{isset($pageDetails->meta_title) ? $pageDetails->meta_title : ''}}">
                                            </div>
                                            <span style="color: red;">{{ $errors->first('title', 'Please enter title') }}</span>
                                            <label>Meta Keyword *</label>
                                            <input type="text" name="metaKeyword" id="metaKeyword" class="form-control" required="required" value="{{isset($pageDetails->meta_keyword) ? $pageDetails->meta_keyword : ''}}">
                                        </div>
                                        <span style="color: red;">{{ $errors->first('metaKeyword', 'Please enter meta keyword') }}</span>
                                        <div class="form-group">
                                            <label>Meta Description *</label>
                                            <input type="text" name="metaDescription" id="metaDescription" class="form-control" required="required" value="{{isset($pageDetails->meta_description) ? $pageDetails->meta_description : ''}}">
                                        </div>
                                        <span style="color: red;">{{ $errors->first('metaDescription', 'Please enter meta description') }}</span>
                                    </div>
                                </div>
                                <div class="tab-pane col-sm-5" id="tab3">
                                    <div class="form-group">
                                        <label>Page Category *</label>
                                        <select name="pageCategoryId" id="pageCategoryId" class="form-control" required>
                                            <option value="">Please select category</option>
                                            @foreach($pageCategoryList as $pageCategoryList_Info)
                                            <option value="{{$pageCategoryList_Info['id']}}"  @if(isset($pageDetails) && $pageDetails->page_category_id == $pageCategoryList_Info->id) selected @endif >{{$pageCategoryList_Info['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <span style="color: red;">{{ $errors->first('pageCategoryId', 'Please enter meta keyword') }}</span>
                                    <div class="form-group">
                                        <label>Publish</label>
                                        <select name="publish" id="publish" class="form-control">
                                            <option value="1" @if(isset($pageDetails) && $pageDetails->publish == 1) selected @endif>Publish</option>
                                            <option value="0" @if(isset($pageDetails) && $pageDetails->publish == 0) selected @endif>Unpublish</option>
                                        </select>
                                    </div>
                                    <span style="color: red;">{{ $errors->first('publish', 'Please enter meta description') }}</span>
                                </div>
                                <div class="form-group col-sm-8">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="id" id="id" class="form-control" required="required" value="{{isset($pageDetails->id) ? $pageDetails->id : ''}}">
                                    <input type="submit" onclick="validataPageForm()" name="submit" value="{{isset($pageDetails->id) ? 'Update' : 'Save'}}" class="btn btn-primary" required="required">
                                    <a href="{{url('/admin/pages/list')}}" class="btn btn-danger cancel_btn">Cancel</a>
                                    </form>
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
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Preview</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Preview</th>
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
