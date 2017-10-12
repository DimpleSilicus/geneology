@if (count($arrUsersGroup) > 0)
@foreach ($arrUsersGroup as $group)

<tr>
    <td>{{ $group["name"] }}</td>
    <td>@if(Auth::user()->id ==$group["user_id"] ) Owner @else Participant @endif</td>
    <td>
        <a href="#" class="table-icon"><i class="fa fa-envelope btnComposeGroupMail" grpId={{$group['id']}} grpName='{{ $group["name"] }}'></i></a>
        @if(Auth::user()->id ==$group["user_id"] )  <a href="#" class="table-icon"  ><i class="fa fa-pencil editGrp" grpId={{$group['id']}}></i></a> @endif
       
    </td>
</tr>

@endforeach
@else
<tr class="text-danger has-error" ><td colspan='4' align="center">No Groups Found.</td></tr>
@endif