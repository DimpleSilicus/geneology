@if (count($arrUsersMessages) > 0)
@foreach ($arrUsersMessages as $message)

<tr>
    <td>{{$message['description']}}</td>
    <td>
        <a href="#" class="table-icon">View</a>
    </td>
</tr>

@endforeach
@else
<tr class="text-danger has-error"><td colspan='2' align="center">No Messages found.</td></tr>
@endif