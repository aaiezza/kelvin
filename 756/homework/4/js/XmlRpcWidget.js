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

        var container = parentElement;

        var updateServerButton = $('input#updateServerLoc');
        var host = $('input#server_loc').val();

        updateServerButton.click( function() {
            host = $('input#server_loc').val();
        });

        var clientLayer = 'xmlrpc_client.php';

        // ////////////////////////////
        // Private Instance Methods //
        // ////////////////////////////
        function callDestination()
        {
            // work with jQuery object
            var button = $(this);

            // get the destination path to the service
            var destination = button.attr('dest');

            // xmlrpc request map
            var request = {
                url : clientLayer,
                server : host,
                methodName : destination,
                params : []
            };

            // any inputs?
            var inputs = button.attr('in').split(' ');

            if (inputs && !(inputs.length == 0 || inputs[0] == '' ))
            {
                $.each( inputs, function() {
                    var element = $('#' + this);
                    if ( element == undefined )
                        throw new Error('Element with id: \''+this+'\' was not found.');

                    var value = element.is('.currency')?
                        parseFloat(element.val().replace('$','')) : element.val();
                    if ( element.is('.currency') && value == "" )
                        value = 0;
                    request['params'].push(value);
                });
            }

            // get the output location
            var outputs = button.attr('out').split(' ');

            if (!outputs || outputs.length == 0 || outputs[0] == '')
            {
                if ( button.is('#setPriceButton') )
                {
                    request['success'] = function(response) {
                        if ( response )
                        {
                            alert( 'Price changed!' );
                            inputs.val('');
                        }
                        else alert( 'There was an issue with your update!' );
                    };
                }
                else
                {
                    // we have an issue!
                    var issue = 'The button for: \''+destination+'\' has no output location set. ';
                    alert(issue);
                    throw new Error(issue);
                }
            }
            else
            {
                var outputElements = [];

                $.each( outputs, function() {
                    var element  = $('#' + this);
                    if ( element == undefined )
                        throw new Error('Element with id: \''+this+'\' was not found.');

                    outputElements.push(element);
                });

                request['success'] = function(response) {

                    // This needs to be different for each call
                    if (_.isArray(response))
                    {
                        // getMethods and getBeers
                        if (button.is('#getMethodsButton') || button.is('#getBeersButton'))
                        {
                            outputElements[0].empty();
                            for( var i = 0; i < response.length; i ++ ) {
                                outputElements[0].append( '<option>'+response[i]+'</option>' );
                            }
                        }
                    }
                    else
                    {
                        outputElements[0].val(response);

                        // getCheapest and getCostliest
                        if (button.is('#getCheapestButton') || button.is('#getCostliestButton'))
                        {
                            $.xmlrpc({
                                url : clientLayer,
                                server : host,
                                methodName : "beer.getPrice",
                                params : [response]
                            }).done(function(res){
                                outputElements[1].val(res);
                                $('.currency').formatCurrency();
                            });

                        }
                    }

                    $('.currency').formatCurrency();
                };
            }

            request['error'] = function(jqXHR, status, error) {
                console.error(jqXHR.responseText);
                console.error(error.stack);
            };

            $.xmlrpc(request);
        }

        // ////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        // ////////////////////////////////////////

        $('.serviceCall[in]').click( callDestination );

        $('#getBeersField').on( "change input", function(){ $('#getPriceField').val(''); });

        $('#setPricePrice').blur( function(){ $(this).formatCurrency(); });

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
