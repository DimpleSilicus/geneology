@extends('Admin::layouts.app')

@section('content')
<div class="container">
    <div class="left">
        <h2>Edit Faq</h2>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel-default">
                <div class="panel-body">
                    {{ Form::model($faq, array('method' => 'PUT', 'route' => array('faq.update', $faq->id))) }}

                    <div  class="form-group col-md-6 row {{ $errors->has('question') ? ' has-error' : '' }}">
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
                        @if ($errors->has('answer'))
                        <span class="help-block"><strong>{{ $errors->first('answer') }}</strong></span>
                        @endif
                    </div>
                    <div class = 'clearfix'></div>
                    <div class="form-group col-md-6 row {{ $errors->has('status') ? ' has-error' : '' }}">
                        {{ Form::label('status', 'Status:') }}
                        @if(  $faq->status == 0 )
                        {{ Form::checkbox('status', 0, false) }}
                        @else
                        {{ Form::checkbox('status', 1, true) }}
                        @endif
                        @if ($errors->has('status'))
                        <span class="help-block"><strong>{{ $errors->first('status') }}</strong></span>
                        @endif
                    </div>
                    <div class = 'clearfix'></div>


                    <div class="form-group col-md-8 row">
                        {{ Form::submit('Update', array('class' => 'btn btn-info')) }}
                        <input type="button" value="Cancel" id="cancel-form" class="btn" onclick="window.location = '{{url('admin/faqs')}}';"/>
                    </div>

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection