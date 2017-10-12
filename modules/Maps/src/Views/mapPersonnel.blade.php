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
                            <li><a href="{{ asset('maps/worldmap') }}" >World View</a></li>
                            @if (Auth::user()->type == 1)
                            <li class="active"><a href="{{ asset('maps/personalmap') }}" style=" cursor: pointer;"  >Personal Gedcom View</a></li>
                            @endif
                        </ul>
                        <div id="gnhTabContent" class="tab-content">
						
							
							<!--World Map tab content start here -->
                           
                            <!--World Map tab content end-->
                            
                            <!--Personal Gedcom View tab content end-->
                            <form action="{{ url('maps/personalmap') }}" method="post" >
                            {!! csrf_field() !!}
                            <div id="gedcomMap-content">
                               <div class="row">
                                   <div class="col-md-4 col-sm-6">
                                       <div class="form-group">
                                           <div class="input-group width-100Per">
                                               <select onchange="this.form.submit()" class="form-control has-info" id="Gedcom" name="Gedcom" >
                                                   <option value="">Select</option>
                                                   @foreach($memberCountry as $country)
                                                   <option value="{{ $country['id'] }}">{{ $country['file_name'] }}</option>
                                                   @endforeach
                                               </select>
                                               <span class="form-highlight"></span>
                                               <span class="form-bar"></span>
                                               <label for="Dallas" class="hasdrodown">Select Gedcom</label>
                                           </div>
                                       </div>
                                   </div>
                               </div><!--row end-->
                                <div class="row">
                                    <div class="col-sm-12">
                                    
                                    @if(app('request')->input('Gedcom'))
                                         <div id="wordldMap"  class="googleMapStyle">{{ $map->searchPersonalMap(app('request')->input('Gedcom')) }}</div>
									@else
                                         <div id="personalGedcomMap" style="height:845px; width:100%;" class="googleMapStyle">{{ $map->getPersonalMap() }}</div>
                                    @endif  
                                    
                                    
                                    
                                       
                                    </div>
                                </div>   <!--row end-->                            
                            </div><!--Personal Gedcom View tab content end-->
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--container end-->
    </section>

@endsection