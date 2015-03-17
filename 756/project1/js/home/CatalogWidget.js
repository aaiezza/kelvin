// Wrap code with module pattern
var CatalogWidget = function()
{
    var global = this;

    // ///////////////////////////////
    // Widget Constructor Function //
    // ///////////////////////////////
    global.makeCatalogWidget = function(parentElement)
    {
        // //////////////////////
        // /// Fields /////
        // //////////////////////

        var container = parentElement;

        var username = $('#user').html();

        var page = +$('p#page').html();

        var lastPage = +$('p#lastPage').html();

        var pageForesight = 3;

        var PRODUCT_TEMPLATE = _.template(
            '<div class="product"><h4 class="product_title"><%- Name %></h4>\
            <a class="product_image_link" href="<%= ImageSitePath %>">\
                <img class="product_image" src="<%= ImageSitePath %>">\
            </a>\
            <div class="product_price_description">\
            <p class="product_price currency"><%= Price %></p>\
            <p class="product_description"><%= Description %></p></div>\
            <div class="cart_quant"><input class="add_to_cart" id="product_<%= ProductId %>" type="button" value="<%= AddToCart %>"\
                onclick="catalogWidget.addProductToCart(<%= ProductId %>)" <%= OutOfStock %>>\
            <span id="product_<%= ProductId %>_quantity" class="product_quantity"> x <%= Quantity %> Left</span>\
            </div></div><hr>'
        );

        // ////////////////////////////
        // Private Instance Methods //
        // ////////////////////////////

        function addProductToCart( product )
        {
            var response = $.ajax({
                async : false,
                url : "product_management/addToCart.php",
                data : {
                    productId : product,
                    username : username
                },
                type : 'POST'
            }).done( function ( response )
            {
                if ( response.error )
                {
                    console.error( response.error );
                } else
                {
                    $('span#product_' + response.productId + '_quantity')
                    .html( ' x ' + response.quantity + ' Left' );
                    if ( response.quantity <= 0 )
                    {
                        $('input#product_' + response.productId)
                        .val('Out of Stock').prop('disabled', true);
                    }
                    
                    salesWidget.update();

                    alert( 'Product Added to Cart!' );
                }
            });
        }

        // ////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        // ////////////////////////////////////////

        // POPULATE CATALOG
        $.each( _.filter(
            paginationWidget.retrieveProducts(true, 1), function(p){
                p.Description = p.Description.replace(/\n/g,'<br>');
                p.Price = p.Price / 100;
                return !p.OnSale
            }), function ( i, product )
        {
            container.append( $( PRODUCT_TEMPLATE( product ) ) );
        } );

        $('.add_to_cart').prop( 'disabled', username == '%%' );

        $('.currency').formatCurrency();

        // PERFECT SCROLLBAR
        container.perfectScrollbar();

        $(window).resize(function()
        {
            container.perfectScrollbar("update");
        });

        // ///////////////////////////
        // Public Instance Methods //
        // ///////////////////////////
        return {
            getRootEl : function()
            {
                return container;
            },
            addProductToCart : addProductToCart,
            log : function(message)
            {
            }
        };
    };

}();

$(document).ready(function()
{
    catalogWidget = makeCatalogWidget($("#catalogBlock"));
});