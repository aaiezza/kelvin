// Wrap code with module pattern
var SalesWidget = function()
{
    var global = this;

    // ///////////////////////////////
    // Widget Constructor Function //
    // ///////////////////////////////
    global.makeSalesWidget = function(parentElement)
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
        
        container.append("");

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
    widget = makeSalesWidget($("#salesBlock"));
});