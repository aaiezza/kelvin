// Wrap code with module pattern
var CartWidget = function()
{
    var global = this;

    /////////////////////////////////
    // Widget Constructor Function //
    /////////////////////////////////
    global.makeCartWidget = function(parentElement)
    {
        //////////////////
        ///// Fields /////
        //////////////////

        var container = parentElement;

        var username = $("#user").html();

        var quantities = {};

        var total;

        var cartTable = $("<table id='niceTable'><thead><tr id='niceTableHeader'>");

        var removeProductsButton = $("<input id='removeProducts' type='button' value='Remove Selected Products'>");

        var updateQuantityButton = $("<input id='updateQuantity' type='button' value='Update Selected Products&#39 Quantity'>");

        var emptyCartButton = $("<input id='emptyCart' type='button' value='Empty Cart'>");
        
        var checkoutButton = $("<input id='checkout' type='button' value='Checkout'>");

        //////////////////////////////
        // Private Instance Methods //
        //////////////////////////////
        function retrieveCart(localAccess)
        {
            total = 0;

            $("#nice_tableBlock tbody tr").remove();

            $.ajax({
                async : false,
                url : "product_management/retrieveCart.php",
                data : { username : username },
                type : 'POST'
            }).done(
            function(products)
            {
                if ( products.length <= 0 )
                {
                    $("#niceTable").append(
                    $("<tr id='anEmptyCart'><td colspan=8>Cart Empty!</td></tr>"));
                }

                $.each( products,
                function(i, product)
                {
                    product.Sale /= 100;
                    product.Price /= 100;

                    $("#niceTable").append(
                    $("<tr class='productRow' title='" + product.Description +
                        "' product='" + product.ProductId + "'>")
                    .append(
                    $("<td>").append(
                    $("<span>" + product.ProductId + "</span>").prepend(
                    $("<input class='selectProduct' product='" + product.ProductId
                    + "' type='checkbox'>")))).append(
                    $("<td><img height='95' width='120' src='"  + product.ImageSitePath + "'></img></td>")).append(
                    $("<td><span>"  + product.Name + "</span></td>")).append(
                    $("<td><span class='currency'>" + product.Price + "</span></td>")).append(
                    $("<td class='cartQuantityCell'><input class='cartQuantity' type='number' value='"  +
                        product.CartQuantity + "' min=0 max=" + (product.inventoryQuantity + product.CartQuantity) +"></td>")).append(
                    $("<td><span>"  + (product.OnSale?'true':'false') + "</span></td>")).append(
                    $("<td><span class='currency'>"  + product.Sale + "</span></td>")).append(
                    $("<td><span class='currency'>"  + ((product.OnSale? product.Sale : product.Price) * product.CartQuantity) + "</span></td>")));

                    quantities[product.ProductId] = product.CartQuantity;
               
                    total += ((product.OnSale? product.Sale : product.Price) * product.CartQuantity);
                });

                ///////////////////////
                // PRODUCT SELECTION //
                ///////////////////////
                $(".selectProduct").click(function(event)
                {
                    event.stopPropagation();
                    var product = $(this).attr("product");
                    $(".productRow[product='" + product + "']").toggleClass("selected");
                    updateClickabilityOfButtons();
                });

                $(".productRow").children().click(function()
                {
                    var product = $(this).parent().attr("product");
                    $(".selectProduct[product='" + product + "']").click();
                });

                if (localAccess === true && products.length > 0 )
                {
                    $("#niceTable").tablesorter({
                        sortList : [ [ 0, 0 ] ]
                    });
                }

                $("#niceTable").trigger("update");

            });

            $("#nice_tableBlock").append( "<table><tr id='totalRow' class='selected'>\
                <td colspan='6'><h2 class='total'>Total</h2></td>\
                <td colspan='2' class='total currency'>" + total + "</td>\
                </tr><table>" );

            updateClickabilityOfButtons();

            $('.currency').formatCurrency();
        }

        function removeProducts()
        {
            $
            .each(
            _.map($(".selectProduct:checked"), function(checkbox)
            {
                return +$(checkbox).attr("product");
            }),
            function(i, product)
            {
                $.ajax({
                    url : "product_management/removeProductFromCart.php",
                    data : {
                        productId : product,
                        username : username
                    },
                    type : "POST"
                }).done(retrieveCart);
            });
        }

        function emptyCart()
        {
            $('.productRow').addClass('selected');
            $(".selectProduct").prop("checked", true);
            removeProducts();
        }

        function updateQuantity()
        {
            $
            .each(
            _.map($(".selectProduct:checked"), function(checkbox)
            {
                return {
                    productId : +$(checkbox).attr("product"),
                    newQuantity : +$(checkbox).parent().parent().parent().find('input.cartQuantity').val()
                };
            }),
            function(i, product)
            {
                $.ajax({
                    url : "product_management/updateProductInCart.php",
                    data : {
                        username : username,
                        productId : product.productId,
                        newQuantity : product.newQuantity
                    },
                    type : "POST"
                }).done( function( response ) {
                    if ( response )
                    {
                        $('body').jAlert( response.error, 'fatal' );
                    }
                    retrieveCart();
                });
            });

        }

        function updateClickabilityOfButtons()
        {
            switch ($(".selectProduct:checked").length)
            {
                case 0:
                    removeProductsButton.prop("disabled", true);
                    updateQuantityButton.prop("disabled", true);
                    break;
                /*case 1:*/default:
                    removeProductsButton.prop("disabled", false);
                    updateQuantityButton.prop("disabled", false);
                    break;
                // default:
                //     removeProductsButton.prop("disabled", false);
                //     updateQuantityButton.prop("disabled", true);
            }
        }
        //////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        //////////////////////////////////////////
        container.append($("<div>").append(cartTable).attr("id",
        "nice_tableBlock"));

        $("#niceTableHeader").append($("<th class='header'>ProductId</th>"))
        .append($("<th class='header'>Product Image</th>")).append(
        $("<th class='header'>Product Name</th>")).append(
        $("<th class='header'>Retail Price</th>")).append(
        $("<th class='header'>Quantity</th>")).append(
        $("<th class='header'>On Sale</th>")).append(
        $("<th class='header'>Sale Price</th>")).append(
        $("<th class='header'>Sub Total</th>"));

        $("#niceTable").append($("<tbody>"));

        retrieveCart(true);

        //////////////////////////
        // PRODUCT MODIFICATION //
        //////////////////////////
        removeProductsButton.click(function() {
            if (confirm("Are you sure you want to remove these products?"))
                removeProducts();
        });

        $('input.cartQuantity').change( function(e) {
            var row = $(this).parent().parent();
            var prodId = row.attr( 'product' );

            if (  ( +$(this).val() == quantities[prodId] &&  row.hasClass('selected') ) ||
                  ( +$(this).val() != quantities[prodId] && !row.hasClass('selected') ) ) 
            {
                row.children().get(0).click()
            }
        }).click( function (e) {
            e.stopImmediatePropagation();
        });

        updateQuantityButton.click(updateQuantity);

        emptyCartButton.click(function() {
            if (confirm("Are you sure you want to empty your cart?"))
                emptyCart();
        });

        checkoutButton.click(function() {
            $('#nice_tableBlock').jAlert(  s.sprintf('Subtotal:%1$1s$%2$.2f\
                            <br>Tax:%1$6s$%3$.2f\
                            <br>Shipping:%1$1s$%4$.2f\
                            <br><br>Total:%1$4s$%5$.2f\
                            <br><br>Ha! I wish!', ' ',
                    total, total * 0.08, _.keys(quantities).length * 4.10,
                    (total * 1.08) + (_.keys(quantities).length * 4 ) ), 'success');
        });

        $("#nice_tableBlock").append(emptyCartButton).append(removeProductsButton)
        .append(updateQuantityButton).append(checkoutButton);
        /////////////////////////////
        // Public Instance Methods //
        /////////////////////////////
        return {
            getRootEl : function()
            {
                return container;
            },
            refresh : function()
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
    cartWidget = makeCartWidget($("#content"));
});