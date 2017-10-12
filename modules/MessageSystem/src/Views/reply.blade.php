@if(Request::is('admin/*'))
@php $url = '/admin'; @endphp
@else
@php $url = ''; @endphp
@endif
<form files="true" id="createMessage">
    <table class="table  table-striped">
        <tbody>

            <tr>
                <td colspan="4">
                    <input type="hidden" value="{{$messageDetails->sender}}" name="receiver[]" id="receiver" folderName="{{$folderName}}">
                </td>
            </tr>
            <tr>
                <td>
                    <input type="text" value="RE: {{$messageDetails->subject}}" required="true" name="subject" id="subject" class="form-control">
                </td>

            </tr>
            <tr>
                <td colspan="4">
                    <textarea name="messagebody" id="messagebody" rows="6" required="true" placeholder="Message" class="form-control"></textarea>
                </td>

            </tr>
            <tr>
                <td colspan="4">
                    <button class="btn btn-primary" type="button" id="reply" data-status="unread"><i class="fa fa-envelope-o"></i>Send</button>
                </td>
            </tr>
        </tbody>
    </table>
    {!! csrf_field() !!}
</form>
<script>
    $('#reply').click(function () {
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