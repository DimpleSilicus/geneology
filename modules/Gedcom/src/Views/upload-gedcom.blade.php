@extends($theme.'.layouts.app')
@section('content')
<section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Upload Gedcom</h2>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                          @if(Session::has($msg))
                          <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                          @endif
                        @endforeach
  					</div>
                    When you upload a family tree file, all of the people in it are placed into a new tree on GNH sites. The name you choose to give your tree will be visible to your guests and other members of GNH sites.
                </div>
                <div class="col-md-8 col-sm-12 align-center upload-Gedcom-file margin-T-20">
                    <h5>Upload Gedcom</h5>
                    <form id="frmUploadGedcom" name="frmUploadGedcom" method="post" action="{{ url('gedcom/upload') }}" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                        <div class="form-group margin-TB-0">
                            <input id="gedcomFile" name="gedcomFile" type="file" class="file" data-upload-url="#" required="">
                             <button type="submit" class="btn btn-raised btn-green pull-right">Upload</button>
                        </div>
                        
                    </form> <!--file uploader form end here-->
                    <small>Maximum file size is 75MB.</small>
                </div>
            </div><!--row end-->
            <div class="row margin-T-50">
                <div class="col-sm-12">
                
                    <h3 class="sub-heading">Tool Box</h3>
                    If you do not have Gedcom file, you can also mention your ancestral information in the bleow Tool Box.
                    <div class="responsiveTabs">
                        <ul id="gnhTab" class="nav nav-tabs">
                            <li class="active"><a href="#PreviousGen" data-toggle="tab">Previous Generation</a></li>
                            <li><a href="#PreviousGen1" data-toggle="tab">Previous 1st Generation Above</a></li>
                            <li><a href="#PreviousGen2" data-toggle="tab">Previous 2nd Generation Above</a></li>
                        </ul>
                        <div id="gnhTabContent" class="tab-content">
                            <div class="tab-pane fade in active" id="PreviousGen">
                                <div class="text-right margin-B-20">
                                    <button type="button" class="btn btn-ghost btn-green" data-toggle="modal" data-target="#addFamilyModal" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-plus pull-left"></span> &nbsp;Add Family</button>
                                    <button type="button" class="btn btn-ghost btn-green" data-toggle="modal" data-target="#addPepoleModal" gene="third" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-plus pull-left"></span> &nbsp;Add People</button>
                                </div>
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr style="background: #dce0e4;">
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if (true == isset($arrFamilyMembers['PreviousGen']) && count($arrFamilyMembers['PreviousGen']) > 0)
                                        @foreach ($arrFamilyMembers['PreviousGen'] as $member)
                                        	<tr>
                                                <td>{{$member['name']}}</td>
                                                <td>
                                                    <a href="#" class="table-icon editPepole" mid={{$member['id']}}><i class="fa fa-pencil"></i></a>
                                                    <a href="#" class="table-icon"><i class="fa fa-trash-o deleteMember" mid={{$member['id']}}></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr><td colspan='2' align="center"> No Data Found.</td></tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="PreviousGen1">
                                <div class="text-right margin-B-20">
                                   <button type="button" class="btn btn-ghost btn-green" data-toggle="modal" data-target="#addFamilyModal" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-plus pull-left"></span> &nbsp;Add Family</button>
                                    <button type="button" class="btn btn-ghost btn-green" data-toggle="modal" data-target="#addPepoleModal" gene="third" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-plus pull-left"></span> &nbsp;Add People</button>
                                </div>
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr style="background: #dce0e4;">
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if (true == isset($arrFamilyMembers['PreviousGen1']) && count($arrFamilyMembers['PreviousGen1']) > 0)
                                        @foreach ($arrFamilyMembers['PreviousGen1'] as $member)
                                        	<tr>
                                                <td>{{$member['name']}}</td>
                                                <td>
                                                    <a href="#" class="table-icon"><i class="fa fa-pencil"></i></a>
                                                    <a href="#" class="table-icon"><i class="fa fa-trash-o deleteMember" mid={{$member['id']}}></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr><td colspan='2' align="center"> No Data Found.</td></tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="PreviousGen2">
                                <div class="text-right margin-B-20">
                                	<button type="button" class="btn btn-ghost btn-green" data-toggle="modal" data-target="#addFamilyModal" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-plus pull-left"></span> &nbsp;Add Family</button>
                                    <button type="button" class="btn btn-ghost btn-green" data-toggle="modal" data-target="#addPepoleModal" gene="third" data-backdrop="static" data-keyboard="false"><span class="glyphicon glyphicon-plus pull-left"></span> &nbsp;Add People</button>
                                </div>
                                <div class="clearfix"></div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr style="background: #dce0e4;">
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @if (true == isset($arrFamilyMembers['PreviousGen2']) && count($arrFamilyMembers['PreviousGen2']) > 0)
                                        @foreach ($arrFamilyMembers['PreviousGen2'] as $member)
                                        	<tr>
                                                <td>{{$member['name']}}</td>
                                                <td>
                                                    <a href="#" class="table-icon"><i class="fa fa-pencil"></i></a>
                                                    <a href="#" class="table-icon"><i class="fa fa-trash-o deleteMember" mid={{$member['id']}}></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @else
                                        <tr><td colspan='2' align="center"> No Data Found.</td></tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--container end-->
    </section>
    <!--Pepole Modal -->
    <div id="addPepoleModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add People</h4>
                </div>
                <div class="modal-body">
                    <form id="frmAddPepole" name="frmAddPepole" method="post" ">
                     <input type="hidden" name="eventRowsData" id="eventRowsData" value="" />
                     <input type="hidden" name="eventRowsValues" id="eventRowsValues" value="" />
                      <input type="hidden" name="generation" id="generation" value="" />
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-sm-8">
                                    <div class="input-group width-100Per">
                                        <input type="text" class="form-control" id="genName" name="genName" >
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="hasdrodown" for="genName">Name</label>
                                        <span class="text-danger" id="genName-div"><strong id="form-errors-genName"></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-4 col-xs-12">
                                    <div class="input-group width-100Per date" data-provide="datepicker-inline">
                                        <input type="text" class="form-control" id="personDate" name="personDate" />
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="hasdrodown" for="personDob">Date</label>
                                        <label class="input-group-addon modal-datepicker-ico" for="GenDOB">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </label>
                                         <span class="text-danger" id="personEvents-div"><strong id="form-errors-personEvents"></strong>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4 col-xs-12">
                                    <div class="input-group width-100Per">
                                        <select class="form-control has-info" id="personDateType" name="personDateType" placeholder="Placeholder">
                                        	@foreach ($arrEvents as $event)
                                     			<option value="{{$event['id']}}">{{$event['name']}}</option>
                                   			@endforeach
                                        </select>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label for="GenBirth" class="hasdrodown">Event</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-3 col-xs-9">
                                    <div class="input-group width-100Per">
                                        <select class="form-control has-info" id="personPlace" name="personPlace" placeholder="Placeholder">                                           
                                            <?php $countryArr = Config::get('country.country'); 
                                                $countCountryArr= count($countryArr)
                                            ?>
                                            @if (count($countryArr) > 0)
                                                @for ($i = 1; $i <= $countCountryArr; $i++)                                                   
                                                    <option value="{{$countryArr[$i]}}">{{$countryArr[$i]}}</option>
                                                @endfor
                                            @endif 
                                        </select>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label for="Dallas" class="hasdrodown">Place</label>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-xs-3 margin-T-40">
                                    <a href="#" class="modal-icon"><i class="fa fa-plus-circle addPepole-ico-plus"></i></a>
                                </div>
                            </div><!--row end-->
                            <div id="eventRows">
                       	
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-8">
                                <select class="form-control has-info" id="personFamily" name="personFamily" placeholder="Placeholder">
                                <option value="">Select Family</option>
                                    	@foreach ($arrFamilies as $family)
                                 			<option value="{{$family['id']}}">{{$family['family_name']}}</option>
                               			@endforeach
                                </select>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label for="Gedcom" class="hasdrodown">Family</label>
                                <span class="text-danger" id="personFamily-div"><strong id="form-errors-personFamily"></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-8">
                                    <select class="form-control has-info" id="personRelation" name="personRelation" placeholder="Placeholder">
                                    	<option value="">Select Relation</option>
                                        <option value="father">Father</option>
                                        <option value="mother">Mother</option>
                                        <option value="sister">Sister</option>
                                        <option value="brother">Brother</option>
                                    </select>
                                    <span class="form-highlight"></span>
                                    <span class="form-bar"></span>
                                    <label for="Gedcom" class="hasdrodown">Relation</label>
                                     <span class="text-danger" id="personRelation-div"><strong id="form-errors-personRelation"></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 margin-T-20">

                                </div>
                            </div>
                        </div>
                   
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--Family Modal -->
    <div id="addFamilyModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Family</h4>
                </div>
                <div class="modal-body">
                    <form id="frmAddFamily" name="frmAddFamily" method="post" ">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-sm-8">
                                    <div class="input-group width-100Per">
                                        <input type="text" class="form-control" id="familyName" name="familyName" >
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="hasdrodown" for="genName">Family Name</label>
                                        <span class="text-danger" id="famName-div"><strong id="form-errors-famName"></strong>
                                    </div>
                                </div>
                            </div>
                		</div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--Edit Member Modal -->
    <div id="editPepoleModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit People</h4>
                </div>
                <div class="modal-body">
                    <form id="frmEditPepole" name="frmEditPepole" method="post" ">
                     <input type="hidden" name="memId" id="memId" value="" />
                     <input type="hidden" name="eventRowsData" id="eventRowsData" value="" />
                     <input type="hidden" name="eventRowsValues" id="eventRowsValues" value="" />
                      <input type="hidden" name="generation" id="generation" value="" />
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-sm-8">
                                    <div class="input-group width-100Per">
                                        <input type="text" class="form-control" id="genName" name="genName" >
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="hasdrodown" for="genName">Name</label>
                                        <span class="text-danger" id="genName-div"><strong id="form-errors-genName"></strong>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-4 col-xs-12">
                                    <div class="input-group width-100Per date" data-provide="datepicker-inline">
                                        <input type="text" class="form-control" id="personDate" name="personDate" />
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="hasdrodown" for="personDob">Date</label>
                                        <label class="input-group-addon modal-datepicker-ico" for="GenDOB">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </label>
                                         <span class="text-danger" id="personEvents-div"><strong id="form-errors-personEvents"></strong>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4 col-xs-12">
                                    <div class="input-group width-100Per">
                                        <select class="form-control has-info" id="personDateType" name="personDateType" placeholder="Placeholder">
                                        	@foreach ($arrEvents as $event)
                                     			<option value="{{$event['id']}}">{{$event['name']}}</option>
                                   			@endforeach
                                        </select>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label for="GenBirth" class="hasdrodown">Event</label>
                                    </div>
                                </div>
                                <div class="form-group col-sm-3 col-xs-9">
                                    <div class="input-group width-100Per">
                                        <select class="form-control has-info" id="personPlace" name="personPlace" placeholder="Placeholder">
                                            <option selected="selected">Test</option>
                                            <option value="Test">Test</option>
                                            <option value="Test">Test</option>
                                        </select>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label for="Dallas" class="hasdrodown">Place</label>
                                    </div>
                                </div>
                                <div class="col-sm-1 col-xs-3 margin-T-40">
                                    <a href="#" class="modal-icon"><i class="fa fa-plus-circle editPepole-ico-plus"></i></a>
                                </div>
                            </div><!--row end-->
                            <div id="eventRows">
                       	
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-8">
                                <select class="form-control has-info" id="personFamily" name="personFamily" placeholder="Placeholder">
                                <option value="">Select Family</option>
                                    	@foreach ($arrFamilies as $family)
                                 			<option value="{{$family['id']}}">{{$family['family_name']}}</option>
                               			@endforeach
                                </select>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label for="Gedcom" class="hasdrodown">Family</label>
                                <span class="text-danger" id="personFamily-div"><strong id="form-errors-personFamily"></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-8">
                                    <select class="form-control has-info" id="personRelation" name="personRelation" placeholder="Placeholder">
                                    	<option value="">Select Relation</option>
                                        <option value="father">Father</option>
                                        <option value="mother">Mother</option>
                                        <option value="sister">Sister</option>
                                        <option value="brother">Brother</option>
                                    </select>
                                    <span class="form-highlight"></span>
                                    <span class="form-bar"></span>
                                    <label for="Gedcom" class="hasdrodown">Relation</label>
                                     <span class="text-danger" id="personRelation-div"><strong id="form-errors-personRelation"></strong>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 margin-T-20">

                                </div>
                            </div>
                        </div>
                   
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection