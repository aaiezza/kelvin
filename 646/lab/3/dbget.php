<?php
include '/home/axa9070/etc/db_conn.php';
$table = 'phonebook';

// Create connection
$conn = new mysqli( $hostname, $username, $password, $database );

// Check connection
if ( $conn->connect_error )
{
    die( "Connection failed: " . $conn->connect_error );
} 

$sql = "SELECT * FROM $table";

$result = $conn->query( $sql );

if ( $result->num_rows > 0 )
{
    // output data of each row
    while ( $row = $result->fetch_assoc() )
    {
        foreach ( $row as $key => $value )
        {
            echo "$key: $value<br>";
        }
        echo '<hr>';
    }
} else {
    echo "0 results";
}
$conn->close();
?>