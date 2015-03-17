// Wrap code with module pattern
var ThemeWidget = function()
{
    var global = this;

    // ///////////////////////////////
    // Widget Constructor Function //
    // ///////////////////////////////
    global.makeThemeWidget = function(parentElement)
    {
        // //////////////////////
        // /// Fields /////
        // //////////////////////

        var container = parentElement;

        var currentTheme = $("link#theme");

        var THEME_LOCATION_FORMAT = "http://kelvin.ist.rit.edu/~axa9070/756/css/theme/{theem}.css";

        var themes = [ "dnax", "space" ];

        // ////////////////////////////
        // Private Instance Methods //
        // ////////////////////////////
        function changeTheme(theme)
        {
            $(themes).each(
                    function(i, theem)
                    {
                        if (theme != theem)
                        {
                            currentTheme.attr("href", THEME_LOCATION_FORMAT
                                    .replace("{theem}", theem));

                            var url = addURLParameter("theme", theem);
                            history.pushState({
                                "Theme" : theem
                            }, "", url);
                        }
                    });
        }

        // ////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        // ////////////////////////////////////////
        container.click(function()
        {
            changeTheme(getURLParameter("theme"));
        });

        var theTheme = currentTheme.attr("href");
        theTheme = theTheme.substring(theTheme.lastIndexOf("/") + 1, theTheme
                .lastIndexOf("."));

        if ($.inArray(theTheme, themes) < 0)
            container.click();

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
