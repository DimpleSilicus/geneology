@if (count($arrConnectRequests) > 0)
@foreach ($arrConnectRequests as $request)

<tr>
    <td>{{$request['username']}}</td>
    <td>{{$request['relation']}}</td>
    <td>
        <a href="#" class="table-icon approveReq" reqId={{$request['id']}}><i class="fa fa-check"></i></a>
        <a href="#" class="table-icon rejectReq" reqId={{$request['id']}}><i class="fa fa-close"></i></a>
    </td>
</tr>

@endforeach
@else
<tr class="text-danger has-error"><td colspan='2' align="center">No Requests Found.</td></tr>
@endif