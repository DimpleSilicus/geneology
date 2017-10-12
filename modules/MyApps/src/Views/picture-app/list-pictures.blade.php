@extends($theme.'.layouts.app')
@section('content')
  <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">PICTURE App</h2>
        </div>
    </section>
    <section class="min-height-450">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('/myapps/list') }}">Apps</a></li>
                        <li class="breadcrumb-item active">Picture App</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                	<div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                          @if(Session::has($msg))
                          <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                          @endif
                        @endforeach
  					</div>
                    <div class="text-right">
                        <button type="button" class="btn btn-green margin-B-20" data-toggle="modal" data-target="#UploadPik">Upload</button>
                    </div>
                    <div class="table-responsive">
                    
                        <table class="table">
                            <thead>
                                <tr style="background: #dce0e4;">
                                    <th>Name</th>
                                    <th>Owner</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($arrPictures) > 0)
							@foreach ($arrPictures as $picture)
                                <tr>
                                    <td><a href="javascript:void(0);" data-target="#ZoomPik" class="viewPicture" data-toggle="modal" path="{{$appUrl}}{{$picture['path']}}"><i class="fa fa-picture-o margin-R-5"></i>{{$picture['name']}}</a></td>
                                    <td>@if(Auth::user()->id == $picture["owner"]) Self @else Shared by {{$picture["owner"]}} @endif</td>
                                    <td class="dropdown">
                                        <a href="#" class="table-icon dropdown-toggle" data-toggle="dropdown"><i class="fa fa-share-alt"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-left network-search-dropdown-icons">
                                            <li><a href="#" class="table-icon sharePic" picId={{$picture['id']}}><i class="fa fa-group"></i> within network </a></li>
                                            @if (count($arrNetworkUsers) > 0)
											@foreach ($arrNetworkUsers as $users)
											<li><a href="#" picId={{$picture['id']}} userId={{$users['userid']}} style="cursor: pointer;" class="table-icon sharePicToUser"><i class="fa fa-user"></i>{{$users['username']}}</a></li>
                                            @endforeach
                                            @endif
                                        </ul>
                                        @if(Auth::user()->id == $picture["owner"])
                                        <a href="#" class="table-icon"><i class="fa fa-pencil editPic" picId={{$picture['id']}}></i></a>
                                        <a href="#" class="table-icon"><i class="fa fa-trash-o deletePic" picId={{$picture['id']}}></i></a>
                                        @endif
                                    </td>
                                </tr>
                           @endforeach
                           @else
                           <tr class="text-danger has-error" ><td colspan='4' align="center">No Pictures Found.</td></tr>
                           @endif
                            </tbody>
                        </table>
                    </div><!--table responsive end-->
                </div>
            </div><!--row end-->
        </div><!--container end-->
    </section>
     <!-- Modal -->
    <div id="UploadPik" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Upload Picture</h4>
                </div>
                <div class="modal-body">
                    <form id="frmUploadPicture" name="frmUploadPicture" method="post" action="{{ url('picture-app/uploadPicture') }}" enctype="multipart/form-data">
                        <div class="col-sm-12">
                            <div class="row upload-Gedcom-file">
                            
                                <div class="col-sm-12">
                                <h5>Picture Name *</h5>
                                <div class="input-group width-100Per">
                                    <input class="form-control" id="fileName" name="fileName" type="text">
                                    <span class="form-highlight"></span>
                                    <span class="form-bar"></span>
                                  	<span class="text-danger" id="filename-div"><strong id="form-errors-filename"></strong>
                                </div>
                                    <h5>Upload File</h5>
                                    <div class="form-group margin-TB-0">
                                        <input id="uPicture" name="uPicture" type="file" class="file" data-upload-url="#">
                                    </div>
                                    <span class="text-danger" id="file-div"><strong id="form-errors-file"></strong></span>
                                    <div><small>Maximum file size is 75MB. Only jpeg, jpg, png files are allowed</small></div>
                                    
                                    <!--file uploader form end here-->
                                </div>
                            </div><!--row end-->
                        </div>
                   
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-40">
                    <button type="submit" class="btn btn-raised btn-green pull-right">Add</button>
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal" onclick="document.getElementById('frmUploadPicture').reset();">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <div id="EditPic" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Picture</h4>
                </div>
                <div class="modal-body">
                    <form id="frmEditPicture" name="frmEditPicture" method="post" action="{{ url('picture-app/edit') }}" enctype="multipart/form-data">
                     <input type="hidden" name="picId" id="picId" value="" />
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group width-100Per">
                                    <input type="text" class="form-control" id="fileName" name="fileName" value=""  />
                                    <span class="form-highlight"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label" for="QueDescrp">Picture Name*</label>
                                    <span class="text-danger" id="filename-div"><strong id="form-errors-filename"></strong>                				</span>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-40">
                    <button type="submit" class="btn btn-raised btn-green pull-right">Update</button>
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
     <!-- Zoom image modal -->
    <div id="ZoomPik" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">View Image</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                   <img src="/storage/users_uploaded_files/pictures/amolsavat_7/1501659836598182bc10348.JPG" id="viewZoomPicture" class="img-responsive " alt="Image" />
                                </div>
                            </div><!--row end-->
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-40">
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection