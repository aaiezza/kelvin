// Wrap code with module pattern
var UserDetailsWidget = function()
{
    var global = this;

    // ///////////////////////////////
    // Widget Constructor Function //
    // ///////////////////////////////
    global.makeUserDetailsWidget = function(parentElement)
    {
        // //////////////////////
        // /// Fields /////
        // //////////////////////

        var container = parentElement;

        var userDetails;

        // ////////////////////////////
        // Private Instance Methods //
        // ////////////////////////////
        function getDetails()
        {
            var username = $("#user").html();

            userDetails = $.ajax({
                url : "./getUser.php",
                type : "POST",
                data : {
                    username : username
                },
                async : false
            }).responseJSON;
        }

        function updateUserDetails()
        {
            var field = $(this).attr("id");

            var detail = userDetails[field];
            
            var input = $(this);
            
            if ( input.is('.phone')  || input.parent().is('.phone')  )
            {
                var phoneId = $(this).attr('name');
                phoneId = phoneId.substr( phoneId.length - 2 );
                
                $("input[value=" + phoneId + "]").click();
                return;
            }
            
            if ( field == 'phone_numbers' )
            {
                $.each( detail, function( i )
                {
                    if ( i == input.val() )
                    {
                        var same =
                        $("input[name=area_code" + i + "]" ).val() == "(" + detail[i]['area_code'] + ")" &&
                        $("select[name=type" + i + "] option:selected" ).val() == detail[i]['type'] &&
                        $("input[name=number" + i + "]" ).val() == detail[i]['number'].replace(/(\d{3})(\d{4})/, "$1-$2");
                        $("tr:has(#" + field + ")").toggleClass("selected", !same);
                        return same;
                    }
                });
            
            } else
            {
                $("tr:has(#" + field + ")").toggleClass("selected",
                        detail != $(this).val());
            }

            updateClickabilityOfButtons();
        }

        function updateClickabilityOfButtons()
        {
            var clickable = $(".selected").length > 0;

            $("#updateFieldsButton").prop("disabled", !clickable);
            $("#deleteNumberButton").prop("disabled", true);

            $.each($("input[name='phone_number']"), function()
            {
                if ($(this).is(':checked') && $(this).val() != -1)
                {
                    $("#deleteNumberButton").prop("disabled", false);
                    return false;
                }
            });
        }
        ;
        // ////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        // ////////////////////////////////////////
        getDetails(userDetails);

        $("tr input[type!=button], select").on("click change input mousedown", updateUserDetails);

        // If it was meant to be permanent, disable it!
        $("tr.permanent input[type!=button][type!=submit]").prop("readonly",
                true);

        $("tr.permanent input[type=checkbox]").click(function()
        {
            return false;
        });

        $("#addNumberButton")
                .click(
                        function()
                        {
                            if ($("table#phone_numbers tr[new='new']").length > 0)
                                return;

                            var newNumber = $("<tr class=\"selected\">").attr(
                                    'new', 'new');

                            newNumber
                                    .append('<td>\
                                            <input type="radio" name="phone_number" value="-1" id="phone_numbers" number_id="-1" class="phoneNumberBox" selected>\
                                            </td>');
                            newNumber
                                    .append('<td>\
                                            <span class="phone_type phone"><select id="type" name="type-1">\
                                            <option value="home">home</option>\
                                            <option value="office">office</option>\
                                            <option value="cell">cell</option>\
                                            <option value="other">other</option>\
                                            </select> </span>\
                                            <input class="phone_area_code phone" name="area_code-1" placeholder="Area Code" value="">\
                                            <input class="phone_number phone" name="number-1" placeholder="Telephone Number" value="">\
                                            </td>');

                            $("table#phone_numbers").append(newNumber);

                            $("tr input[type!=button], select").on("change input mousedown", updateUserDetails);

                            $("input#phone_numbers[value='-1']").click();
                        });

        $("#deleteNumberButton").click(function()
        {
            $("#updateFieldsButton").attr('name', 'deleteNumber').click();
        });

        updateClickabilityOfButtons();

        // ///////////////////////////
        // Public Instance Methods //
        // ///////////////////////////
        return {
            getRootEl : function()
            {
                return container;
            },
            update : function()
            {

            },
            log : function(message)
            {

            }
        };
    };
}();

$(document).ready(function()
{
    userDetailsWidget = makeUserDetailsWidget($("#content"));
});