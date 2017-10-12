@extends('Admin::layouts.app')
@section('content')
<style>
    table.dataTable.nowrap th, table.dataTable.nowrap td {
        white-space: normal;
    }
</style>
<section class="content-header">
    <h1>Faq</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Faq</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="item  col-xs-4 col-lg-4">
            <h3><a id="showContentDiv" href="{{url('/admin/faq/create/')}}" class="btn btn-success"><i class="fa fa-plus"></i> Create Faq</a></h3>
        </div>
        <div class="item  col-md-12">
            @include('Faq::createinline')
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-default">
                <div class="panel-body">
                    <table id="records" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <!-- <th>View</th> -->
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th>Edit</th>
                                <!-- <th>View</th> -->
                                <th>Delete</th>
                            </tr>
                        </tfoot>
                        @if ($faq->count()>100)
                        <tbody >
                            @foreach ($faq as $item)
                            <tr>
                                <td>{{$item->question}}</td>
                                <td>{{ $item->answer}}</td>
                                @if($item->status)
                                <td>{{ Form::button('Published', array('class' => 'btn btn-info')) }}</td>
                                @else
                                <td>{{ Form::button('Unpublished', array('class' => 'btn btn-danger')) }}</td>
                                @endif
                                <td>{{ link_to_route('faq.edit', 'Edit', array($item->id), array('class' => 'btn btn-info')) }}</td>
                                <td>{{ link_to_route('faq.show', 'View', array($item->id), array('class' => 'btn btn-info'))}}</td>
                                <td>
                                    {{ Form::open(array('method' => 'DELETE', 'route' => array('faq.destroy', $item->id))) }}
                                    {{ Form::submit('Delete', array('class' => 'btn btn-danger deleteRecord')) }}
                                    {{ Form::close() }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @else
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
