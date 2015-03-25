
// SELECT TABLE
// JS
document.getElementById( 'niceTable' );
// jQuery
$( '#niceTable' );

// ALTERNATE ROW COLORS
// JS
var table = document.getElementById( 'niceTable' );
for ( var i = 1; i < table.rows.length; i += 2 )
{
    table.rows[i].style.backgroundColor = "#E4E4F8";
}
// jQuery
$("tr:odd").css("background-color", "#E4E4F8");
