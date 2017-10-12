@if(Request::is('admin/*'))
@php $url = '/admin'; @endphp
@else
@php $url = ''; @endphp
@endif
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.css">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2-bootstrap.css">
<form files="true" id="createMessage">
    <table class="table  table-striped">
        <tbody>

            <tr>
                <td>
                    <select class="form-control" name="receiver[]" id="receiver" multiple="multiple" placeholder="To:" folderName="{{$folderName}}">
                        @foreach($usersList as $user)
                        <option value="{{$user->id}}">{{$user->email}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <input value="FW: {{$messageDetails->subject}}" name="subject" id="subject" class="form-control">
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <textarea name="messagebody" id="messagebody" rows="6" required="true" placeholder="Message" class="form-control">{{$messageDetails->body}}</textarea>
                </td>
            </tr>
            <tr>
                <td colspan="4">
                    <button class="btn btn-primary" type="button" id="forward" data-status="unread"><i class="fa fa-envelope-o"></i>Send</button>
                </td>
            </tr>
        </tbody>
    </table>
    {!! csrf_field() !!}
</form>
<script>
    $.getScript('http://cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.min.js', function () {
        $("#receiver").select2({
            closeOnSelect: false
        });
    });
    $('#forward').click(function () {
        $('.error').remove();
        $.ajax({
            type: "POST",
            url: "{{$url}}" + "/messages/create",
            dataType: "json",
            data: {
                receiver: $("#receiver").val(),
                subject: $("#subject").val(),
                messagebody: $("#messagebody").val(),
                _token: $('[name="_token"]').val()
            },
            success: function (response) {
                var folderName = $('#receiver').attr('folderName');
                window.location = "{{$url}}" + '/messages/' + folderName;
            },
            error: function (data) {
                var errors = data.responseJSON;
                $.each(errors, function (i, val) {
                    $('#' + i).closest('td').append('<label class="error">' + val + '</label>');
                });
            }
        });
    });
</script>