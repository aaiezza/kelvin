<?php
require '/home/axa9070/etc/db_conn.php';

$mysql1 = new mysqli( $hostname, $username, $password, $database );

// CHECK FOR VALID CONNECTION!
if ($mysql1->connect_error)
{
    printf( 'Connect failed: %s', $mysql1->connect_error );
    exit( 1 );
}

?>

<!DOCTYPE HTML>

<html lang="EN">
<head>
<meta charset="UTF-8">

<title>Class Fun!</title>
<meta name="description" content="basic">
<meta name="author" content="Alex Aiezza">

<link rel="stylesheet" href="css/template.css">

<link rel="icon" type="image/ico" href="images/favicon.ico">

<script src='https://code.jquery.com/jquery-2.1.3.min.js'></script>
<script src="js/template.js"></script>
</head>

<body>
    <div id="content">
        <h2>Peeps</h2>


        <?php $query = 'INSERT INTO People ( first, last, nick ) VALUES ( ?, ?, ? )';?>
        
        <h4>INSERT Query "<?= $query?>"</h4>    
        <?php
        // Query for dem folks
        if ($stmt = $mysql1->prepare( $query ))
        {
            $stmt->bind_param( 'sss', $fn, $ln, $nn );
            
            $fn = 'Alessandro';
            $ln = 'Aiezza';
            $nn = 'Al';
            
            $stmt->execute();
            $stmt->store_result();
        }
        
        ?>
        <p>
        
        
        <pre><?= sprintf( "%d Row inserted.\nInsert ID: %d", $stmt->affected_rows, $insert_id = $stmt->insert_id ) ?></pre>
        <?php $stmt->close();?>
        </p>

        <?php $query = 'UPDATE People SET nick = ? WHERE id = ?';?>

        <h4>UPDATE Query "<?= $query?>"</h4>    
        <?php
        // Query for dem folks
        if ($stmt = $mysql1->prepare( $query ))
        {
            $stmt->bind_param( 'ss', $nn, $id );
            
            $nn = 'Alex';
            $id = $insert_id;
            
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->affected_rows;
            
            printf( '<p>You updated %d rows!</p>', $num_rows );
        }
        
        ?>
        <p>
        
        
        <pre><?= sprintf("%d Row inserted.\n", $stmt->affected_rows) ?></pre>
        <?php $stmt->close();?>
        </p>
        
        <?php
        // Query for dem folks
        $query = 'SELECT * FROM People';
        
        ?>
        <h4>SELECT Query "<?= $query?>"</h4>
        <?php
        $stmt = $mysql1->prepare( $query );
        
        $stmt->execute();
        $stmt->store_result();
        
        $num_rows = $stmt->num_rows;
        
        if ($num_rows > 0)
        {
            printf( '<h4>Records Found: %d</h4>', $num_rows );
            
            echo '<table><thead><tr><th>Id</th><th>First Name</th><th>Last Name</th><th>Nick Name</th></tr></thead>';
            
            $stmt->bind_result( $id, $first, $last, $nick );
            
            // now get the records
            while ( $stmt->fetch() )
            {
                printf( '<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>', $id, $first, 
                        $last, $nick );
            }
            
            echo '</table>';
        }
        
        $stmt->close();
        
        ?>

    </div>
</body>

<?php
// close connection
$mysqli->close();
?>

</html>