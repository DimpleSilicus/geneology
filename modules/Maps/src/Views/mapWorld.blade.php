@extends($theme.'.layouts.app')
@section('content')
       
<section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Maps</h2>
        </div>
    </section>
    <section>
        <div class="container">           
            <div class="row">
                <div class="col-sm-12">
                    <div class="responsiveTabs margin-T-0">
                        <ul id="mapTab" class="nav nav-tabs">
                            <li class="active"><a href="{{ asset('maps/worldmap') }}" style=" cursor: pointer;" >World View</a></li>
                            @if (Auth::user()->type == 1)
                            <li><a href="{{ asset('maps/personalmap') }}" >Personal Gedcom View</a></li>
                            @endif
                        </ul>
                        <div id="gnhTabContent" class="tab-content">
						
							
							<!--World Map tab content start here -->
                            <div class="tab-pane fade in active" id="worldmap-content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        Will only available for users having registered account.<br />
                                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                                    </div>
                                </div>
                                <form action="{{ url('maps/worldmap') }}" method="post" >
                                {!! csrf_field() !!}
                                <div class="row margin-T-40">
                                    <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                        <div class="input-group width-100Per">
                                            <input type="text" class="form-control" id="PersonName" name="PersonName" >
                                            <span class="form-highlight"></span>
                                            <span class="form-bar"></span>
                                            <label class="hasdrodown" for="PersonName">Name</label>
                                            <div id='lang'> </div>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                        <div class="input-group width-100Per date" data-provide="datepicker-inline">
                                            <input type="text" class="form-control" id="PersonDate"  name="PersonDate" />
                                            <span class="form-highlight"></span>
                                            <span class="form-bar"></span>
                                            <label class="hasdrodown" for="PersonDate">Date of Birth</label>
                                            <label class="input-group-addon modal-datepicker-ico" for="PersonDate">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                        <div class="input-group width-100Per">
                                            <input type="text" class="form-control" id="SearchPlace" name="SearchPlace" >
                                            <span class="form-highlight"></span>
                                            <span class="form-bar"></span>
                                            <label class="hasdrodown" for="SearchPlace">Place</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3 col-sm-6 col-xs-12">
                                        <div class="input-group width-100Per">
                                            <select class="form-control has-info" id="PersonYear" name="PersonYear" placeholder="Placeholder">
                                                <option value="">Select</option>
                                                <option value="1956">1956</option>
                                                <option value="1950">1950</option>
                                                <option value="1986">1986</option>
                                            </select>
                                            <span class="form-highlight"></span>
                                            <span class="form-bar"></span>
                                            <label for="PersonYear" class="hasdrodown">Year</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-raised btn-green pull-right">Map It</button>
                                        <button type="button" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div><!--row end-->
                                <div class="row margin-T-20">
                                    <div class="col-sm-12">
                                    @if(app('request')->input('SearchPlace'))
                                        <div id="wordldMap"  class="googleMapStyle">{{ $map->searchWorldMap(app('request')->input('SearchPlace') , app('request')->input('PersonName') , app('request')->input('PersonDate') , app('request')->input('PersonYear')) }}</div>
									@else
                                        <div id="wordldMap"  class="googleMapStyle">{{ $map->getWorldMap() }}</div>
                                    @endif    
                                    </div>
                                </div>
                                </form>
                                
                            </div>
                            <!--World Map tab content end-->
                            
                            <!--Personal Gedcom View tab content end-->
                            
                            <!--Personal Gedcom View tab content end-->
							
                        </div>
                    </div>
                </div>
            </div>
        </div><!--container end-->
    </section>

@endsection