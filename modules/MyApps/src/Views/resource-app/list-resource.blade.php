@extends($theme.'.layouts.app')
@section('content')

<section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Resource App</h2>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 margin-B-20">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('myapps/apps') }}">Apps</a></li>
                        <li class="breadcrumb-item active">Resource App</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12" id="Resource_Queue">
                    <div class="responsiveTabs margin-T-0">
                        <ul id="gnhTab" class="nav nav-tabs">
                            <li class="active"><a href="#search-content" data-toggle="tab">Search</a></li>
                            <li><a href="#resource-details" data-toggle="tab">Resource Queue</a></li>
                        </ul>
                        <div id="gnhTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="search-content">
                                <div class="row">
                                    <div class="form-group col-md-3 col-sm-6">
                                        <div class="input-group width-100Per">
                                            <input type="text" class="form-control" id="ResourceName" name="ResourceName" required>
                                            <span class="form-highlight"></span>
                                            <span class="form-bar"></span>
                                            <label class="float-label" for="ResourceName">Name</label>
                                            <span class="text-danger" id="ResourceName-div"><strong id="form-errors-ResourceName"></strong>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-sm-6">
                                        <div class="input-group width-100Per">
                                            <input type="text" class="form-control" id="ResourcePlace" name="ResourcePlace" required>
                                            <span class="form-highlight"></span>
                                            <span class="form-bar"></span>
                                            <label class="float-label" for="ResourcePlace">Place</label>
                                            <span class="text-danger" id="ResourcePlace-div"><strong id="form-errors-ResourcePlace"></strong>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-sm-6">
                                        <div class="input-group width-100Per">
                                            <select class="form-control has-info" id="ResourceYear" name="ResourceYear" placeholder="Placeholder">
                                                <option value="">Select</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option>
                                                <option value="2017">2017</option>
                                            </select>
                                            <span class="form-highlight"></span>
                                            <span class="form-bar"></span>
                                            <label for="ResourceYear" class="hasdrodown">Year</label>
                                            <span class="text-danger" id="ResourceYear-div"><strong id="form-errors-ResourceYear"></strong>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-sm-6">
                                        <div class="input-group width-100Per">
                                            <input type="text" class="form-control" id="GenGap" name="GenGap" required>
                                            <span class="form-highlight"></span>
                                            <span class="form-bar"></span>
                                            <label class="float-label" for="GenGap">Generation Gap</label>
                                            <span class="text-danger" id="GenerationGap-div"><strong id="form-errors-GenerationGap"></strong>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="button" id="serchQueueBtn" class="btn btn-raised btn-green pull-right">Submit</button>
                                        <button type="button" id="cancleBtn" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div><!--row end-->
                                <div class="clearfix"></div>
                                <div class="table-responsive margin-T-40">
                                    <table class="table" id="searchResourceResult">
                                        <thead>
                                            <tr style="background: #dce0e4;">
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="resource-details">
                            
                                 <div class="flash-message">
                        		@foreach (['danger', 'warning', 'success', 'info'] as $msg)
                          		@if(Session::has($msg))
                          		<p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                          		@endif
                        		@endforeach
								</div>
                            
                                <div class="text-right margin-B-20">
                                    <button type="button" class="btn btn-ghost btn-green" data-toggle="modal" data-target="#AddQue" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-plus pull-left"></span> &nbsp;Add Queue</button>
                                </div>
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr style="background: #dce0e4;">
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        @if (count($arrQueue) > 0)
										@foreach ($arrQueue as $queue)
										<tr>
                                                <td>
                                                {{$queue['name']}}  
                                               
                                                @if(empty($queue['path'])) 
                                                
                                                @else
                                                +  
                                                @if($file = substr($queue['path'], strrpos($queue['path'], '/') + 1)) 
                                                <a target='_blank' href="{{$queue['path']}}" style="cursor: pointer;" class="table-icon">
                                                {{ $file }}
                                                </a> 
                                                @endif
                                                @endif
                                                </td>
                                                <td>
                                                    <a onclick="deleteQueue({{$queue['id']}})" style="cursor: pointer;" class="table-icon"><i class="fa fa-trash-o"></i></a>
                                                </td>
                                        </tr>
                                        @endforeach
										@endif
     
                                        </tbody>
                                    </table>
                                </div>
                            </div><!--resource details tab content end-->
                        </div>
                    </div>
                </div>
            </div>
        </div><!--container end-->
    </section>
	
	 <!-- Modal -->
    <div id="AddQue" class="modal fade" role="dialog">
     
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Queue</h4>
                </div>
                <div class="modal-body">
                   <!--  <form id="frmAddQueue" name="frmAddQueue"  enctype="multipart/form-data"  > -->
                   <form id="frmAddQueue" name="frmAddQueue"  enctype="multipart/form-data" method="post" action="{{ url('resource-app/addQueue') }}"  > 
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per">
                                        <textarea type="text" class="form-control" id="QueDescrp" ></textarea>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="float-label" for="QueDescrp">Description</label>
                                        <span class="text-danger" id="QueDescrp-div"><strong id="form-errors-QueDescrp"></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row upload-Gedcom-file">
                                <div class="col-sm-12">
                                    <h5>Upload File</h5>
                                    <div class="form-group margin-TB-0">
                                        <input id="FileUpload" name="FileUpload" type="file" class="file"  >
                                    </div>
                                   
                                    <small>Maximum file size is 75MB.</small><br>
                                    <span class="text-danger" id="UploadFile-div"><strong id="form-errors-UploadFile"></strong>
                                   
                                    <!--file uploader form end here-->
                                </div>
                            </div><!--row end-->                          
                        </div>
                   
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-40">
                    <!--  <button type="submit" onclick="AddQueue()"  class="btn btn-raised btn-green pull-right">Add</button> -->
                    
                    
                    <button type="submit" class="btn btn-raised btn-green pull-right">Add</button>
                    <button type="button" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
         
    </div>
    
    
     <!-- Modal -->
    <div id="viewDescription" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Member Details</h4>
                </div>
                    <form>
                        <table class="table" id="viewResult">                                     
                        <tbody>
                             <tr><td><b>Member Name</b></td><td id="memberName"></td></tr>   
                             <tr><td><b>Gender     </b></td><td id="gender"></td></tr>
                             <tr><td><b>Birth Date     </b></td><td id="birthDate"></td></tr>
                             <tr><td><b>Place     </b></td><td id="place"></td></tr>
                             <tr><td><b>Notes</b></td><td id="notes"></td></tr>   
                             <tr><td><b>Generation Gap</b></td><td id="generGap"></td></tr>   
                        </tbody>
                        </table>
                    </form>
                <div class="modal-footer margin-T-40">
                    <button type="button" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection