@extends($theme.'.layouts.app')
@section('content')

<section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Event App</h2>
        </div>
    </section>
    <section class="min-height-450">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('myapps/apps') }}">Apps</a></li>
                        <li class="breadcrumb-item active">Event App</li>
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
                        <button type="button" class="btn btn-green margin-B-20" data-toggle="modal" data-target="#AddEvent">Add Event</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr style="background: #dce0e4;">
                                    <th>Event Name</th>
                                    <th>Owner</th>
                                    <th>Date</th>
                                    <th>Place</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($arrEvents) > 0)
							@foreach ($arrEvents as $request)
                                <tr>
                                    <td> {{$request['name']}}</td>
                                    <td>@if(Auth::user()->id == $request["owner"]) Self @else Shared by {{$request["owner"]}} @endif</td>
                                    <td>{{$request['event_date']}}</td>
                                    <td>{{$request['place']}}</td>
                                    <td class="dropdown">
                                    <input type="hidden" id="EventRowId" name="EventRowId" >
                                    <input type="hidden" id="SharedId" name="SharedId" >
                                        <a href="#" class="table-icon dropdown-toggle" data-toggle="dropdown"><i class="fa fa-share-alt"></i></a>
                                        <ul id="sharedList" class="dropdown-menu dropdown-menu-left network-search-dropdown-icons">
                                            <li><a onclick="getEventsOnNetwork({{$request['id']}})" style="cursor: pointer;" class="table-icon"><i onclick="shareEventOnMyNetwork()"  class="fa fa-group"></i> My Network</a></li>
                                            @if (count($arrNetworkUsers) > 0)
											@foreach ($arrNetworkUsers as $users)
											<li><a onclick="getSingleEvents({{$request['id']}},{{$users['userid']}})" style="cursor: pointer;" class="table-icon"><i class="fa fa-user"></i>{{$users['username']}}</a></li>
                                            @endforeach
                                            @endif
                                        </ul>
                                        @if(Auth::user()->id == $request["owner"])
                                        <a onclick="editEvent({{$request['id']}})" class="table-icon" style="cursor: pointer;" data-toggle="modal" data-target="#EditEvent" ><i class="fa fa-pencil"></i></a>
                                        <a onclick="deleteEvent({{$request['id']}})" style="cursor: pointer;"  class="table-icon"><i class="fa fa-trash-o"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
							@else
                                <tr class="text-danger has-error"><td colspan='4' align="center">No Events Found.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div><!--table responsive end-->
                </div>
            </div><!--row end-->
        </div><!--container end-->
    </section>
	
	 <!-- Modal -->
    <div id="AddEvent" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Event</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per">
                                        <input type="text" class="form-control" id="EventName" required>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="hasdrodown" for="EventName">Event Name</label>
                                        <span class="text-danger" id="EventName-div"><strong id="form-errors-EventName"></strong>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per date" data-provide="datepicker-inline">
                                        <input type="text" class="form-control" id="EventDate" required name="GenDOB" />
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="hasdrodown" for="EventDate">Event Date</label>
                                        <label class="input-group-addon modal-datepicker-ico" for="GenDOB">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </label>
                                        <span class="text-danger" id="EventDate-div"><strong id="form-errors-EventDate"></strong>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per">
                                        <select class="form-control has-info" id="EventPlace" placeholder="Placeholder">                                            
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
                                        <label for="EventPlace" class="hasdrodown">Event Place</label>
                                        <span class="text-danger" id="EventPlace-div"><strong id="form-errors-EventPlace"></strong>
                                    </div>
                                </div>
                            </div><!--row end-->
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-40">
                    <button type="button" id="btnIdsubmit" onclick="AddNewEvent()" class="btn btn-raised btn-green pull-right">Add</button>
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    
     <!-- Modal -->
    <div id="EditEvent" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Event</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per">
                                        <input type="text" class="form-control" id="fieldEventName" required>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="hasdrodown" for="EventName">Event Name</label>
                                        <span class="text-danger" id="EventName-div2"><strong id="form-errors-EventName2"></strong>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per date" data-provide="datepicker-inline">
                                        <input type="text" class="form-control" id="fieldEventDate" required name="GenDOB" />
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label class="hasdrodown" for="EventDate">Event Date</label>
                                        <label class="input-group-addon modal-datepicker-ico" for="GenDOB">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </label>
                                        <span class="text-danger" id="EventDate-div2"><strong id="form-errors-EventDate2"></strong>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <div class="input-group width-100Per">
                                        <select class="form-control has-info" id="fieldEventPlace" placeholder="Placeholder">
                                            <option value="">Select Place</option>
                                                                                           <option value="Afghanistan">Afghanistan</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Albania">Albania</option>
                                                <option value="Andorra">Andorra</option>
                                                <option value="Angola">Angola</option>
                                                <option value="Antigua & Deps">Antigua & Deps</option>
                                                <option value="Argentina">Argentina</option>
                                                <option value="Armenia">Armenia</option>
                                                <option value="Australia">Australia</option>
                                                <option value="Austria">Austria</option>
                                                <option value="Azerbaijan">Azerbaijan</option>
                                                <option value="Bahamas">Bahamas</option>
                                                <option value="Bahrain">Bahrain</option>
                                                <option value="Bangladesh">Bangladesh</option>
                                                <option value="Barbados">Barbados</option>
                                                <option value="Belarus">Belarus</option>
                                                <option value="Belgium">Belgium</option>
                                                <option value="Belize">Belize</option>
                                                <option value="Benin">Benin</option>
                                                <option value="Bhutan">Bhutan</option>
                                                <option value="Bolivia">Bolivia</option>
                                                <option value="Bosnia Herzegovina">Bosnia Herzegovina</option>
                                                <option value="Botswana">Botswana</option>
                                                <option value="Brazil">Brazil</option>
                                                <option value="Brunei">Brunei</option>
                                                <option value="Bulgaria">Bulgaria</option>
                                                <option value="Burkina">Burkina</option>
                                                <option value="Burundi">Burundi</option>
                                                <option value="Cambodia">Cambodia</option>
                                                <option value="Cameroon">Cameroon</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Cape Verde">Cape Verde</option>
                                                <option value="Central African Rep<">Central African Rep</option>
                                                <option value="Chad">Chad</option>
                                                <option value="Chile">Chile</option>
                                                <option value="China">China</option>
                                                <option value="Colombia">Colombia</option>
                                                <option value="Comoros">Comoros</option>
                                                <option value="Congo">Congo</option>
                                                <option value="Congo {Democratic Rep}">Congo {Democratic Rep}</option>
                                                <option value="Costa Rica">Costa Rica</option>
                                                <option value="Croatia">Croatia</option>
                                                <option value="Cuba">Cuba</option>
                                                <option value="Cyprus">Cyprus</option>
                                                <option value="Czech Republic">Czech Republic</option>
                                                <option value="Denmark">Denmark</option>
                                                <option value="Djibouti">Djibouti</option>
                                                <option value="Dominica">Dominica</option>
                                                <option value="Dominican Republic">Dominican Republic</option>
                                                <option value="East Timor">East Timor</option>
                                                <option value="Ecuador">Ecuador</option>
                                                <option value="Egypt">Egypt</option>
                                                <option value="El Salvador">El Salvador</option>
                                                <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                <option value="Eritrea">Eritrea</option>
                                                <option value="Estonia">Estonia</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="Fiji>Fiji</option>
                                                <option value="Finland">Finland</option>
                                                <option value="France">France</option>
                                                <option value="Gabon">Gabon</option>
                                                <option value="Gambia">Gambia</option>
                                                <option value="Georgia">Georgia</option>
                                                <option value="Germany">Germany</option>
                                                <option value="Ghana">Ghana</option>
                                                <option value="Greece">Greece</option>
                                                <option value="Grenada">Grenada</option>
                                                <option value="Guatemala">Guatemala</option>
                                                <option value="Guinea">Guinea</option>
                                                <option value="Guinea-Bissau">Guinea-Bissau</option>
                                                <option value="">Guyana</option>
                                                <option value="">Haiti</option>
                                                <option value="">Honduras</option>
                                                <option value="">Hungary</option>
                                                <option value="">Iceland</option>
                                                <option value="">India</option>
                                                <option value="">Indonesia</option>
                                                <option value="">Iran</option>
                                                <option value="">Iraq</option>
                                                <option value="">Ireland {Republic}</option>
                                                <option value="">Israel</option>
                                                <option value="">Italy</option>
                                                <option value="">Ivory Coast</option>
                                                <option value="">Jamaica</option>
                                                <option value="">Japan</option>
                                                <option value="">Jordan</option>
                                                <option value="">Kazakhstan</option>
                                                <option value="">Kenya</option>
                                                <option value="">Kiribati</option>
                                                <option value="">Korea North</option>
                                                <option value="">Korea South</option>
                                                <option value="">Kosovo</option>
                                                <option value="">Kuwait</option>
                                                <option value="">Kyrgyzstan</option>
                                                <option value="">Laos</option>
                                                <option value="">Latvia</option>
                                                <option value="">Lebanon</option>
                                                <option value="">Lesotho</option>
                                                <option value="">Liberia</option>
                                                <option value="">Libya</option>
                                                <option value="">Liechtenstein</option>
                                                <option value="">Lithuania</option>
                                                <option value="">Luxembourg</option>
                                                <option value="">Macedonia</option>
                                                <option value="">Madagascar</option>
                                                <option value="">Malawi</option>
                                                <option value="">Malaysia</option>
                                                <option value="">Maldives</option>
                                                <option value="">Mali</option>
                                                <option value="">Malta</option>
                                                <option value="">Marshall Islands</option>
                                                <option value="">Mauritania</option>
                                                <option value="">Mauritius</option>
                                                <option value="">Mexico</option>
                                                <option value="">Micronesia</option>
                                                <option value="">Moldova</option>
                                                <option value="">Monaco</option>
                                                <option value="">Mongolia</option>
                                                <option value="">Montenegro</option>
                                                <option value="">Morocco</option>
                                                <option value="">Mozambique</option>
                                                <option value="">Myanmar, {Burma}</option>
                                                <option value="">Namibia</option>
                                                <option value="">Nauru</option>
                                                <option value="">Nepal</option>
                                                <option value="">Netherlands</option>
                                                <option value="">New Zealand</option>
                                                <option value="">Nicaragua</option>
                                                <option value="">Niger</option>
                                                <option value="">Nigeria</option>
                                                <option value="">Norway</option>
                                                <option value="">Oman</option>
                                                <option value="">Pakistan</option>
                                                <option value="">Palau</option>
                                                <option value="">Panama</option>
                                                <option value="">Papua New Guinea</option>
                                                <option value="">Paraguay</option>
                                                <option value="">Peru</option>
                                                <option value="">Philippines</option>
                                                <option value="">Poland</option>
                                                <option value="">Portugal</option>
                                                <option value="">Qatar</option>
                                                <option value="">Romania</option>
                                                <option value="">Russian Federation</option>
                                                <option value="">Rwanda</option>
                                                <option value="">St Kitts & Nevis</option>
                                                <option value="">St Lucia</option>
                                                <option value="">Saint Vincent & the Grenadines</option>
                                                <option value="">Samoa</option>
                                                <option value="">San Marino</option>
                                                <option value="">Sao Tome & Principe</option>
                                                <option value="">Saudi Arabia</option>
                                                <option value="">Senegal</option>
                                                <option value="">Serbia</option>
                                                <option value="">Seychelles</option>
                                                <option value="">Sierra Leone</option>
                                                <option value="">Singapore</option>
                                                <option value="">Slovakia</option>
                                                <option value="">Slovenia</option>
                                                <option value="">Solomon Islands</option>
                                                <option value="">Somalia</option>
                                                <option value="">South Africa</option>
                                                <option value="">South Sudan</option>
                                                <option value="">Spain</option>
                                                <option value="">Sri Lanka</option>
                                                <option value="">Sudan</option>
                                                <option value="">Suriname</option>
                                                <option value="">Swaziland</option>
                                                <option value="">Sweden</option>
                                                <option value="">Switzerland</option>
                                                <option value="">Syria</option>
                                                <option value="">Taiwan</option>
                                                <option value="">Tajikistan</option>
                                                <option value="">Tanzania</option>
                                                <option value="">Thailand</option>
                                                <option value="">Togo</option>
                                                <option value="">Tonga</option>
                                                <option value="">Trinidad & Tobago</option>
                                                <option value="">Tunisia</option>
                                                <option value="">Turkey</option>
                                                <option value="">Turkmenistan</option>
                                                <option value="">Tuvalu</option>
                                                <option value="">Uganda</option>
                                                <option value="">Ukraine</option>
                                                <option value="">United Arab Emirates</option>
                                                <option value="">United Kingdom</option>
                                                <option value="">United States</option>
                                                <option value="">Uruguay</option>
                                                <option value="">Uzbekistan</option>
                                                <option value="">Vanuatu</option>
                                                <option value="">Vatican City</option>
                                                <option value="">Venezuela</option>
                                                <option value="">Vietnam</option>
                                                <option value="">Yemen</option>
                                                <option value="">Zambia</option>
                                                <option value="">Zimbabwe</option>
                                        </select>
                                        <span class="form-highlight"></span>
                                        <span class="form-bar"></span>
                                        <label for="EventPlace" class="hasdrodown">Event Place</label>
                                        <span class="text-danger" id="EventPlace-div2"><strong id="form-errors-EventPlace2"></strong>
                                    </div>
                                </div>
                            </div><!--row end-->
                        </div>
                        <input type="hidden" name=EventId id="EventId" >
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-40">
                    <button type="button" id="btnIdSave" onclick="UpdateEvents()"  class="btn btn-raised btn-green pull-right">Save</button>
                    <button type="submit" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

@endsection