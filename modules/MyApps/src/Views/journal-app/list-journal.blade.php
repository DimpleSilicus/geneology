@extends($theme.'.layouts.app')
@section('content')
	<section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Journal App</h2>
        </div>
    </section>
    <section class="min-height-450">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('myapps/apps') }}">Apps</a></li>
                        <li class="breadcrumb-item active">Journal App</li>
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
                        <button type="button" class="btn btn-green margin-B-20" id="btnSub" data-toggle="modal" data-target="#AddJournal">Add Journal</button>
                    </div>
					
                    <div class="table-responsive">
                        <table class="table" id="journal_table">
                            <thead>
                                <tr style="background: #dce0e4;">
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Owner</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            			   				
                            @if (count($arrJournal) > 0)
							@foreach ($arrJournal as $request)
                            
                                <tr id="jorrnalRow_{{$request['id']}}" >                       
                             			  
                                    <td>{{$request['name']}}</td>
                                    <td>{{$request['description']}}</td>
                                   <td>@if(Auth::user()->id == $request["owner"]) Self @else Shared by {{$request["owner"]}} @endif</td>
                                    <td class="dropdown">
                                    <input type="hidden" id="hiddenjournalid" name="txthiddenjournalid" >
                                    <input type="hidden" id="SharedId" name="SharedId" >
                                        <a href="#" class="table-icon dropdown-toggle" data-toggle="dropdown"><i class="fa fa-share-alt"></i></a>
                                        <ul id="userList" class="dropdown-menu dropdown-menu-left network-search-dropdown-icons">
                                            <li><a onclick="getJournalOnNetwork({{$request['id']}})" style="cursor: pointer;" class="table-icon"><i onclick="shareJournalOnMyNetwork()"  class="fa fa-group"></i> My Network</a></li>
                                            @if (count($arrNetworkUsers) > 0)
											@foreach ($arrNetworkUsers as $users)
											<li><a onclick="getSingleJournalDetails({{$request['id']}},{{$users['userid']}})" style="cursor: pointer;" class="table-icon"><i class="fa fa-user"></i>{{$users['username']}}</a></li>
                                            @endforeach
                                            @endif
                                        </ul>
                                          @if(Auth::user()->id == $request["owner"]) 
                                           	<a onclick="editJournal({{$request['id']}})" style="cursor: pointer;"  data-toggle="modal" data-target="#EditJournal"  class="table-icon"><i class="fa fa-pencil"></i></a>
                                      		<a onclick="deleteJournal({{$request['id']}})" style="cursor: pointer;" class="table-icon"><i class="fa fa-trash-o"></i></a>
                                          @endif
                                    </td>
                                </tr>
                             
                                @endforeach
								@else
                                <tr class="text-danger has-error"><td colspan='4' align="center">No Journal Found.</td></tr>
                                @endif
                                                                   
                            </tbody>
                        </table>
                    </div><!--table responsive end-->
                </div>
            </div><!--row end-->
        </div><!--container end-->
    </section>

	
	<!-- Modal -->
    <div id="AddJournal" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Journal</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per">
                                        <input type="text" class="form-control" id="JournalTitle" required>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="float-label" for="JournalTitles">Title</label>
                                        <span class="text-danger" id="name-div"><strong id="form-errors-name"></strong>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per">
                                        <textarea type="text" class="form-control" id="JournalDescrp" required></textarea>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="float-label" for="JournalDescrps">Description</label>
                                        <span class="text-danger" id="description-div"><strong id="form-errors-description"></strong>
                                    </div>
                                </div>
                            </div><!--row end-->
                        </div>
                    </form>
                </div>
             
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-40">
                    <button type="button" id="btnIdsubmit" onclick="AddNewJournal()" class="btn btn-raised btn-green pull-right">Add</button>
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- Modal -->
    <div id="EditJournal" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Journal</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per">
                                        <input type="text" class="form-control" id="JournalTitle1" required>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="float-label" for="JournalTitle1">Title</label>
                                        <span class="text-danger" id="name-div1"><strong id="form-errors-name1"></strong>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per">
                                        <textarea type="text" class="form-control" id="JournalDescrp1" required></textarea>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="float-label" for="JournalDescrp1">Description</label>
                                        <span class="text-danger" id="description-div1"><strong id="form-errors-description1"></strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <input type="hidden" name="name_hiddenid" id="idhidden" >
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-40">
                    <button type="button" id="btnIdSave" onclick="UpdateJournal()"  class="btn btn-raised btn-green pull-right">Save</button>
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection