@extends($theme.'.layouts.app')
@section('content')
<section class="background-maroon heading-section" >
    <div class="container">
        <h2 class="heading">User Profile</h2>
    </div>
</section>



<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ol class="breadcrumb">
                    <input type="hidden"  id="profID" value="{{ $profileID }}" > 
					<input type="hidden"  id="profRelation" > 
                    <li class="breadcrumb-item"><a href="#">Profile</a></li>                    																	
                    <li class="breadcrumb-item active">Profile Name: <iable id="proID" style="color:#95b43c; font-weight:bold;" ></iable></li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="responsiveTabs margin-T-0">
                    <ul id="profileTab" class="nav nav-tabs nav-stacked col-sm-2">
                        <li class="active"><a href="#search-profile" data-toggle="tab">Pictures</a></li>                 
                        <li><a href="#profile-pedigree" data-toggle="tab">Videos</a></li>
                        <li><a href="#profile-notification123" class="tabNotifications" data-toggle="tab">Journals</a></li>
                        <li><a href="#privacy-setting" class="tabPrivacySetting" data-toggle="tab">Events</a></li>
                       
                    </ul>
                    <div id="profileTabContent" class="tab-content col-sm-10">					
					
					    <!--Pictures Tab start here-->
                        <div class="tab-pane fade in active" id="search-profile">
                            <div class="panel-group nested-accordion" id="Network-accordion" role="tablist" aria-multiselectable="true">                           
								<div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="MyNetwork-Request">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button"   data-parent="#Network-accordion" style="background-color:#95b43c;"   aria-controls="collapseTwo">
                                                Pictures
                                            </a>
                                        </h4>
                                    </div>
                                    <div role="tabpanel" aria-labelledby="MyNetwork-Request">
                                        <div class="panel-body">
                                        
                                        
                                             <div class="table-responsive">                    
                                                <table class="table" id="picture_body" style=" display: none;">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th>Name</th>
                                                            <th>Owner</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($arrPictures))
                                                    @if (count($arrPictures) > 0)
                        							@foreach ($arrPictures as $picture)
                        							    @if($profileID == $picture["owner"])
                                                        <tr>
                                                            <td><a href="javascript:void(0);" data-target="#ZoomPik" class="viewPicture" data-toggle="modal" path="{{$appUrl}}{{$picture['path']}}"><i class="fa fa-picture-o margin-R-5"></i>{{$picture['name']}}</a></td>
                                                            <td> Self </td>                                                            
                                                        </tr>
                                                        @else
                                                        
                                                        @endif
                                                    @endforeach
                                                    @else
                                                    <tr class="text-danger has-error" ><td colspan='4' align="center">No Pictures Found.</td></tr>
                                                    @endif
                                                    @endif
                                                    </tbody>
                                                </table>
                                                
                                                 <table class="table" id="picture_msg" style=" display: none;">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th align="center">Sorry ... This Pictures are not accessible to you</th>                                                            
                                                        </tr>
                                                    </thead>                                             
                                                </table>
                                            </div><!--table responsive end-->
                                            
                                            
                                        </div>
                                    </div>
                                </div>                               
                            </div>
                        </div>
						<!--Pictures Tab end here-->
						
						
											
						<!--Videos Tab start here-->
                        <div class="tab-pane fade" id="profile-pedigree">
                             <div class="panel-group nested-accordion" id="Network-accordion" role="tablist" aria-multiselectable="true"> 
                                
								<div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="MyNetwork-Request">
                                        <h4 class="panel-title" style="background-color:#95b43c;" >
                                            <a class="collapsed" role="button"  data-parent="#Network-accordion"   aria-controls="collapseTwo">
                                               Videos
                                            </a>
                                        </h4>

                                    </div>
                                    <div role="tabpanel" aria-labelledby="MyNetwork-Request">
                                        <div class="panel-body">                                        
                                        
                                        
                                            <div class="table-responsive">                    
                                                <table class="table" id="video_body" style=" display: none;">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th>Name</th>
                                                            <th>Owner</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if(isset($arrVideos))
                                                    @if (count($arrVideos) > 0)
                        							@foreach ($arrVideos as $video)
                        							    @if($profileID == $video["owner"])
                                                        <tr>
                                                            <td><a href="javascript:void(0);" data-target="#ZoomVideo" class="viewVideo" data-toggle="modal" path="{{$appUrl}}{{$video['path']}}"><i class="fa fa-video-camera margin-R-5"></i>{{$video['name']}}</a></td>
                                                            <td>Self</td>                                                          
                                                        </tr>
                                                        @else
                                                        
                                                        @endif
                                                        
                                                    @endforeach
                                                    @else
                                                    <tr class="text-danger has-error" ><td colspan='4' align="center">No Videos Found.</td></tr>
                                                    @endif
                                                    @endif
                                                    </tbody>
                                                </table>
                                                
                                                
                                                <table class="table" id="video_msg" style=" display: none;">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th align="center">Sorry ... This Videos are not accessible to you</th>                                                            
                                                        </tr>
                                                    </thead>                                             
                                                </table>
                                                
                                            </div><!--table responsive end-->
                                            
                                        </div>
                                    </div>
                                </div>						
                            </div>                  
                        </div>
						<!--Videos Tab end here-->
						
						
						
                        <!--Journal Tab start here-->
                        <div class="tab-pane fade notification-content123" id="profile-notification123">
						
						<div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="MyNetwork-Request" style="background-color:#95b43c;" >
                                        <h4 class="panel-title"  >
                                            <a class="collapsed" role="button"   data-parent="#Network-accordion"  aria-controls="collapseTwo">
                                                Journals
                                            </a>
                                        </h4>

                                    </div>
                                    <div    role="tabpanel" aria-labelledby="MyNetwork-Request">
                                        <div class="panel-body">
                                              <div class="table-responsive">
                                                    <table class="table"  id="journal_body" style=" display: none;">
                                                        <thead>
                                                            <tr style="background: #dce0e4;">
                                                                <th>Title</th>
                                                                <th>Description</th>
                                                                <th>Owner</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @if(isset($arrJournal))			   				
                                                        @if (count($arrJournal) > 0)
                            							@foreach ($arrJournal as $request)       
                            							    @if($profileID == $request["owner"])                                                 
                                                            <tr> 
                                                                <td>{{$request['name']}}</td>
                                                                <td>{{$request['description']}}</td>
                                                                <td>self</td>                                                                
                                                            </tr>       
                                                            @else
                                                                 
                                                            @endif                                                  
                                                        @endforeach
                            							@else
                                                        <tr class="text-danger has-error"><td colspan='4' align="center">No Journal Found.</td></tr>
                                                        @endif
                                                        @endif                                       
                                                        </tbody>
                                                        
                                                    </table>
                                                    
                                                    <table class="table" id="journal_msg" style=" display: none;">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th align="center">Sorry ... This Journals are not accessible to you</th>                                                            
                                                        </tr>
                                                    </thead>                                             
                                                    </table>
                                                </div><!--table responsive end-->
                                        </div>
                                    </div>
                                </div>
                        </div>
						<!--Journal Tab end here-->
						
						
                       
                        <!--Events Tab start here-->
                        <div class="tab-pane fade privacy-setting-content1" id="privacy-setting">						
								<div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="MyNetwork-Request" style="background-color:#95b43c;">
                                        <h4 class="panel-title" >
                                            <a class="collapsed" role="button"   data-parent="#Network-accordion"    aria-controls="collapseTwo">
                                                Events
                                            </a>
                                        </h4>

                                    </div>
                                    <div    role="tabpanel" aria-labelledby="MyNetwork-Request">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr style="background: #dce0e4;">
                                                            <th>Event Name</th>
                                                            <th>Owner</th>
                                                            <th>Date</th>
                                                            <th>Place</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="event_body" style=" display: none;">
                                                    @if(isset($arrEvents))	
                                                    @if (count($arrEvents) > 0)
                        							@foreach ($arrEvents as $events)
                                                        @if($profileID == $events["owner"])
                                                        <tr>
                                                            <td>{{$events['name']}}</td>
                                                            <td>Self</td>
                                                            <td>{{$events['event_date']}}</td>
                                                            <td>{{$events['place']}}</td>                                                           
                                                        </tr>
                                                        @else
                                                        
                                                        @endif
                                                    @endforeach
                        							@else
                                                        <tr class="text-danger has-error"><td colspan='4' align="center">No Events Found.</td></tr>
                                                    @endif
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div><!--table responsive end-->
                                        </div>
                                    </div>
                                </div> 
                        </div>
                        <!--Events Tab end here-->
						
						
                    </div>
                </div>
            </div>   
          
            
        </div>
    </div><!--container end-->
   
</section>

@endsection