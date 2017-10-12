@if (count($pageList) > 0)
@foreach($pageList as $pageList_info)
<tr>
    <td>{{$pageList_info['name']}}</td>
    <td>{{$pageList_info['meta_title']}}</td>
    <td>{{$pageList_info['slug']}}</td>
    <td><a href="javascript:void(0)" title="Click here to {{$pageList_info['publish'] == '1' ? 'Unpublish' : 'Publish'}}" id="row_{{$pageList_info['id']}}" onclick="updatePageStatus({{$pageList_info['id']}},{{$pageList_info['publish']}})">{{$pageList_info['publish'] == '1' ? 'Published' : 'Unpublished'}}</a></td>
    @if ($pageList_info['publish'] == '1')
    <th><a href="{{ URL::to('/') }}/{{$pageList_info['slug']}}" class="btn btn-info" target="_blank"><span class="glyphicon glyphicon-zoom-in"></span> Preview</a></th>
    @else
    <th>Please Publish This Page For Preview</th>
    @endif
    <td><a href="{{ URL::to('/') }}/admin/pages/edit/{{$pageList_info['id']}}" class="btn btn-info">Edit</a></td>
    <td><a onclick="delPage({{$pageList_info['id']}})" href="javascript:void(0)" class="delete btn btn-danger">Delete</a></td>
</tr>
@endforeach
@else
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td style="text-align: center;">No pages found</td>
    <td></td>
    <td></td>
    <td></td>
</tr>
@endif
