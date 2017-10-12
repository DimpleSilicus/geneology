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
                <div class="box-body no-padding ">



                    <ul class="nav nav-pills nav-stacked">
                        <li class="cur">
                            <a id="btn-composer" href="{{url($url.'/messages/create')}}">
                                Compose
                            </a>
                        </li>
                        <li class="cur {{$folderName == 'inbox' ? 'active' : '' }}">
                            <a id="btn-inbox" href="{{url($url.'/messages/inbox')}}">
                                <i class="fa fa-inbox">
                                </i>
                                Inbox
                                <span id="inbox_id" class="label label-primary pull-right">
                                    {{$inboxCount}}
                                </span>
                            </a>
                        </li>
                        <li class="cur  {{$folderName == 'sent' ? 'active' : '' }}">
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
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{$messageDetails->subject}}<span class="lbl">{{$folderName}}</span>
                </h3>
            </div>

            <div class="box-body no-padding">
                <div class="mailbox-controls">

                    <div class="btn-group">
                        <button foldername="{{$folderName}}" title="Back" class="btn btn-default btn-sm btn-back">
                            <i class="fa fa-long-arrow-left">
                            </i>
                        </button>
                        <button title="Delete" id="{{$messageDetails->id}}"  foldername="{{$folderName}}" class="btn btn-default btn-sm btn-delete"  onclick="delShowTrash({{$messageDetails->id}})">
                            <i class="fa fa-trash-o">
                            </i>
                        </button>
                        <button title="Restore" id="{{$messageDetails->id}}" foldername="{{$folderName}}" class="btn btn-default btn-sm btn-retweet" onclick="restoreMessage({{$messageDetails->id}})">
                            <i class="glyphicon glyphicon-retweet">
                            </i>
                        </button>
                        <!-- /.btn-group -->
                        <button id="{{$messageDetails->id}}" title="Refresh" class="btn btn-default btn-sm btn-refresh">
                            <i class="fa fa-refresh">
                            </i>
                        </button>
                    </div>

                </div>
                <div style="min-height: 360px;" class="table-responsive mailbox-messages">
                    <table class="table  table-striped">
                        <tbody id="search-results">
                            <tr>
                                <td colspan="4">
                                    From: {{$senderId[0]->email}}<br>
                                    Date: {{$messageDetails->created_at}}<br>
                                    Subject: {{$messageDetails->subject}}<br>
                                    To:
                                    @foreach($receiversId as $receiver)
                                    {{$receiver->email}},
                                    @endforeach
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    {!! nl2br($messageDetails->body) !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- /.table -->
                </div>
                <!-- /.mail-box-messages -->
            </div>
            <div id="show-message" class="box-footer no-padding">
                <div class="mailbox-controls">
                    <div class="btn-group">
                        <button id="{{$folderName}}" foldername="{{$folderName}}" title="Back" class="btn btn-default btn-sm btn-back">
                            <i class="fa fa-long-arrow-left">
                            </i>
                        </button>
                        <button title="Delete" id="{{$messageDetails->id}}" foldername="{{$folderName}}" class="btn btn-default btn-sm btn-delete"  onclick="delShowTrash({{$messageDetails->id}})">
                            <i class="fa fa-trash-o">
                            </i>
                        </button>
                        <button title="Restore" id="{{$messageDetails->id}}" foldername="{{$folderName}}" class="btn btn-default btn-sm btn-retweet"  onclick="restoreMessage({{$messageDetails->id}})">
                            <i class="glyphicon glyphicon-retweet">
                            </i>
                        </button>
                        <button id="{{$messageDetails->id}}" title="Refresh" foldername="{{$folderName}}" class="btn btn-default btn-sm btn-refresh">
                            <i class="fa fa-refresh">
                            </i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
