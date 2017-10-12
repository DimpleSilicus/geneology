@extends('Admin::layouts.blank')
@section('content')
<section>
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 " align="center">
                        <img alt="{{ isset($result['name']) ? $result['name'] : 'N/A'}}" src="{{$url}}/profile/{{ isset($result['avatar']) ? $result['avatar'] : 'avatar.png'}}" class="img-circle img-responsive">
                    </div>
                    <div class=" col-md-9 col-lg-9 ">
                        <table class="table table-user-information">
                            <tbody>
                                <tr>
                                    <td>Name:</td>
                                    <td>{{ isset($result['name']) ? ucfirst($result['name']) : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td><a href="{{ isset($result['email']) ? 'mailto:' . $result['email'] : '#'}}">{{ isset($result['email']) ? $result['email'] : 'N/A'}}</a></td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>{{ isset($result['gender']) ? ucfirst($result['gender']) : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Date of Birth</td>
                                    <td>{{ isset($result['date_of_birth']) ? $result['date_of_birth'] : 'N/A'}}</td>
                                </tr>
                                <tr>
                                <tr>
                                    <td>Position</td>
                                    <td>{{ isset($result['position']) ? ucfirst($result['position']) : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Company</td>
                                    <td>{{ isset($result['company']) ? ucfirst($result['company']) : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td>{{ isset($result['phone']) ? $result['phone'] : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Mobile Number</td>
                                    <td>{{ isset($result['mobile_phone']) ? $result['mobile_phone'] : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>{{ isset($result['address']) ? $result['address'] : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Facebook</td>
                                    <td><a href='{{ isset($result['facebook']) ? $result['facebook'] : '#'}}' target="_blank">Click here</a></td>
                                </tr>
                                <tr>
                                    <td>Twitter</td>
                                    <td><a href='{{ isset($result['twitter']) ? $result['twitter'] : '#'}}' target="_blank">Click here</a></td>
                                </tr>
                                <tr>
                                    <td>Google+</td>
                                    <td><a href='{{ isset($result['google']) ? $result['google'] : '#'}}' target="_blank">Click here</a></td>
                                </tr>
                                <tr>
                                    <td>Registered At</td>
                                    <td>{{ isset($result['created_at']) ? $result['created_at'] : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ isset($result['status']) ? $result['status'] == 1 ? 'Active' : 'Block' : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>About me</td>
                                    <td>{{ isset($result['about_me']) ? $result['about_me'] : 'N/A'}}</td>
                                </tr>
                                <tr>
                                    <td>Biography</td>
                                    <td>{{ isset($result['biography']) ? $result['biography'] : 'N/A'}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection