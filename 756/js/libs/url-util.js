window.addURLParameter = function(parameterName, parameterValue, atStart)
{
    var url = window.location.href;
    var replaceDuplicates = true;
    if (url.indexOf('#') > 0)
    {
        var cl = url.indexOf('#');
        urlhash = url.substring(url.indexOf('#'), url.length);
    } else
    {
        urlhash = '';
        cl = url.length;
    }
    sourceUrl = url.substring(0, cl);

    var urlParts = sourceUrl.split("?");
    var newQueryString = "";

    if (urlParts.length > 1)
    {
        var parameters = urlParts[1].split("&");
        for (var i = 0; (i < parameters.length); i++)
        {
            var parameterParts = parameters[i].split("=");
            if (!(replaceDuplicates && parameterParts[0] == parameterName))
            {
                if (newQueryString == "")
                    newQueryString = "?";
                else
                    newQueryString += "&";
                newQueryString += parameterParts[0] + "="
                        + (parameterParts[1] ? parameterParts[1] : '');
            }
        }
    }
    if (newQueryString == "")
        newQueryString = "?";

    if (atStart)
    {
        newQueryString = '?'
                + parameterName
                + "="
                + parameterValue
                + (newQueryString.length > 1 ? '&'
                        + newQueryString.substring(1) : '');
    } else
    {
        if (newQueryString !== "" && newQueryString != '?')
            newQueryString += "&";
        newQueryString += parameterName + "="
                + (parameterValue ? parameterValue : '');
    }
    return urlParts[0] + newQueryString + urlhash;
};

window.getURLParameter = function(name)
{
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex
            .exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g,
            " "));
}