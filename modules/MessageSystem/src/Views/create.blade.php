@if(Request::is('admin/*'))
@php  $thm = 'Admin::layouts.app';
$url = '/admin'; @endphp
@else
@php  $thm = $theme . '.layouts.app';
$url = ''; @endphp
@endif
@extends($thm)
@section('content')
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.css">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2-bootstrap.css">
<title>Message System</title>
<section class="content-header {{$url == '/admin' ? '' : 'container' }}">
    <div class="center">
        <h2>Create Message</h2>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Folders
                    </h3>
                    <div class="box-tools">
                        <button data-widget="collapse" class="btn btn-box-tool">
                            <i class="fa fa-minus">
                            </i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">



                    <ul class="nav nav-pills nav-stacked">
                        <li class="cur active">
                            <a id="btn-composer" href="{{url($url.'/messages/create')}}">
                                <i class="fa fa-composer">
                                </i>
                                Compose
                            </a>
                        </li>
                        <li class="cur">
                            <a id="btn-inbox" href="{{url($url.'/messages/inbox')}}">
                                <i class="fa fa-inbox">
                                </i>
                                Inbox
                                <span id="inbox_id" class="label label-primary pull-right">
                                    {{$inboxCount}}
                                </span>
                            </a>
                        </li>
                        <li class="cur">
                            <a id="btn-sent"  href="{{url($url.'/messages/sent')}}">
                                <i class="fa fa-envelope-o">
                                </i>
                                Sent
                            </a>
                        </li>
                        <li class="cur">
                            <a id="btn-draft"  href="{{url($url.'/messages/drafts')}}">
                                <i class="fa fa-file-text-o">
                                </i>
                                Drafts
                                <span class="label label-default pull-right">
                                    {{$draftCount}}
                                </span>
                            </a>
                        </li>
                        <li class="cur">
                            <a id="btn-trash"  href="{{url($url.'/messages/trash')}}">
                                <i class="fa fa-trash-o">
                                </i>
                                Trash
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-md-9">
            <form action="{{url($url.'/messages/create')}}" id="createMessage" method="post">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Compose New Message</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group">
                            <select class="form-control" name="receiver[]" id="tagPicker" multiple="multiple" placeholder="To:">
                                @foreach($usersList as $user)
                                <option value="{{$user->id}}">{{$user->email}}</option>
                                @endforeach
                            </select>
                        </div>
                        <strong class="error">{{ $errors->first('receiver', 'Please add Recipient') }}</strong>
                        <div class="form-group">
                            <input placeholder="Subject:" name="subject" class="form-control subject" required="true">
                        </div>
                        <strong class="error">{{ $errors->first('subject', 'Please enter subject') }}</strong>
                        <div class="form-group">
                            <textarea style="height: 300px;" name="messagebody" class="form-control messagebody" id="compose-textarea" required="true"></textarea>
                        </div>
                        <strong class="error">{{ $errors->first('messagebody', 'Please enter message') }}</strong>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <div class="pull-right">
                            <input type="hidden" name="status" id="status" />
                            <button class="btn btn-default" type="button" data-status="draft"><i class="fa fa-pencil"></i>Draft</button>
                            <button class="btn btn-primary" type="submit" data-status="unread"><i class="fa fa-envelope-o"></i>Send</button>
                        </div>
                    </div>
                    <!-- /.box-footer -->
                </div>
                {!! csrf_field() !!}
            </form>
        </div>
    </div>
</section>
@endsection