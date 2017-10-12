@extends('Admin::layouts.app')
@section('content')
<title>User's Activity</title>
<section class="content-header">
    <h1>User's Activity Logs</h1><br/>
    <form action="/admin/activity-log" method='POST'>
        <div class="dataTables_wrapper form-inline dt-bootstrap">

            <label>Log Duration
                <select id="logduration" class="form-control input-sm" name='logduration'>
                    <option {{($duration == "0") ? "selected" : ''}}  value="0">Today's</option>
                    <option {{($duration == "7") ? "selected" : ''}}  value="7">1 Week</option>

                    <option {{($duration == "30") ? "selected" : ''}} value="30">1 Month</option>
                    <option {{($duration == "60") ? "selected" : ''}} value="60">2 Month</option>
                    <option {{($duration == "90") ? "selected" : ''}} value="90">3 Month</option>
                </select>
            </label>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
    <table id="records" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>User Id</th>
                <th>Email Id</th>
                <th>Controller</th>
                <th>Module</th>
                <th>Description</th>
                <th>Action</th>
                <th>Ip Address</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>User Id</th>
                <th>Email Id</th>
                <th>Controller</th>
                <th>Module</th>
                <th>Description</th>
                <th>Action</th>
                <th>Ip Address</th>
                <th>Created At</th>
            </tr>
        </tfoot>
    </table>
</section>
@endsection