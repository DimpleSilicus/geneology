@extends('Admin::layouts.app')

@section('content')
<div class="container">
    <div class="left">
        <h2>Add Faq</h2>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel-default">
                <div class="panel-body">
                    {{ Form::open(array('route' => 'faq.store')) }}
                    <div class="form-group col-md-6 row {{ $errors->has('question') ? ' has-error' : '' }}">
                        {{ Form::label('question', 'Question:') }}
                        {{ Form::text('question', null, array('class' => 'form-control','required'=>'required'))}}
                        @if ($errors->has('question'))
                        <span class="help-block"><strong>{{ $errors->first('question') }}</strong></span>
                        @endif
                    </div>
                    <div class = 'clearfix'></div>
                    <div class="form-group col-md-6 row {{ $errors->has('answer') ? ' has-error' : '' }}">
                        {{ Form::label('answer', 'Answer:') }}
                        {{ Form::text('answer', null, array('class' => 'form-control','required'=>'required'))}}
                        @if ($errors->has('question'))
                        <span class="help-block"><strong>{{ $errors->first('answer') }}</strong></span>
                        @endif
                    </div>
                    <div class = 'clearfix'></div>
                    <div class="form-group col-md-6 row {{ $errors->has('status') ? ' has-error' : '' }}">
                        {{ Form::label('status', 'Status:') }}
                        {{ Form::checkbox('status', 1, true) }}

                        @if ($errors->has('question'))
                        <span class="help-block"><strong>{{ $errors->first('status') }}</strong></span>
                        @endif
                    </div>
                    <div class = 'clearfix'></div>
                    <div class="form-group">
                        {{ Form::submit('Submit', array('class' => 'btn btn-info')) }}
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection