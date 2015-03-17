// Wrap code with module pattern
var UserManagementWidget = function()
{
    var global = this;

    /////////////////////////////////
    // Widget Constructor Function //
    /////////////////////////////////
    global.makeUserManagementWidget = function(parentElement)
    {
        //////////////////
        ///// Fields /////
        //////////////////

        var container = parentElement;

        var userTable = $("<table id='userTable'><thead><tr id='userTableHeader'>");

        var deleteUsersButton = $("<input id='deletedUsers' type='button' value='Delete Selected Users'>");

        var updateUserButton = $("<input id='updateUser' type='button' value='Update Selected User'>");

        var addUserButton = $("<input id='addUser' type='button' value='Add User'>");

        //////////////////////////////
        // Private Instance Methods //
        //////////////////////////////
        function retrieveUsers(localAccess)
        {
            $("#userTable tbody").empty();

            $.ajax({
                async : false,
                url : "retrieveUsers.php",
                type : 'POST'
            }).done(
            function(users)
            {
                $.each( users,
                function(username, user)
                {
                    numbers = $("<td id='phone_numbers'>");

                    $.each(user.phone_numbers, function(i, number)
                    {
                        var tel = (number.number + "").replace(/(\d{3})(\d{4})/, "$1-$2");
                        var num = number.type + ": (" + number.area_code + ") " + tel;
                        numbers.append($("<p id='number_" + i + "''>").html(num));
                    });

                    $("#userTable").append(
                    $("<tr class='userRow' user='" + username + "'>")
                    .append(
                    $("<td>").append(
                    $("<span>" + username + "</span>").prepend(
                    $("<input class='selectUser' user='" + username
                    + "' type='checkbox'>")))).append(
                    $("<td><span>" + user.first_name + "</span></td>")).append(
                    $("<td><span>" + user.last_name + "</span></td>")).append(
                    numbers));
                });

                ////////////////////
                // USER SELECTION //
                ////////////////////
                $(".selectUser").click(function(event)
                {
                    event.stopPropagation();
                    var user = $(this).attr("user");
                    $(".userRow[user='" + user + "']").toggleClass("selected");
                    updateClickabilityOfButtons();
                });

                $(".userRow").children().click(function()
                {
                    var user = $(this).parent().attr("user");
                    $(".selectUser[user='" + user + "']").click();
                });

                if (localAccess === true)
                {
                    $("#userTable").tablesorter({
                        sortList : [ [ 0, 0 ] ]
                    });
                }

                $("#userTable").trigger("update");

            });

            updateClickabilityOfButtons();
        }

        function deleteUsers()
        {
            if (confirm("Are you sure you want to delete these users?"))
            {
                $.each(
                _.map($(".selectUser:checked"), function(checkbox)
                {
                    var user = $(checkbox).attr("user");
                    return $(".userRow[user=" + user + "]");
                }),
                function(i, user)
                {
                    $.ajax({
                        async : false,
                        url : "./deleteUser.php",
                        data: {username : $(user).attr("user") },
                        type : "POST"
                    }).done(retrieveUsers);
                });
            }
        }

        function updateUser()
        {
            var user = $(".selectUser:checked").attr("user");
            location = "userDetails.php?username=" + user;
        }

        function updateClickabilityOfButtons()
        {
            switch ($(".selectUser:checked").length)
            {
                case 0:
                    deleteUsersButton.prop("disabled", true);
                    updateUserButton.prop("disabled", true);
                    break;
                case 1:
                    deleteUsersButton.prop("disabled", false);
                    updateUserButton.prop("disabled", false);
                    break;
                default:
                    deleteUsersButton.prop("disabled", false);
                    updateUserButton.prop("disabled", true);
            }
        }
        //////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        //////////////////////////////////////////
        container.append($("<div>").append(userTable).attr("id",
        "user_tableBlock"));

        $("#userTableHeader").append($("<th class='header'>Username</th>")).append(
        $("<th class='header'>First Name</th>")).append(
        $("<th class='header'>Last Name</th>")).append(
        $("<th class='header'>Phone Numbers</th>"));

        $("#userTable").append($("<tbody>"));

        retrieveUsers(true);

        ///////////////////////
        // USER MODIFICATION //
        ///////////////////////
        deleteUsersButton.click(deleteUsers);

        updateUserButton.click(updateUser);

        addUserButton.click(function(){location = "./addUser.php";});

        $("#user_tableBlock").append(deleteUsersButton)
        .append(updateUserButton).append(addUserButton);

        /////////////////////////////
        // Public Instance Methods //
        /////////////////////////////
        return {
            getRootEl : function()
            {
                return container;
            },
            refresh : function()
            {
                retrieveUsers(false);
            },
            log : function(message)
            {

            }
        };
    };
}();

$(document).ready(function()
{
    userManagementWidget = makeUserManagementWidget($("#content"));
});