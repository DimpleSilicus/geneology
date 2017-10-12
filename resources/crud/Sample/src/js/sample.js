$(document).ready(function(){  
var url = "/@LSample@";
$(document).on('click','.deleteRecord',function (event) {           
    var currentTarget = event.target;  
    var thisObj = this; 
    event.preventDefault();
    var recordId = $(this).attr('value');   
    bootbox.confirm({
                message: 'Do you really want to delete this record?',
                buttons: {
                    'confirm': {
                        label: 'Yes',
                    },
                    'cancel': {
                        label: 'No',
                    }                    
                },
                callback: function (result) {                    
                    if (result)
                    {                          
                        var id = $(this).attr('value');                         
                        $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                }
                            })
                        $.ajax({
                            type: "DELETE",
                            url: url + '/' + recordId,
                            success: function (data) {                                                                
                                $('#recordGrid').DataTable().ajax.reload(); //to refresh datatables
                                $('div#message').html('<div class="alert alert-success"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a><strong>Success!</strong> Successfully deleted');
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                }
            });
});
    //display modal form for record editing
    $(document).on('click','.open-modal',function(){
        var val = $(this).attr('value');
        if('undefined' != typeof(val) && '' != val)
        {
            $.get(url+"/"+val+"/edit", function (data) {
                //success data                
                @VALUE_DATA@
                $('#id').val(val);
                $('#btn-save').val("update");
                $('#myModal').modal('show');
            }) 
        }
        else
        {            
                $('#btn-save').val("add");
                $('#myModal').modal('show');
            
        }
    });
    
    //display modal form for creating new task
    $(document).on('click','#btnAdd',function(){
        console.log('on click');
        $('#btn-save').val("add");
        $('#frm@USample@').trigger("reset"); 
        $('#myModal').modal('show');
    });
    //Display detail view in popup
    $(document).on('click','#btnView',function(){ 
        var id = $(this).attr('value');
        $.ajax({
                type: 'GET',
                url: url+'/show/'+id,
                data: {id: id},
                dataType: 'json',
                success: function (data) {                    
                    if(data.errors)
                    {                        
                        $('div#message').html('<div class="alert alert-error"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a><strong>Error!</strong> While retrieveing record');
                    }
                    else
                    {  
                         @VIEW_DATA@
                        $('#modalDetail').modal('show');
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#modalDetail').modal('hide');
                }
            });
        
    });
    //create new task / update existing task
    $("#btn-save").click(function (e) {
        if($('form#frm@USample@').valid()){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            e.preventDefault(); 
            var formData = {
                @FORM_DATA@
            }
            //used to determine the http verb to use [add=POST], [update=PUT]
            var state = $('#btn-save').val();            
            var type = "POST"; //for creating new resource
            var id = $('#id').val();;
            var my_url = url;
            var msg = 'added';
            if (state == "update"){
                type = "PUT"; //for updating existing resource
                my_url += '/' + id;
                msg = 'updated';
            }else if (state == "add"){                
                my_url += '/create';
            }            
            $.ajax({
                type: type,
                url: my_url,
                data: formData,
                dataType: 'json',
                success: function (data) {                    
                    if(data.errors)
                    {                        
                        $.each(data.errors, function(k,v) {
                            $(document).find('#'+k).after('<span class="help-block">'+v+'<strong></strong></span>');
                            $(document).find('#'+k).parent('div').addClass('has-error');
                        });
                    }
                    else
                    {                        
                        var record = '<tr id="@LSample@' + data.id + '">';
                        record += @TR_DATA@;                        
                        record += '<td><a class="inline-link glyphicon glyphicon-eye-open" id="btnView" href="#" value="' + data.id + '" title="View"></a></td>';
                        record += '<td><a class="inline-link btn-edit glyphicon glyphicon-pencil open-modal" value="' + data.id + '" title="Edit"></a></td>';
                        record += '<td><a class="inline-link deleteRecord glyphicon glyphicon-trash" href="#" value="' + data.id + '" title="Delete"></a></td></tr>';

                        if (state == "add"){ //if user added a new record
                            {
                            $('#recordGrid').DataTable().ajax.reload(); //to refresh datatables
                        }
                        }else{ //if user updated an existing record

                            $('#recordGrid').DataTable().ajax.reload(); //to refresh datatables
                        }                      
                        $('#frm@USample@').trigger("reset");                        
                        $('#myModal').modal('hide');                        
                        $('div#message').html('<div class="alert alert-success"><a aria-label="close" data-dismiss="alert" class="close" href="#">×</a><strong>Success!</strong> Successfully '+ msg);
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });    
    var recordsColumn = [
                            @RECORDS_COLUMN@
                            {"data": "view", "bSortable": false},
                            {"data": "edit", "bSortable": false},
                            {"data": "delete", "bSortable": false}
                        ];
    $('#recordGrid').DataTable({
        responsive: true,
        "autoWidth": false,
        "processing": true,
        "serverSide": true,
        "stateSave": true,
        "ajax": url+'/getList',
        "columns": recordsColumn,      
        "columnDefs": [{
                "targets": [@COLUMN_VIEW@, @COLUMN_EDIT@, @COLUMN_DELETE@],    // Column which need to update. Index start from zero
                "render": function (data, type, row, meta) {
                    
                    if (type === 'display') {                                                
                        if (meta.col == @COLUMN_VIEW@) {                            
                            data = '<a class="inline-link glyphicon glyphicon-eye-open" id="btnView" href="#" value="'+data+'" title="View"></a>'
                        }
                        if (meta.col == @COLUMN_EDIT@) {                            
                            data = '<a class="inline-link btn-edit glyphicon glyphicon-pencil open-modal" href="#" value="'+data+'" title="Edit"></a>';                            
                        }
                        if (meta.col == @COLUMN_DELETE@) {                            
                            data = '<a class="inline-link deleteRecord glyphicon glyphicon-trash" href="#" value="'+data+'" title="Delete"></a>';
                        }                         
                    }                                      
                    return data;
                }
            }]
    }); 
});
