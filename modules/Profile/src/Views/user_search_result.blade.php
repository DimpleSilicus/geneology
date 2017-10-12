@if (count($arrUsers) > 0)
@foreach ($arrUsers as $user)
<tr>
    <td>{{ $user["username"] }}</td>
    <td class="dropdown">
        <a href="#" class="table-icon dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus-circle"></i></a>
        <ul class="dropdown-menu dropdown-menu-left network-search-dropdown">
            <li><a href="#" class="addUser" uid={{ $user["id"] }}>CloseFamily</a></li>
            <li><a href="#" class="addUser" uid={{ $user["id"] }}>Relative</a></li>
            <li><a href="#" class="addUser" uid={{ $user["id"] }}>ResearchConnection</a></li>
        </ul>
    </td>
 </tr>
@endforeach
@else
<tr class="text-danger has-error"><td colspan='2' align="center">No users found with this name.</td></tr>
@endif