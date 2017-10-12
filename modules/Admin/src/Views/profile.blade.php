@extends('Admin::layouts.app')
@section('content')
<script>
    var avatarPath = "{{url('/profile')}}/{{isset($userDetails['avatar']) ? $userDetails['avatar'] : 'profile.png'}}";
</script>
<section class="content-header">
    <h1>Profile</h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Profile</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-3 col-lg-3">
            <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
            <form class="text-center"  method="post" action="{{url('/profile/update/avatar')}}" enctype="multipart/form-data" target="upload_target">
                <div class="kv-avatar center-block" style="width:200px">
                    <div id="iframeText"></div>
                    <input id="avatar" name="avatar" type="file" class="file-loading">
                </div>
                <input type="hidden" name="_token" value="{{csrf_token() }}">
            </form>
            <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
        </div>
        <!----------------------------------------->
        <div class="col-md-5 col-lg-5">
            <table class="table table-user-information">
                <tbody>
                    <tr>
                        <td>Name:</td>
                        <td><a href="#" id="username" data-type="text" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter name" >{{isset($userDetails['name']) ? ucfirst($userDetails['name']) : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td><a href="#" id="email" data-type="text" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter email" >{{isset($userDetails['email']) ? $userDetails['email'] : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td><a href="#" id="gender" data-type="select" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter name" >{{isset($userDetails['gender']) ? ucfirst($userDetails['gender']) : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Date of Birth</td>
                        <td><a href="#" id="dateOfBirth" data-type="combodate" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-value="{{isset($userDetails['date_of_birth']) ? $userDetails['date_of_birth']: ''}}" data-title="Select date">{{isset($userDetails['date_of_birth']) ? $userDetails['date_of_birth']: ''}}</a></td>
                    </tr>
                    <tr>
                    <tr>
                        <td>Position</td>
                        <td><a href="#" id="position" data-type="text"  data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter position" >{{isset($userDetails['position']) ? ucfirst($userDetails['position']) : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Company</td>
                        <td><a href="#" id="company" data-type="text" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter company" >{{isset($userDetails['company']) ? ucfirst($userDetails['company']) : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td><a href="#" id="phone" data-type="tel" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter phone" >{{isset($userDetails['phone']) ? $userDetails['phone'] : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Mobile Number</td>
                        <td><a href="#" id="mobilePhone" data-type="tel" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter mobile phone" >{{isset($userDetails['mobile_phone']) ? $userDetails['mobile_phone'] : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><a href="#" id="address" data-type="textarea" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter address" >{{isset($userDetails['address']) ? $userDetails['address'] : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Facebook</td>
                        <td><a href="#" id="facebook" data-type="url" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter facebook" >{{isset($userDetails['facebook']) ? $userDetails['facebook'] : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Twitter</td>
                        <td><a href="#" id="twitter" data-type="url" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter twitter" >{{isset($userDetails['twitter']) ? $userDetails['twitter'] : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Google+</td>
                        <td><a href="#" id="google" data-type="url" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter google" >{{isset($userDetails['google']) ? $userDetails['google'] : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>About me</td>
                        <td><a href="#" id="aboutMe" data-type="textarea" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter about user" >{{isset($userDetails['about_me']) ? $userDetails['about_me'] : ''}}</a></td>
                    </tr>
                    <tr>
                        <td>Biography</td>
                        <td><a href="#" id="biography" data-type="textarea" data-pk="{{$id}}" data-url="{{url('admin/profile/update')}}" data-title="Enter user biography" >{{isset($userDetails['biography']) ? $userDetails['biography'] : ''}}</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!--------------------------------------------->
    </div>
</section>
@endsection