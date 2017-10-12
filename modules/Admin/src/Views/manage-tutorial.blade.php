@extends($theme.'.layouts.outer')
@section('content')


  <section class="background-maroon heading-section">
        <div class="container">
            <h2 class="heading">Manage Tutorials</h2>
        </div>
    </section>
    <section class="min-height-450">
        <div class="container">
		
            <div class="row">
            <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                          @if(Session::has($msg))
                          <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                          @endif
                        @endforeach
					</div>
                <div class="col-sm-6">
                
                	
                    <div class="form-group col-md-6 col-sm-12 padding-LR-0">
                        <div class="input-group width-100Per" >
                            <input type="text" class="form-control width-90Per" id="SearchName" name="SearchName" />
                            <span class="form-highlight"></span>
                            <span class="form-bar"></span>
                            <label class="float-label" for="SearchName">Search</label>
                            <label class="input-group-addon modal-datepicker-ico border-bttm" for="SearchName">
                                <span id="idSearch" class="glyphicon glyphicon glyphicon-search"></span>
                            </label>
                            <span class="text-danger" id="searchname-div"><strong id="form-errors-searchname"></strong>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 text-right margin-T-40">
                    
                    <button type="button" class="btn btn-green margin-B-20" data-toggle="modal" data-target="#AddTuots">Add TUTORIALS</button>
                </div>
            </div> <!--row end-->
            <div class="row" >
                <div class="col-sm-12" id="searchResultDiv">
                    <div class="table-responsive">
                        <table class="table" id="searchResultTable">
                            <thead>
                                <tr style="background: #dce0e4;">
                                    <th>Question</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div><!--container end-->
    </section>
	
	
	
	 <div id="AddTuots" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Tutorial</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="Question" name="Question" required>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Que">Question</label>
                                <span class="text-danger" id="Question-div"><strong id="form-errors-Question"></strong>
                            </div>
                            <div class="form-group">
                                <textarea type="text" class="form-control" id="Answer" name="Answer" required></textarea>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Ans">Answer</label>
                                <span class="text-danger" id="Answer-div"><strong id="form-errors-Answer"></strong>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-20">
                    <button type="button" onclick="AddNewTutorial()" class="btn btn-raised btn-green pull-right">Submit</button>
                    <button type="button" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    
    
     <div id="EditTutorial" class="modal fade" role="dialog">
        <div class="modal-dialog medium-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Tutorial</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="text" class="form-control" id="Question1" name="Question1" required>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Que">Question</label>
                                <span class="text-danger" id="Question-div1"><strong id="form-errors-Question1"></strong>
                            </div>
                            <div class="form-group">
                                <textarea type="text" class="form-control" id="Answer1" name="Answer1" required></textarea>
                                <span class="form-highlight"></span>
                                <span class="form-bar"></span>
                                <label class="float-label" for="Ans">Answer</label>
                                <span class="text-danger" id="Answer-div1"><strong id="form-errors-Answer1"></strong>
                            </div>
                             <input type="hidden" id="TutorialId" name="TutorialId" >
                        </div>
                    </form>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer margin-T-20">
                    <button type="button" onclick="UpdateTutorial()" class="btn btn-raised btn-green pull-right">Save</button>
                    <button type="button" class="btn btn-raised btn-default pull-right margin-R-20" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    
    
   


@endsection