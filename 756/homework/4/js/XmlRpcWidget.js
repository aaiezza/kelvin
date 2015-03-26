// Wrap code with module pattern
var XmlRpcWidget = function()
{
    var global = this;

    // ///////////////////////////////
    // Widget Constructor Function //
    // ///////////////////////////////
    global.makeXmlRpcWidget = function(parentElement)
    {
        // //////////////////////
        // /// Fields /////
        // //////////////////////

        // Components
        var container = parentElement;

        var updateServerButton = $('input#updateServerLoc');

        var getMethodsButton   = $('input#getMethodsButton');
        var getMethodsField    = $('select#getMethodsField');
        
        var getBeersButton     = $('input#getBeersButton');
        var getBeersField      = $('input#getBeersField');
        
        var getPriceButton     = $('input#getPriceButton');
        var getPriceField      = $('input#getPriceField');
        
        var getCheepestButton  = $('input#getCheepestButton');
        var getCheepestFields  = {
            name  : $('input#getCheepestName'),
            price : $('input#getCheepestPrice')
        };
        
        var getCostliestButton = $('input#getCostliestButton');
        var getCostliestFields = {
            name  : $('input#getCostliestName'),
            price : $('input#getCostliestPrice')
        };
        
        var setPriceButton   = $('input#setPriceButton');
        var setPriceFields = {
            name  : $('input#setPriceName'),
            price : $('input#setPricePrice')
        };

        $('.serviceCall[in]');

        // Properties
        var host = $('input#server_loc').val();






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
            update : function(host)
            {
                this.host = host;
            },
            log : function(message)
            {
            }
        };
    };
}();
