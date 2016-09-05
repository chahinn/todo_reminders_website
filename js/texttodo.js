$(document).ready(function(){

        $("#signupbtn").click(function(){
            if($("#signup").is(":visible")){
                $("#signup").hide();
            } else {
                $("#signup").show();
                $("#login").hide();
            }
            return false;
        });
        
        $("#loginbtn").click(function(){
            if($("#login").is(":visible")){
                $("#login").hide();
            } else {
                $("#login").show();
                $("#signup").hide();
            }
            return false;
        });

        $("#logoutbtn").click(function() {
            var clickBtnValue = $(this).val();
            var ajaxurl = 'logout.php',
            data =  {'action': clickBtnValue};
            $.post(ajaxurl, data, function (response) {
                window.location.reload();
            });
            return false;
        });

        $('#addlistbtn').click(function() {

            if ($('#addListFieldset').hasClass('invisible')) {
                $('#addListFieldset').removeClass('invisible');
                $('#addListFieldset').addClass('visible');
            } else {
                $('#addListFieldset').removeClass('visible');
                $('#addListFieldset').addClass('invisible');
            }
            
            return false;
        });

        $('#additembtn').click(function() {

            if ($('#addtodoitemFieldset').hasClass('invisible')) {
                $('#addtodoitemFieldset').removeClass('invisible');
                $('#addtodoitemFieldset').addClass('visible');
            } else {
                $('#addtodoitemFieldset').removeClass('visible');
                $('#addtodoitemFieldset').addClass('invisible'); 
            }
            
            return false;
        });

        $('#addpersontolistbtn').click(function() {

            if ($('#addpersonFieldset').hasClass('invisible')) {
                $('#addpersonFieldset').removeClass('invisible');
                $('#addpersonFieldset').addClass('visible');
            } else {
                $('#addpersonFieldset').removeClass('visible');
                $('#addpersonFieldset').addClass('invisible');
            }

            return false;
        });

        $('#updateitembtn').click(function() {
            if ($("input[name=todoitemsid]:checked").length != 1) {
                alert("Please select ONE task to update!");
            } else {
                var TaskID = $("input[name=todoitemsid]:checked").val();
                var ajaxurl = 'setCurrentVals.php',
                data =  {'TaskID': TaskID};
                $.post(ajaxurl, data, function (response) {

                    var json = JSON.parse(response);
                    $('#newsubjecttxt').val(json["Subject"]);
                    $('#newdescriptiontxt').val(json["Description"]);
                    $('#newchooseMonth').val(json["Month"]);
                    $('#newchooseYear').val(json["Year"]);
                    $('#newchooseDay').val(json["Day"]);
                    $('#newchooseHour').val(json["Hour"]);
                    $('#newchooseMinute').val(json["Minute"]);
                    $('#newchooseSeconds').val(json["Second"]);

                    if ($('#updateItemFieldset').hasClass('invisible')) {
                        $('#updateItemFieldset').removeClass('invisible');
                        $('#updateItemFieldset').addClass('visible'); 
                    } else {
                        $('#updateItemFieldset').removeClass('visible');
                        $('#updateItemFieldset').addClass('invisible'); 
                    }

                    
                });
            }
            return false;
        });

        $("#submitlistbtn").click(function() {
            var listName = $("#listnametxt").val();
            var ajaxurl = 'createlist.php',
            data =  {'listName': listName};
            $.post(ajaxurl, data, function (response) {
                //alert(response);
                window.location.reload();
                window.location.replace("index.php?ListID=" + response);
            });
            return false;
        });

        $("#submittodobtn").click(function() {
            var subject = $("#subjecttxt").val();
            var description = $("#descriptiontxt").val();

            var month = $("#chooseMonth").val();
            var day = $("#chooseDay").val();
            var year = $("#chooseYear").val();
            var hour = $("#chooseHour").val();
            var minute = $("#chooseMinute").val();
            var seconds = $("#chooseSeconds").val();

            var dateTimeReminder = year + "-" + month + "-" + day + " " + hour + ":" + minute + ":" + seconds;
            var ListID = $("#HiddenListID").val();
            var ajaxurl = 'additem.php',
            data =  {'subject': subject, 'description': description, 'dateTimeReminder': dateTimeReminder, 'ListID': ListID};
            $.post(ajaxurl, data, function (response) {
                //alert(response);
                window.location.reload();
            });
            return false;
        });

        $("#submitpersonbtn").click(function() {
            var UserName = $('#usernametxt').val();
            var ListID = $("#HiddenListID").val();
            var ajaxurl = 'adduser.php',
            data =  {'UserName': UserName, 'ListID': ListID};
            $.post(ajaxurl, data, function (response) {
                //alert(response);
                if (response == "failure") {
                    alert("That user does not exist!");
                }
                window.location.reload();
            });
            return false;
        });

        $("#completetasksbtn").click(function() {
            var completedVals = $("input[name=todoitemsid]:checked").map(function () {return this.value;}).get().join(",");
            var ajaxurl = 'completeTasks.php',
            data =  {'completedVals': completedVals};
            $.post(ajaxurl, data, function (response) {
                //alert(response);
                window.location.reload();
            });
            return false;
        });

        $("#incompletetasksbtn").click(function() {
            //alert("here");
            //console.log("hello");
            var incompletedVals = $("input[name=todoitemsid]:checked").map(function () {return this.value;}).get().join(",");
            //alert(incompletedVals);
            var ajaxurl = 'incompleteTasks.php',
            data =  {'incompletedVals': incompletedVals};
            $.post(ajaxurl, data, function (response) {
                //alert(response);
                window.location.reload();
            });
            return false;
        });

        $("#remindbtn").click(function() {
            if ($("input[name=todoitemsid]:checked").length != 1) {
                alert("Please select ONE task to remind users about!");
            } else {
                var chosenTasks = $("input[name=todoitemsid]:checked").map(function () {return this.value;}).get().join(",");
                var ajaxurl = 'remindUsers.php',
                data =  {'chosenTasks': chosenTasks};
                $.post(ajaxurl, data, function (response) {
                    alert("Text messages have been sent out to the members of this list!");
                    window.location.reload();
                });
            }
            return false;
        });

        $("#deletelistbtn").click(function() {
            var check = confirm("Are you sure you want to delete this list? This action is unreversable!");
            if (check == true) {
                var ListID = $("#HiddenListID").val();
                var ajaxurl = 'deletelist.php',
                data =  {'ListID': ListID};
                $.post(ajaxurl, data, function (response) {
                    //alert(response);
                    //window.location.reload();
                    window.location.replace("index.php");
                });
                return false;
            }
            
            
        });

        $("#submitupdatedtodobtn").click(function() {
            var subject = $("#newsubjecttxt").val();
            var description = $("#newdescriptiontxt").val();
            var dateTimeReminder = $("#newdatetimereminder").val();
            var ListID = $("#HiddenListID").val();
            var TaskID = $("input[name=todoitemsid]:checked").val();
            var ajaxurl = 'updateItem.php',
            data =  {'taskID': TaskID, 'subject': subject, 'description': description, 'dateTimeReminder': dateTimeReminder};
            $.post(ajaxurl, data, function (response) {
                //alert(response);
                window.location.reload();
            });
            return false;
        });

        $("#leavelistbtn").click(function() {
            var UserID = $("#HiddenUserID").val();
            var ListID = $("#HiddenListID").val();
            var ajaxurl = 'removeMember.php',
            data =  {'UserID': UserID, 'ListID': ListID};
            $.post(ajaxurl, data, function (response) {
                //alert(response);
                window.location.replace("index.php");
            });
            return false;
        });

        $("#homebtn").click(function() {
            window.location.replace("index.php");
        });
        
        $('#cancellistbtn').click(function() {
            $('#addListFieldset').removeClass('visible');
            $('#addListFieldset').addClass('invisible');
            $("#listnametxt").val("");
            return false;
        });

        $('#canceltodobtn').click(function() {
            $('#addtodoitemFieldset').removeClass('visible');
            $('#addtodoitemFieldset').addClass('invisible');
            return false;
        });

        $('#cancelpersonbtn').click(function() {
            $('#addpersonFieldset').removeClass('visible');
            $('#addpersonFieldset').addClass('invisible');
            return false;
        });

        $('#cancelupdatedtodobtn').click(function() {
            $('#updateItemFieldset').removeClass('visible');
            $('#updateItemFieldset').addClass('invisible');
            return false;
        });

});