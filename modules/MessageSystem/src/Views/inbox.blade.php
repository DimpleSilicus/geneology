@if(Request::is('admin/*'))
@php  $thm = 'Admin::layouts.app';
$url = '/admin'; @endphp
@else
@php  $thm = $theme . '.layouts.app';
$url = ''; @endphp
@endif
@extends($thm)
@section('content')
<title>Message System</title>
<section class="content-header {{$url == '/admin' ? '' : 'container' }}">
    <div class="center">
        <h2>Messages</h2>
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
                        <li class="cur">
                            <a id="btn-composer" href="{{url($url.'/messages/create')}}">
                                Compose
                            </a>
                        </li>
                        <li class="cur active">
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
                                <!-- <span class="label label-success pull-right" id="sent_id">
                                    0
                                </span> -->
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
            <div id="entry-message"><div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            {{$folderName}}
                        </h3>
                        <div class="pull-right">
                            <form id="search" action="{{url($url.'/messages/inbox')}}" method="post">
                                <div class="has-feedback">
                                    <input type="text" id="txt-search" name="search" placeholder="Search Message" class="form-control input-sm">
                                </div>
                                {!! csrf_field() !!}
                            </form>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <div class="btn-group">
                                <button class="btn btn-default btn-sm checkbox-toggle checkAll" id="checkAll">
                                    <i class="fa fa-square-o">
                                    </i>
                                </button>
                                <button title="Move to Trash" class="btn btn-default btn-sm btn-trashed" onclick="delInbox()">
                                    <i class="fa fa-trash-o">
                                    </i>
                                </button>
                                <button title="Refresh" class="btn btn-default btn-sm btn-refresh">
                                    <i class="fa fa-refresh">
                                    </i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                        <div style="min-height: 360px;" class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody id="search-results">
                                    @foreach($messageList as $message)
                                    <tr style="background-color: #fff" data-status="" class="check-read" id="{{$message->message_id}}">
                                        <td>
                                            <input type="checkbox" id="{{$message->message_id}}" class="checkbox" name="listMessageID">
                                        </td>
                                        <td class="mailbox-subject single"  onclick="openMessageInbox({{$message->message_id}})">
                                            <b>
                                                {{$message->subject}}
                                            </b>
                                        </td>
                                        <td class="mailbox-date single"  onclick="openMessageInbox({{$message->message_id}})">
                                            <time datetime="{{$message->created_at}}" class="timeago">{{$message->created_at}}</time>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">
                        <div class="mailbox-controls">

                            <!-- Check all button -->
                            <div class="btn-group">
                                <button class="btn btn-default btn-sm checkbox-toggle checkAll" id="checkAll">
                                    <i class="fa fa-square-o">
                                    </i>
                                </button>
                                <button title="Move to Trash" class="btn btn-default btn-sm btn-trashed" onclick="delInbox()" >
                                    <i class ="fa fa-trash-o">
                                    </i>
                                </button>
                                <button title="Refresh" class="btn btn-default btn-sm btn-refresh">
                                    <i class="fa fa-refresh">
                                    </i>
                                </button>
                            </div>
                            <!-- /.btn-group -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection