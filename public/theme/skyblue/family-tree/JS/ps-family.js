/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function ($) {
    var rootDiv = '';
    var parentDiv = '.treeWrapper';
    var treeGround = null;
    var newMemberForm = '';
    var memberName = '';
    var memberGender = '';
    var memberAge = '';
    var memberPic = '';
    var memberRelation = '';
    var familyTree = new Array();
    var memberId = 0;
    var selectedMember = null;// refrence to selected member
    var self = true;
    var memberSpace = 92;
    var memberWidth = 115;
    var memberHeight = 107;
    var memberDetails = null;
    var options_menu = null;
    var object = new Object();
    var rut = null;
    var parent = null;

    $.fn.pk_family = function (options) {
        if (rootDiv == null) {
            // error message in console
            jQuery.error('wrong id given');
            return;
        }
        rootDiv = this;
        init();
    }

    // function to create tree from json data
    $.fn.pk_family_create = function (options) {
        if (rootDiv == null) {
            // error message in console
            jQuery.error('wrong id given');
            return;
        }
        rootDiv = this;
        var settings = $.extend({
            // These are the defaults.
            data: "",
        }, options);
        var obj = jQuery.parseJSON(settings.data);
        addBreadingGround();
        parent = $('<ul>');
        $(parent).appendTo(treeGround);
        traverseObj(obj);
        createNewMemberForm();
        member_details();
        createOptionsMenu();
        document.oncontextmenu = function () {
            return false;
        };

    }
    function tempTest(obj) {
        for (var i in obj) {
            document.write(i + " &nbsp;");
            if (i.indexOf('a') > -1 && i.length == 2) {
                ;
            } else {
                tempTest(obj[i]);
            }
        }
        return;
    }
    function traverseObj(obj) {

        for (var i in obj) {
            if (i.indexOf("li") > -1) {
                var li = $('<li>');
                $(li).appendTo(parent);
                parent = li;
                traverseObj(obj[i]);
                parent = $(parent).parent();
            }
            if (i.indexOf("a") > -1 && i.length == 2) {
                var link = $('<a>');
                link.attr('data-name', obj[i].name);
                link.attr('data-age', obj[i].age);
                link.attr('data-gender', obj[i].gender);
                link.attr('data-relation', obj[i].relation);
                link.attr('data-birth', obj[i].DB);
                link.attr('data-death', obj[i].DD);
                if (obj[i].relation == 'Spouse') {
                    link.attr('class', 'spouse');
                }
                var center = $('<center>').appendTo(link);
                var pic = $('<img>').attr('src', obj[i].pic);
                var extraData = "";
                if (obj[i].gender == "Male") {
                    extraData = "(M)";
                } else {
                    extraData = "(F)";
                }
                $(pic).appendTo(center);
                $(center).append($('<br>'));
                $('<span>').html(obj[i].name + " " + extraData).appendTo(center);
                

                $(link).click(function (event) {
                    //displayPopMenu(this, event);
                    //return false;
                    var scale = $("#pk-family-tree").attr('scale');
                    displayPopMenu(this, event);
                    return false;                    
                });


                $(link).appendTo(parent);
            }

            if (i.indexOf("ul") > -1) {
                var ul = $('<ul>');
                $(ul).appendTo(parent);
                parent = ul;
                traverseObj(obj[i]);
                return;
            }
        }
        return;
    }

    // function to send data to server
    $.send_Family = $.fn.pk_family_send = function (options) {
        if (rootDiv == null) {
            // error message in console
            jQuery.error('wrong id given');
            return;
        }
        var settings = $.extend({
            // These are the defaults.
            url: "",
        }, options);
        var data = createSendURL();
        data = data.replace(new RegExp(']', 'g'), "");
        data = data.replace(new RegExp('\\[', 'g'), "");
        console.log(data);
        $.ajax({
            url: settings.url + "?tree=" + data,
        }).done(function () {
            alert('completed');
        });
    }

    function createSendURL() {
        rut = $(treeGround).find("ul:first");
        parent = object;
        object = createJson(rut);
        return (JSON.stringify(object));

    }

    function createJson(root) {
        var thisObj = [];
        if ($(root).prop('tagName') == "UL") {
            var item = {};
            var i = 0;
            $(root).children('li').each(function () {
                item["li" + i] = createJson(this);
                i++;
            });
            thisObj.push(item);
            return thisObj;
        }
        if ($(root).prop('tagName') == "LI") {
            var item = {};
            var i = 0;
            $(root).children('a').each(function () {

                var m = "a" + i;
                item[m] = {};
                item[m]["name"] = $(this).attr("data-name");
                item[m]["age"] = $(this).attr("data-age");
                item[m]["gender"] = $(this).attr("data-gender");
                item[m]["DB"] = $(this).attr("data-birth");
                item[m]["DD"] = $(this).attr("data-death");
                try {
                    item[m]["relation"] = $(this).attr("data-relation");
                } catch (e) {
                    item[m]["relation"] = "self";
                }
                item[m]["pic"] = $(this).find('img:first').attr("src");
                i++;
            });

            if ($(root).find('ul:first').length) {
                parent = thisObj;
                item["ul"] = createJson($(root).find('ul:first'));
            }
            thisObj.push(item);
            return thisObj;
        }
    }
    function init() {
        // addMemberButton();
        addBreadingGround();
       // createNewMemberForm(); // this will popup new member form
        member_details();
        createOptionsMenu();
        displayFirstForm();
        document.oncontextmenu = function () {
            return false;
        };      

    }

    document.onload(function () {        
        $('btn.btn-cancel').css('display', 'none');
    });

    function createOptionsMenu() {
        var div = $('<div>').attr('id', 'pk-popmenu');
        var ul = $('<ul>');
        // add member button
        var liAdd = $('<li>').html('<i class="fa fa-plus-circle"></i> Add Member').appendTo(ul);
        liAdd.click(function (event) {
            displayForm();
            $(options_menu).css('display', 'none');
        });
        // view member button
        var liDisplay = $('<li>').html('<i class="fa fa-eye"></i> View Details').appendTo(ul);
        liDisplay.click(function (event) {
            displayData(selectedMember);
            $(options_menu).css('display', 'none');
        });
        // remove member button
        var liRemove = $('<li>').html('<i class="fa fa-trash-o"></i> Remove Member').appendTo(ul);
        liRemove.click(function (event) {
            removeMember(selectedMember);
            $(options_menu).css('display', 'none');
        });
        // cancel the pop menu
        var liCancel = $('<li>').html('<span class="glyphicon glyphicon-remove-circle"></span> Cancel').appendTo(ul);
        liCancel.click(function (event) {
            //displayForm(this);
            $(options_menu).css('display', 'none');
        });
        $(div).append(ul);
        options_menu = div;

        $(options_menu).appendTo('#imageFullScreen');

    }
    function createNewMemberForm() {
        var memberForm = $('<div>').attr('id', 'pk-memberForm');
        var memberFormContent = $('<div>').attr('id', 'pk-memberFromContent');
        //$(memberFormContent).appendTo(memberForm);
        $(memberFormContent).appendTo(memberForm);
        var cross = $('<div>').attr('class', 'pk-cross');
        $(cross).text('X');
        $(cross).click(closeForm);
        $(cross).appendTo(memberFormContent);
        var table = $('<table>').appendTo(memberFormContent);
        // name
        $('<tr>').html('<td><h4 class="modal-title">Add Member</h4></td>').appendTo(table)
        $('<tr>').html('<td><div class="form-group"><input type="text" class="form-control" id="pk-name" required><span class="form-highlight"></span><span class="form-bar"></span><label class="float-label" for="pk-name">Name</label></div></td>').appendTo(table);
        $('<tr>').html('<td><div class="row"><div class="form-group col-sm-6"><div class="input-group width-100Per"><select class="form-control has-info"  id="pk-gender" placeholder="Placeholder"><option value="Male">Male</option><option value="Female">Female</option></select><span class="form-highlight"></span><span class="form-bar"></span><label for="pk-gender" class="hasdrodown">Gender</label></div></div><div class="form-group col-sm-6"><div class="input-group width-100Per"><input type="text" class="form-control" id="pk-age" required><span class="form-highlight"></span><span class="form-bar"></span><label class="float-label" for="pk-age">Age</label></div></div></div></td>').appendTo(table);
        $('<tr>').html('<td><div class="row"><div class="form-group col-sm-6 col-xs-12"><div class="input-group width-100Per date" data-provide="datepicker-inline"><input type="text" class="form-control" id="memBirthDate" required name="memBirthDate" /><span class="form-highlight"></span><span class="form-bar"></span><label class="hasdrodown" for="memBirthDate">Date of Birth</label><label class="input-group-addon modal-datepicker-ico" for="memBirthDate"><span class="glyphicon glyphicon-th"></span></label></div></div><div class="form-group col-sm-6 col-xs-12"><div class="input-group width-100Per date" data-provide="datepicker-inline"><input type="text" class="form-control" id="memDeathDate" required name="memDeathDate" /><span class="form-highlight"></span><span class="form-bar"></span><label class="hasdrodown" for="memDeathDate">Date of Death</label><label class="input-group-addon modal-datepicker-ico" for="memDeathDate"><span class="glyphicon glyphicon-th"></span></label></div></div></div></td>').appendTo(table);
        $('<tr>').html('<td class="relations"><div class="form-group"><div class="input-group width-100Per"><select class="form-control has-info" id="pk-relation" placeholder="Placeholder"><option value="Mother">Mother</option><option value="Father">Father</option><option value="Sibling">Sibling</option><option value="Child">Child</option><option value="Spouse">Spouse</option></select><span class="form-highlight"></span><span class="form-bar"></span><label for="pk-relation" class="hasdrodown">Relation</label></div></div></td>').appendTo(table);
        $('<tr>').html('<td><div class="form-group"><input class="form-control margin-T-10" type="file" id="pk-picture" required><span class="form-highlight"></span><span class="form-bar"></span><label class="hasdrodown" for="pk-picture">Upload Picture</label></div></td>').appendTo(table);
        var buttonSave = $('<input>').attr('type', 'button').attr('class', 'btn btn-green');
        var buttonCancel = $('<input>').attr('type', 'button').attr('class', 'btn btn-default cancelBtn margin-R-10');
        $(buttonSave).attr('value', 'Save');
        $(buttonCancel).attr('value', 'Cancel');
        $(buttonSave).click(saveForm);
        $(buttonCancel).click(closeForm);
        var td = $('<td>').attr('colspan', '2');
        td.css('text-align', 'right');
        td.append(buttonCancel, buttonSave);
        $('<tr>').append(td).appendTo(table);
        newMemberForm = memberForm;
        $(newMemberForm).appendTo(parentDiv);
        $('</table>')
        $('</div>')
        $('</div>')
    }


    function member_details() {
        memberDetails = $('<div>').attr('id', 'pk-member-details');
        $(memberDetails).appendTo(parentDiv);


    }

    function closeForm() {
        $(newMemberForm).css('display', 'none');
    }

    function saveForm() {
        memberName = $('#pk-name').val();
        memberGender = $('#pk-gender').val();
        memberAge = $('#pk-age').val();

        memberPic = $('#pk-picture');
        memberRelation = $('#pk-relation').val();
        memberdateOfBirth = $('#memBirthDate').val();
        memberdateofDeath = $('#memDeathDate').val();
        //clear exsiting data from form
        $('#pk-name').val('');
        $('#pk-age').val('');
        $('#pk-relation').val('');
        $('#memDeathDate').val('');
        $('#memBirthDate').val('');
        // after saving
        addMember();
        closeForm();
    }

    function addBreadingGround() {
        var member = $('<div>').attr('id', 'treeGround');
        $(member).attr('class', 'tree-ground');
        $(member).appendTo(rootDiv);
        treeGround = member;
        //$(treeGround).draggable(({ scroll: true });
        $("#imageFullScreen").draggable({ scroll: true });
    }

    function addMemberButton() {
        var member = $('<input>').attr('type', 'button');
        $(member).attr('value', 'Add Member');
        $(member).click(displayForm);
        $(member).appendTo(rootDiv);
    }
    function displayForm(input) {
        $('.relations').css('display', '');
        $(newMemberForm).css('display', 'block');
        $('.pk-cross, .cancelBtn').show();
    }
    function displayPopMenu(input, event) {
        if ($(options_menu).css('display') == 'none') {
            selectedMember = input;
            self = false;
            $(options_menu).css('display', 'block');
            var scale = $('#pk-family-tree').attr('scale')
            var inputWidth = $(input).outerWidth();      
            var etTop = $(input).offset().top;
            var etLeft = $(input).offset().left;
            var divTop = $('#imageFullScreen').offset().top;
            var divLeft = $('#imageFullScreen').offset().left;           

            $(options_menu).css('top', (etTop - divTop));
            $(options_menu).css('left', (etLeft - divLeft) + (inputWidth * scale));
        }
    }
    function displayFirstForm() {
        selectedMember = null;
        self = true;
        $('.relations').css('display', 'none');
        $(newMemberForm).css('display', 'block');
        $('#pk-relation').val('Main');
        $('.pk-cross, .cancelBtn').hide();
    }
    function addMember() {
        var aLink = $('<a>').attr('href', '#');
        var center = $('<center>').appendTo(aLink);
        var pic = $('<img>').attr('src', 'family-tree/images/profile.png');  // {{ url('/theme') }}/{{$theme}}/images/home/about-gnh-img.jpg
        var extraData = "";
        if (memberGender == "Male") {
            extraData = "(M)";
        } else {
            extraData = "(F)";
            $(pic).attr('src', 'family-tree/images/profile-f.png');
        }
        $(pic).appendTo(center);
        $(center).append($('<br>'));
        $('<span>').html(memberName + " " + extraData).appendTo(center);
        readImage(memberPic, pic);

        var li = $('<li>').append(aLink);
        $(aLink).attr('data-name', memberName);
        $(aLink).attr('data-gender', memberGender);
        $(aLink).attr('data-age', memberAge);
        $(aLink).attr('data-relation', memberRelation);

        $(aLink).attr('data-birth', memberdateOfBirth);
        $(aLink).attr('data-death', memberdateofDeath);
        /*$(aLink).mousedown(function(event) { 
            if (event.button == 2) {
                displayPopMenu(this, event);
                return false;
            }
            return true;
        });*/
        $(aLink).click(function (event) {
            //displayPopMenu(this, event);
            //return false;
            var scale = $("#pk-family-tree").attr('scale');
            displayPopMenu(this, event);
            return false;          
        });

        var sParent = $(selectedMember).parent(); // super parent
        if (selectedMember != null) {
            if (memberRelation == 'Mother') {
                var parent = $(sParent).parent();
                var parentParent = $(parent).parent();
                var fatherElement = $(parentParent).find("a:first");

                if (fatherElement.length == 0) {
                    console.log('adding adajecent to father');
                    console.log(fatherElement);
                    var tmp = $(fatherElement).parent();
                    $(aLink).attr('class', 'mother');
                    $(tmp).append(aLink);

                } else {
                    console.log('adding mother alone');
                    var ul = $('<ul>').append(li);
                    $(parent).appendTo(li);
                    $(parentParent).append(ul);
                }
            }
            if (memberRelation == 'Spouse') {
                $(aLink).attr('class', 'spouse');
                var toPrepend = $(sParent).find('a:first');
                $(sParent).prepend(aLink);
                $(sParent).prepend(toPrepend);
            }
            if (memberRelation == 'Child') {
                var toAddUL = $(sParent).find('UL:first');
                if ($(toAddUL).prop('tagName') == 'UL') {
                    $(toAddUL).append(li);
                } else {
                    var ul = $('<ul>').append(li);
                    $(sParent).append(ul);
                }

            }
            if (memberRelation == 'Sibling') {
                $(sParent).parent().append(li);

            }
            if (memberRelation == 'Father') {
                var parent = $(sParent).parent();
                var parentParent = $(parent).parent();
                var ul = $('<ul>').append(li);
                $(parent).appendTo(li);
                $(parentParent).append(ul);
            }
        } else {
            var ul = $('<ul>').append(li);
            $(treeGround).append(ul);

        }
    }

    // will show existing user info
    function displayData(element) {
        var memberDetailsContainer = $('<div>').attr('id', 'pk-memberDetailContent');
        var innerContent = $('<table>');
        var content = '';
        var cross = $('<div>').attr('class', 'pk-cross');
        $(cross).text('X');
        $(cross).click(function () {
            $(memberDetails).css('display', 'none')
        });
        $(memberDetails).empty();
        $(memberDetailsContainer).appendTo(memberDetails);
        $(cross).appendTo(memberDetailsContainer);
        content = content + '<tr><td colspan="2" style="text-align:center;"><img src="' + $(element).find('img').attr('src') + '"/></td></tr>';
        content = content + '<tr><td class="bold-text">Name</td><td>' + $(element).attr('data-name') + '</td></tr>';
        content = content + '<tr><td class="bold-text">Age</td><td>' + $(element).attr('data-age') + '</td></tr>';
        content = content + '<tr><td class="bold-text">Gender</td><td>' + $(element).attr('data-gender') + '</td></tr>';
        content = content + '<tr><td class="bold-text">Date of Birth</td><td>' + $(element).attr('data-birth') + '</td></tr>';
        content = content + '<tr><td class="bold-text">Date of Death</td><td>' + $(element).attr('data-death') + '</td></tr>';
        if ($(element).attr('data-relation')) {
            content = content + '<tr><td class="bold-text">Relation</td><td>' + $(element).attr('data-relation') + '</td></tr>';
        } else {
            content = content + '<tr><td class="bold-text">Relation</td><td>Self</td></tr>';
        }
        
        $(innerContent).html(content);
        $(memberDetailsContainer).append(innerContent);

        $(memberDetails).css('display', 'block');
    }
    function readImage(input, pic) {
        var files = $(input).prop('files');
        if (files && files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(pic).attr('src', e.target.result);
            }

            reader.readAsDataURL(files[0]);
        }
    }

    function removeMember(member) {
        if ($(member).attr('data-relation') == 'Sibling') {
            $(member).parent().remove();
        }
        if ($(member).attr('data-relation') == 'Child') {
            var cLen = $(member).parent().children('li').length;
            if (cLen > 1)
                $(member).remove();
            else {
                $(member).parent().remove();
            }
        }
        if ($(member).attr('data-relation') == 'Father') {
            var child = $(member).children('ul');
            var parent = $(member).parent().parent();
            $(child).appendTo(parent);
            $(member).remove();
        }
        if ($(member).attr('data-relation') == 'Spouse') {
            $(member).remove();
        }
    }



}(jQuery));

