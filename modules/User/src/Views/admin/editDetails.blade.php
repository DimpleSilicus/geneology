@extends('Admin::layouts.blank')
@section('content')
<section>
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-body">
                <div class="row">
                    <div class=" col-md-9 col-lg-9 ">
                        <table class="table table-user-information">
                            <tbody>
                                <tr>
                                    <td>Name:</td>
                                    <td><a href="#" id="username" data-type="text" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter name" >{{isset($result['name']) ? ucfirst($result['name']) : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td><a href="#" id="email" data-type="text" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter email" >{{isset($result['email']) ? $result['email'] : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td><a href="#" id="gender" data-type="select" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter name" >{{isset($result['gender']) ? ucfirst($result['gender']) : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td><a href="#" id="dateOfBirth" data-type="combodate" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-value="{{isset($result['date_of_birth']) ? $result['date_of_birth']: ''}}" data-title="Select date">{{isset($result['date_of_birth']) ? $result['date_of_birth']: ''}}</a></td>
                                </tr>
                                <tr>
                                <tr>
                                    <td>Position</td>
                                    <td><a href="#" id="position" data-type="text"  data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter position" >{{isset($result['position']) ? ucfirst($result['position']) : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Company</td>
                                    <td><a href="#" id="company" data-type="text" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter company" >{{isset($result['company']) ? ucfirst($result['company']) : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td><a href="#" id="phone" data-type="tel" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter phone" >{{isset($result['phone']) ? $result['phone'] : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Mobile Number</td>
                                    <td><a href="#" id="mobilePhone" data-type="tel" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter mobile phone" >{{isset($result['mobile_phone']) ? $result['mobile_phone'] : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td><a href="#" id="address" data-type="textarea" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter address" >{{isset($result['address']) ? $result['address'] : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Facebook</td>
                                    <td><a href="#" id="facebook" data-type="url" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter facebook" >{{isset($result['facebook']) ? $result['facebook'] : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Twitter</td>
                                    <td><a href="#" id="twitter" data-type="url" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter twitter" >{{isset($result['twitter']) ? $result['twitter'] : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Google+</td>
                                    <td><a href="#" id="google" data-type="url" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter google" >{{isset($result['google']) ? $result['google'] : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td><a href="#" id="status" data-type="select" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter name" >{{$result['status'] ==1 ? 'Active' : 'Block'}}</a></td>
                                </tr>
                                <tr>
                                    <td>About me</td>
                                    <td><a href="#" id="aboutMe" data-type="textarea" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter about user" >{{isset($result['about_me']) ? $result['about_me'] : ''}}</a></td>
                                </tr>
                                <tr>
                                    <td>Biography</td>
                                    <td><a href="#" id="biography" data-type="textarea" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter user biography" >{{isset($result['biography']) ? $result['biography'] : ''}}</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {

        $('button.close').on('click', function () {
            $.fn.updateData();
            return true;
        });

        $('iframe#upload_target').load(function () {
            var bn = $('iframe#upload_target').contents().find('#filesMessage').html();
            $('#iframeText').html(bn);
        });

        $.fn.editable.defaults.mode = 'inline';

        $.fn.editable.defaults.params = function (params) {
            params._token = $("meta[name=csrf-token]").attr("content");
            return params;
        };

        $('#username').editable({
            validate: function (value) {
                if ($.trim(value) == '')
                    return 'Value is required.';
            }
        });

        $('#email').editable({
            validate: function (value) {
                if ($.trim(value) == '')
                    return 'Value is required.';
            }
        });

        $('#gender').editable({
            source: [
                {value: 'male', text: 'Male'},
                {value: 'female', text: 'Female'}
            ]
        });

        $('#status').editable({
            source: [
                {value: '0', text: 'Block'},
                {value: '1', text: 'Active'}
            ]
        });

        $('#dateOfBirth').editable({
            format: 'YYYY-MM-DD',
            viewformat: 'DD/MM/YYYY',
            template: 'D/MMMM/YYYY',
            combodate: {
                minYear: 1915,
                maxYear: 2016,
                minuteStep: 1
            }
        });

        $('#position').editable();
        $('#company').editable();
        $('#phone').editable();
        $('#mobilePhone').editable();
        $('#address').editable();
        $('#facebook').editable();
        $('#twitter').editable();
        $('#google').editable();
        $('#biography').editable();
        $('#aboutMe').editable();

    });
</script>
@endsection