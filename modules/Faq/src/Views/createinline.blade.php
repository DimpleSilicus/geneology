<div class="col-md-12">
    <div class="panel-default">
        <div class="panel-body">
            <div id="formDiv" style="display: none;padding: 10px; border: 1px solid rgb(221, 221, 221);">
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
                    <input type="button" value="Cancel" id="cancel-form" class="btn" onclick="window.location = '{{url('admin/faqs')}}';"/>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>