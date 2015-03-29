$(document).ready(function()
{
    $("#formBlock").accordion({
        active : false,
        collapsible : true,
        heightStyle : "content"
    });

    if ($(".error").length > 0)
    {
        $("#formBlock > :first-child").click();
    }

    themeWidget = makeThemeWidget($("#pictureBlock"));

    $.getScript("js/lib/perfect-scrollbar.min.js", function()
    {
        // Just tacking this in here for the scrollbar
        $("#work").perfectScrollbar();
        $("#aboutMe").perfectScrollbar({
            wheelPropagation : true,
            suppressScrollX : true
        });
        $("#info").perfectScrollbar({
            scrollYMarginOffset : 0,
            wheelPropagation : true,
            suppressScrollX : true,
            suppressScrollY : false
        });
        $(window).resize(function()
        {
            $("#work").perfectScrollbar("update");
            $("#aboutMe").perfectScrollbar("update");
            $("#info").perfectScrollbar("update");
        });
    });

});
