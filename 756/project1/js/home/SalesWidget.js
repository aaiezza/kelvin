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

        FOTO.Slider.baseURL = '';

        FOTO.Slider.thumbURL = FOTO.Slider.mainURL = '{ID}';

        var PRODUCT_TEMPLATE = _.template(
            '<div id="shell"><h4 class="product_title"><%- Name %></h4>\
            <div class="product_price_description">\
            <p class="product_price currency"><%= Sale %></p>\
            <p class="product_retail">Retail <span class="currency"><%= Price %></span></p>\
            <p class="product_description"><%= Description %></p></div>\
            <div class="cart_quant"><input class="add_to_cart" id="product_<%= ProductId %>" type="button" value="<%= AddToCart %>"\
                onclick="catalogWidget.addProductToCart(<%= ProductId %>)" <%= OutOfStock %> <%= usernameDisabled %>>\
            <span id="product_<%= ProductId %>_quantity" class="product_quantity"> x <%= Quantity %> Left</span></div></div>'
        );

        // ////////////////////////////
        // Private Instance Methods //
        // ////////////////////////////

        function retrieveProductsOnSale()
        {
            return _.filter( paginationWidget.retrieveProducts(false, 0),function(product) {
                product.Description = product.Description.replace(/\n/g,'<br>');
                product.Price = product.Price / 100;
                product.Sale = product.Sale / 100;
                return product.OnSale;
            });
        }

        function updateCaptions()
        {
            // Add caption containing way to add product to cart
            $.each( retrieveProductsOnSale(), function( i, product )
            {
                FOTO.Slider.bucket['salesBlock'][product.ImageSitePath]['caption'] =
                PRODUCT_TEMPLATE( product );
            });
        }

        // ////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        // ////////////////////////////////////////

        // Place products in slider
        FOTO.Slider.importBucketFromIds('salesBlock', _.pluck( retrieveProductsOnSale(), 'ImageSitePath' ));

        updateCaptions();

        FOTO.Slider.reload('salesBlock');
        FOTO.Slider.play('salesBlock');  
        FOTO.Slider.preloadImages('salesBlock');

        $( window ).resize( function()
        {
            container.empty();
            container.append("<h1 id='saleItems'>Sale Items!</h1>");
            FOTO.Slider.reload('salesBlock');
        });

        // Stop that crazy slideshow!
        $('.photoslider_main, .photoslider_caption').click( function( event ) {
            event.stopImmediatePropagation();
            FOTO.Slider.stop('salesBlock');
        });

        // $(".photoslider_caption").change( updateCaptions );

        $(".photoslider_main img").click( function(){
            if ($(this).attr( 'src' ))
                location = $(this).attr( 'src' );
        });

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
            update : function()
            {
                updateCaptions();
            },
            log : function(message)
            {
            }
        };
    };

}();

$(document).ready(function()
{
    salesWidget = makeSalesWidget($("#salesBlock"));
});