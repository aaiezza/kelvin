// Wrap code with module pattern
var Widget = function()
{
    var global = this;

    // ///////////////////////////////
    // Widget Constructor Function //
    // ///////////////////////////////
    global.makeWidget = function(parentElement)
    {
        // //////////////////////
        // /// Fields /////
        // //////////////////////

        var container = parentElement;

        var lastChoice = container.children().children().last().children().first().html();
        {
            lastChoice = +( lastChoice.substr(lastChoice.length - 1) );
        }

        // ////////////////////////////
        // Private Instance Methods //
        // ////////////////////////////
        function addChoice()
        {
            container.children().children().last().empty().append( $("<td>Choice " + (++lastChoice) + "</td>") ).append(
                $('<td><input type="text" name="choice' + lastChoice + '" size="15" />'));
            addButton();
        }

        function addButton()
        {
            container
            .append( $('<tr><td>')
                    .append( $('<input type="button" value="Add Choice">')
                            .click( function() {addChoice();} )
                    )
            );
        }

        // ////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        // ////////////////////////////////////////
        addButton();

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
    widget = makeWidget($("table"));
});