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

        // ////////////////////////////
        // Private Instance Methods //
        // ////////////////////////////
        function doStuff(arg)
        {
        }

        // ////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        // ////////////////////////////////////////

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
    widget = makeWidget($("#block"));
});