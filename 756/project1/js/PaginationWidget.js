// Wrap code with module pattern
var Paginationidget = function()
{
    var global = this;

    // ///////////////////////////////
    // Widget Constructor Function //
    // ///////////////////////////////
    global.makePaginationWidget = function(parentElement)
    {
        // //////////////////////
        // /// Fields /////
        // //////////////////////

        var container = parentElement;

        var username = $('#user').html();

        var page = +$('p#page').html();

        var lastPage = +$('p#lastPage').html();

        var pageForesight = 3;

        // ////////////////////////////
        // Private Instance Methods //
        // ////////////////////////////

        function retrieveProducts( paginate, notOnSale )
        {
            var data = paginate? {page : page}:{};
            if ( notOnSale != 0 )
            {
                data['notOnSale'] = notOnSale;
            }

            var products = $.ajax({
                async : false,
                url : "product_management/retrieveProducts.php",
                data : data,
                type : 'POST'
            }).responseJSON;

            return _.filter( products, function(product){
                if ( product.Quantity > 0 )
                {
                    product.OutOfStock = '';
                    product.AddToCart = 'Add to Cart';
                }
                else
                {
                    product.OutOfStock = 'disabled';
                    product.AddToCart = 'Out of Stock';
                }

                product.usernameDisabled = ((username == "%%")? "disabled":"");
                return true;
            });
        }

        // ////////////////////////////////////////
        // Find Pieces and Enliven DOM Fragment //
        // ////////////////////////////////////////

        // PAGINATION
        var pagination = $('<p>');

        if ( page > 1 )
        {
            pagination.append( '<a href="?page=1">&lt;&lt;</a>' )
                .append( '<a href="?page=' + (page-1) + '">&lt;</a>' );
        }

        var befores = [];
        for ( var p = page-1; p >= page - pageForesight && p > 0; p -- )
        {
            befores.unshift( '<a href="?page='+p+'">'+p+'</a>' );
        }
        pagination.append(befores);

        pagination.append( '<span>'+page+'</span>' );

        for ( var p = page+1; p <= page + pageForesight && p <= lastPage; p ++ )
        {
            pagination.append( '<a href="?page='+p+'">'+p+'</a>' );
        }

        if ( page < lastPage )
        {
            pagination.append( '<a href="?page=' + ( page+1 ) + '">&gt;</a>' )
                .append( '<a href="?page=' + lastPage + '">&gt;&gt;</a>' );
        }

        container.append( pagination );


        // ///////////////////////////
        // Public Instance Methods //
        // ///////////////////////////
        return {
            getRootEl : function()
            {
                return container;
            },
            retrieveProducts : retrieveProducts,
            log : function(message)
            {
            }
        };
    };

}();

$(document).ready(function()
{
    paginationWidget = makePaginationWidget($("#pagination"));
});
