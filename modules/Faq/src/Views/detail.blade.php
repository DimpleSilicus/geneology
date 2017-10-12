@extends('Admin::layouts.app')

@section('content')
<div class="container">
    <div class="left">
        <h2>View Faq</h2>
    </div>
    <div class="row">
        <div class="col-md-12 col-md-offset-2">
            <div class="panel-default">
                <div class="panel-body">
                    <div class="form-group col-md-6 row">
                        <div class="col-sm-3">
                            <label for="question">Question:</label>
                        </div> {{ $faq->question }}
                    </div>
                    <div class = 'clearfix'></div>
                    <div class="form-group col-md-6 row">
                        <div class="col-sm-3">
                            <label for="answer">Answer:</label>
                        </div> {{ $faq->answer }}
                    </div>
                    <div class = 'clearfix'></div>
                    <div class="form-group col-md-6 row">
                        <div class="col-sm-3">
                            <label for="status">Status:</label>
                        </div> {{ $faq->status }}
                    </div>
                    <div class = 'clearfix'></div>

                    <div class="form-group col-md-6 row">
                        <div class="col-sm-3">
                            {{ link_to_route('faq.index', 'Back','',array('class' => 'btn btn-info')) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection