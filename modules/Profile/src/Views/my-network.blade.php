@extends($theme.'.layouts.app')
@section('content')
<section class="background-maroon heading-section" >
    <div class="container">
        <h2 class="heading">Profile - My Network </h2>
    </div>
</section>



<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="responsiveTabs margin-T-0">
                    <ul id="profileTab" class="nav nav-tabs nav-stacked col-sm-2">
                        <li class="active"><a href="#search-profile" data-toggle="tab">My Network</a></li>
                         @if (isset(Auth::user()->type) && Auth::user()->type == 1)
                        <li><a href="#profile-pedigree" data-toggle="tab">Pedigree</a></li>
                        <li><a href="#profile-notification" class="tabNotifications" data-toggle="tab">Notifications</a></li>
                        <li><a href="#privacy-setting" class="tabPrivacySetting" data-toggle="tab">Privacy Settings</a></li>
                        @endif
                        <li><a href="#acct-setting" data-toggle="tab">Account Settings</a></li>
                        
                    </ul>
                    <div id="profileTabContent" class="tab-content col-sm-10">
                        <div class="tab-pane fade in active" id="search-profile">
                            <div class="panel-group nested-accordion" id="Network-accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading actives-accordion" role="tab" id="MyNetwork-Search">
                                        <h4 class="panel-title actives-accordion">
                                            <a role="button" data-toggle="collapse" data-parent="#Network-accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Search
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="MyNetwork-Search">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group col-md-4 col-sm-6">
                                                    <div class="input-group width-100Per">
                                                        <input type="text" class="form-control width-90Per" id="search_name" required name="search_name" />
                                                        <span class="form-highlight"></span>
                                                        <span class="form-bar"></span>
                                                        <label class="float-label" for="search_name" >Search</label>
                                                        <label class="input-group-addon modal-datepicker-ico" for="search_name" id="search_name_icon">
                                                            <span class="glyphicon glyphicon glyphicon-search"></span>
                                                        </label>
                                                        <span class="text-danger" id="searchname-div">
                                                            <strong id="form-errors-searchname"></strong>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="table-responsive hide" id="search_result_div">
                                                <div class="alert alert-success hide" id="addUsersuccMsg"></div>
                                                <div class="alert alert-danger hide" id="addUserfailMsg"></div>
                                                <table class="table" id="search_result_table">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th>Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--search accordion end-->
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="MyNetwork-Request">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#Network-accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Request Received
                                            </a>
                                        </h4>

                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="MyNetwork-Request">
                                        <div class="panel-body">
                                            <div class="margin-B-20">
                                                <button type="button" class="btn btn-default" data-toggle="modal" onclick="window.location.reload();" data-backdrop="static" data-keyboard="false">
                                                    <span class="glyphicon glyphicon-refresh pull-left"></span> &nbsp;Refresh</button>
                                            </div>
                                            <div class="table-responsive">
                                                <div class="alert alert-success hide" id="reqSuccMsg"></div>
                                                <div class="alert alert-danger hide" id="reqFailMsg"></div>
                                                <table class="table" id="userRequestsTable">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th>Name</th>
                                                            <th>Relation</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--request received accordion end-->
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="MyNetwork-Group">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#Network-accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                Group / Forum
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="MyNetwork-Group">
                                        <div class="panel-body">
                                            <div class="margin-B-20">
                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#CreateGroup" data-backdrop="static" data-keyboard="false">
                                                    <span class="glyphicon glyphicon-plus pull-left"></span> &nbsp;Create Group/Forum</button>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="table-responsive">
                                                <div class="alert alert-success hide" id="grpSuccMsg"></div>
                                                <div class="alert alert-danger hide" id="grpFailMsg"></div>
                                                <table class="table" id="grpTable">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th>Name</th>
                                                            <th>User</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--group accordion end-->
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="MyNetwork-Mailbox">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#Network-accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                Messages
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="MyNetwork-Mailbox">
                                        <div class="panel-body">
                                            <div class="margin-B-20">
                                                <button type="button" class="btn btn-default btnComposePartiMail"  >
                                                    <span class="glyphicon glyphicon-plus pull-left"></span> &nbsp;Compose
                                                </button>
                                            </div>
                                            <div class="table-responsive">
                                                <div class="alert alert-success hide" id="partiMailSuccMsg"></div>
                                                <div class="alert alert-danger hide" id="partiMailFailMsg"></div>
                                                <table class="table" id="mailboxTable">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th>Details</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--mailbox accordion end-->
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile-pedigree">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <select class="form-control has-info" id="userGedcom" placeholder="Placeholder">
                                            <option selected="selected">Select Gedcom</option>
                                            @if (count($arrUserGedcoms) > 0)
                                            @foreach ($arrUserGedcoms as $gedcom)
                                            <option value="{{$gedcom['id']}}">{{$gedcom['file_name']}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <button type="button" id="TreeViewButton" class="btn btn-green" data-id="1">View Horizontal Tree View</button>
                                    </div>
                                     <div class="col-sm-12" id="tree-ui">
                                   		 <div class="treeWrapper">
                                       
                               
                <div id="imageFullScreen" class="ui-draggable" style="position: relative;">
                    <div id="pk-family-tree" scale="1">
                        <div id="treeGround" class="tree-ground">
                            
                        </div>
                    </div>
                    <div id="pk-popmenu" style="top: 20px; left: 551.25px; display: none;">
                        <ul>
                            <li><i class="fa fa-plus-circle"></i> Add Member</li>
                            <li><i class="fa fa-eye"></i> View Details</li>
                            <li><i class="fa fa-trash-o"></i> Remove Member</li>
                            <li><span class="glyphicon glyphicon-remove-circle"></span> Cancel</li>
                        </ul>
                    </div>
                </div>

                <div id="pk-member-details"></div>
          
              </div>
                                    </div>
                                </div>
                            </div>
                            <div id="family_tree"></div>

                        </div><!--profile-pedigree tab content end-->
                        <!--profile-notification tab content start-->
                        <div class="tab-pane fade notification-content" id="profile-notification">

                        </div>
                        <!--profile-notification tab content end-->
                        <!--account-settings tab content start-->
                        <div class="tab-pane fade" id="acct-setting">
                            <div class="panel-group nested-accordion" id="account-accordion" role="tablist" aria-multiselectable="true">
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading actives-accordion" role="tab" id="subscription-details">
                                        <h4 class="panel-title actives-accordion">
                                            <a role="button" data-toggle="collapse" data-parent="#account-accordion" href="#collapseAcctOne" aria-expanded="true" aria-controls="collapseOne">
                                                Subscription
                                            </a>
                                        </h4>
                                    </div>                               
                                    
                                    
                                    <div id="collapseAcctOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="subscription-details">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr style="background: #dce0e4;">
                                                        <th>Package name</th>
                                                        <th>Package Description </th>
                                                        <th>Amount</th>
                                                        <th>Gedcom Files</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($MainArr['arrUserPackages']) > 0)
                                                    @foreach ($MainArr['arrUserPackages'] as $Userpackages) 
                                                    <tr>
                                                        <td>{{$Userpackages['name']}}</td>
                                                        <td>{{$Userpackages['description']}}</td>
                                                        <td>{{$Userpackages['amount']}}</td>
                                                        <td>{{$Userpackages['gedcom']}}</td>                                            
                                                    </tr>
                                                    @endforeach
                                                    @else

                                                    <tr class="text-danger has-error" ><td colspan='4' align="center">No Packages Found.</td></tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div><!--table responsive end-->
                                        <div class="panel-body">
                                            <div class="row">
                                                <form id="UserPackagePaid" role="form" method="POST" action="{{ url('user/UpgradeUserPackage') }}">
                                                    {!! csrf_field() !!}
                                                    <div class="form-group col-md-4 col-sm-6">
                                                        <div class="input-group width-100Per">
                                                            <select class="form-control has-info" id="Subscription" name="Subscription" placeholder="Placeholder">
                                                                <option value="">Select Package</option>
                                                                @if (count($MainArr['arrPackages']) > 0)
                                                                @foreach ($MainArr['arrPackages'] as $packages)                                                                   
                                                                <option value="{{$packages['id']}}">{{$packages['name']}}</option>
                                                                @endforeach
                                                                @else
                                                                <option selected="selected" value="">No Packages available.</option>                                                      
                                                                @endif
                                                            </select>
                                                            <span class="form-highlight"></span>
                                                            <span class="form-bar"></span>
                                                            <label for="Subscription" class="hasdrodown">Subscription</label>
                                                            @if ($errors->has('Subscription'))
                                                            <span class="text-danger">
                                                                {{ $errors->first('Subscription') }}
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-4 col-sm-6">
                                                        <button type="submit" class="btn btn-green">Upgrade</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--search accordion end-->
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="acct-change-password">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#account-accordion" href="#collapseAcctTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Change Password
                                            </a>
                                        </h4>
                                    </div>

                                    <div id="collapseAcctTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="acct-change-password">
                                        <div class="panel-body">
                                            <div class="alert alert-success hide" id="changePassSuccMsg"></div>
                                            <div class="alert alert-danger hide" id="changePassFailMsg"></div>
                                            <div class="row">
                                                <form id="frmChangePass" name="frmChangePass" method="post" action="{{ url('account/updatePassword') }}">
                                                    <div class="row">

                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <div class="input-group width-100Per">
                                                            <input type="password" class="form-control" id="old_password" name="old_password">
                                                            <span class="form-highlight"></span>
                                                            <span class="form-bar"></span>
                                                            <label class="float-label" for="email">Enter your current password</label>
                                                            <span class="text-danger" id="oldPass-div"><strong id="form-errors-oldPass"></strong>
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="form-group col-sm-6">
                                                        <div class="input-group width-100Per">
                                                            <input type="password" class="form-control" id="password" name="password" >
                                                            <span class="form-highlight"></span>
                                                            <span class="form-bar"></span>
                                                            <label class="float-label" for="Username">Enter your new password</label>
                                                            <span class="text-danger" id="newPass-div"><strong id="form-errors-newPass"></strong>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <div class="input-group width-100Per">
                                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" >
                                                            <span class="form-highlight"></span>
                                                            <span class="form-bar"></span>
                                                            <label class="float-label" for="Password">Re-enter new password</label>
                                                            <span class="text-danger" id="newConfPass-div"><strong id="form-errors-newConfPass"></strong>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 margin-T-20">
                                                        <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                                                        <button type="button" class="btn btn-raised btn-default pull-right margin-R-20">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--account-settings tab content end-->
                        <!--privacy-setting tab content start-->
                        <div class="tab-pane fade privacy-setting-content" id="privacy-setting">

                        </div>
                        <!--privacy-seeting tab content end-->
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="visible-sm margin-T-40"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <div class="card">
                            <div class="card-block" id="check_online">
                                <h4 class="card-title border-bttm padding-10">Connection online</h4>
                                <div class="table-responsive card-text no-border">
                                    <table id="online_connection" class="table margin-B-10">
                                        <tbody>
                                            @if (count($arrConnectedUsers) > 0)
                                            @foreach ($arrConnectedUsers as $users)
                                            @foreach($onlineUsers as $online)
                                          
                                                @if($users['userid']==$online['id'])
												@if($online->isOnline())
												<tr>
                                                <td><span class="person-status-online"></span><a style="text-decoration: none;" href="user-profile/{{$users['userid']}}" > {{$users['username']}}</a></td><td>{{$users['relation']}}</td>
                                                </tr>
                                                @else
                                               
                                                @endif
                                                @endif
                                                
                                            @endforeach
                                            @endforeach
                                            @else
                                            @endif
                                            <tr id="MsgNotOnline" style="display:none;">
                                                <td align="center" colspan="2" >No Users are Online</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <button type="button" class="btn btn-green margin-T-10">View All</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!--card end--->
                    </div><!--col-sm-6 end-->

                    <div class="col-md-12 col-sm-6">
                        <div class="hidden-sm margin-T-40"></div>
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title border-bttm padding-10">Suggestions</h4>
                                <div class="table-responsive card-text  no-border">
                                    <table id='suggestion_table' class="table margin-B-10">
                                        <tbody>
                                            <tr id="alert_suggest"><td colspan="4">
                                                    <div class="alert alert-success hide" id="deleteSuggestionMsg"></div>
                                                    <div class="alert alert-danger hide" id="deleteSuggestionfailMsg"></div>

                                                    <div class="alert alert-success hide" id="addUsersuccMsg"></div>
                                                    <div class="alert alert-danger hide" id="addUserfailMsg"></div>
                                                </td>
                                            </tr>

                                            @if (count($arrSuggestions) > 0)
                                            @foreach ($arrSuggestions as $suggestion)
                                            <tr id="suggest_id" sid="{{$suggestion->Suggestfriend}}">
                                                <td>{{ $suggestion->Suggestfriendname }}</td>
                                                <td class="dropdown">
                                                    <a href="#" class="table-icon dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus-circle"></i></a>
                                                    <ul class="dropdown-menu dropdown-menu-left network-search-dropdown">
                                                        <li><a href="#" class="suggestUser" uid={{ $suggestion->Suggestfriend }}>CloseFamily</a></li>
                                                        <li><a href="#" class="suggestUser" uid={{ $suggestion->Suggestfriend }}>Relative</a></li>
                                                        <li><a href="#" class="suggestUser" uid={{ $suggestion->Suggestfriend }}>ResearchConnection</a></li>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <a href="#" id="deleteSuggestion" class="table-icon" deleteId={{ $suggestion->Suggestfriend }} ><i class="fa fa-trash-o"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td>No Suggestions</td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <td colspan="2">
                                                    <button type="button" class="btn btn-green margin-T-10">View All</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!--card end--->
                    </div><!--right sidebar -->
                </div><!--row end-->
            </div>
        </div>
    </div><!--container end-->


    <!-- Modal -->
    <div id="CreateGroup" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form id="frmCreateGroup" name="frmCreateGroup" method="post" action="{{ url('group/create') }}">
                    <input type="hidden" name="inviUsers" id="inviUsers" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Create Group/Forum</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group width-100Per">
                                    <input type="text" class="form-control" id="groupName" name="groupName"  />
                                    <span class="form-highlight"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label" for="QueDescrp">Name of Group *</label>
                                    <span class="text-danger" id="groupname-div"><strong id="form-errors-groupname"></strong>                				</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control has-info" id="groupUsers" name="groupUsers" placeholder="Placeholder">
                                    <option value="">Select user</option>
                                    @foreach ($arrConnectedUsers as $user)
                                    <option value="{{$user['userid']}}">{{$user['username']}}</option>
                                    @endforeach
                                </select>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label for="AddPerson" class="hasdrodown">Who to Add? *</label>
                                <span class="text-danger" id="inviusers-div"><strong id="form-errors-inviusers"></strong>
                            </div>
                            <div class="form-group">
                                <div>Users invited to group appear here. Can be removed</div>
                                <div class="padding-TB-10" id="selGrpUsers">

                                </div>
                            </div>
                            <div class="form-group">
                                <textarea type="text" class="form-control" id="groupMsg" name="groupMsg"></textarea>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="StreamMsg">Introductory message for this stream? *</label>
                                <span class="text-danger" id="groupmsg-div"><strong id="form-errors-groupmsg"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer margin-T-20">
                        <button type="submit" class="btn btn-raised btn-green pull-right">Create</button>
                        <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="EditGroup" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form id="frmEditGroup" name="frmEditGroup" method="post" action="{{ url('group/create') }}">
                    <input type="hidden" name="editInviUsers" id="editInviUsers" value="" />
                    <input type="hidden" name="groupId" id="groupId" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Group/Forum</h4>
                    </div>
                    <div class="modal-body">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="input-group width-100Per">
                                    <input type="text" class="form-control" id="groupName" name="groupName" value=""  />
                                    <span class="form-highlight"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label" for="QueDescrp">Name of Group *</label>
                                    <span class="text-danger" id="groupname-div"><strong id="form-errors-groupname"></strong>                				</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <select class="form-control has-info" id="editGroupUsers" name="editGroupUsers" placeholder="Placeholder">
                                    <option value="">Select user</option>
                                    @foreach ($arrConnectedUsers as $user)
                                    <option value="{{$user['userid']}}">{{$user['username']}}</option>
                                    @endforeach
                                </select>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label for="AddPerson" class="hasdrodown">Who to Add? *</label>
                                <span class="text-danger" id="inviusers-div"><strong id="form-errors-inviusers"></strong>
                            </div>
                            <div class="form-group">
                                <div>Users invited to group appear here. Can be removed</div>
                                <div class="padding-TB-10" id="selGrpUsers">

                                </div>
                            </div>
                            <div class="form-group">
                                <textarea type="text" class="form-control" id="groupMSg" name="groupMSg"></textarea>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="StreamMsg">Introductory message for this stream? *</label>
                                <span class="text-danger" id="groupmsg-div"><strong id="form-errors-groupmsg"></strong>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer margin-T-20">
                        <button type="submit" class="btn btn-raised btn-green pull-right">Update</button>
                        <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="ComposeUserMail" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form id="frmComposeParticipantMessage" name="frmComposeParticipantMessage" method="post" action="{{ url('message/participant/compose') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Message To Participant</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <select class="form-control has-info" id="participant" name="participant" placeholder="Placeholder">
                                    <option value=""></option>
                                    @foreach ($arrConnectedUsers as $user)
                                    <option value="{{$user['userid']}}">{{$user['username']}}</option>
                                    @endforeach
                                </select>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label for="SelectParticipant" class="hasdrodown">Select Participant</label>
                                <span class="text-danger" id="participant-div"><strong id="form-errors-participant"></strong>
                            </div>
                            <div class="form-group">
                                <textarea type="text" class="form-control" id="groupMessagePrti" name="groupMessagePrti" ></textarea>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="StreamMsg">Message Details</label>
                                <span class="text-danger" id="groupMessagePrti-div"><strong id="form-errors-groupMessagePrti"></strong>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer margin-T-20">
                        <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                        <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <div id="ComposeGroupMail" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <form id="frmComposeGroupMessage" name="frmComposeGroupMessage" method="post" ">
                    <input type="hidden" name="groupId" id="groupId" value="" />
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Message To Group</h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-sm-12">
                            To Group: <span class=""  id="composeGroupName"></span>
                            <div class="form-group">
                                <textarea type="text" class="form-control" id="groupMessage" name="groupMessage" ></textarea>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="StreamMsg">Message Details</label>
                                <span class="text-danger" id="groupMessage-div"><strong id="form-errors-groupMessage"></strong>
                            </div>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                    <div class="modal-footer margin-T-20">
                        <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                        <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="confirm" class="modal hide fade">
        <div class="modal-body">
            Are you sure?
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
            <button type="button" data-dismiss="modal" class="btn">Cancel</button>
        </div>
    </div>
</section>

@endsection