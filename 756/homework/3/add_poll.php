<?php
define( 'PASSWORD', 'pass' );

function error_check( &$data, $error )
{
    global $errors;
    
    $data = trim( $data );
    $data = stripslashes( $data );
    // $data = htmlspecialchars( $data );
    if ( !isset( $data ) || ( empty( $data ) && !is_numeric( $data ) ) )  
    {
        $errors[] = $error;
    }
    return $data;
}

function delimiter_check( &$data, $delimiter, $error )
{
    global $errors;

    if ( strpos( $data, $delimiter ) )
    {
        $errors[] = $error;
    }
    return $data;
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    
    $errors = array ();
    
    $cat = error_check( $_POST['cat'], 'Need a Topic Category' );
    delimiter_check( $cat, '|', 'Topic cannot contain a | (pipe)' );
    $question = error_check( $_POST['question'], 'Need a Question' );
    delimiter_check( $question, '|', 'Question cannot contain a | (pipe)' );
    
    $answers = array ();
    error_check( $_POST['choice1'], 'Need at least 1 choice' );
    
    $i = 0;
    while ( isset( $_POST['choice' . ++$i] ) )
    {
        if ( !empty( $_POST["choice$i"] ) || is_numeric( $_POST["choice$i"] ) )
        {
            $answer = error_check( $_POST["choice$i"], "Choice $i has errors." );
            delimiter_check( $answer, ';', "Choice $i cannot contain a ; (semicolon)" );
            $answers[] = $answer;
        }
    }
    
    if ( !isset( $_POST['password'] ) || PASSWORD != $_POST['password'] )
    {
        $errors[] = 'Wrong Password';
    }
    
    // SUCCESS
    if ( count( $errors ) <= 0 )
    {
        $answers_str = implode( ';', $answers );
        $topic_str = implode( '|', array ( $cat, $question, $answers_str ) ) . "\n";
        
        file_put_contents( 'poll_data.txt', $topic_str, FILE_APPEND | LOCK_EX );
        
        header( 'Location: ./choose_a_poll.php' );
        die();
    }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Add a poll</title>
<script src='//code.jquery.com/jquery-2.1.3.min.js'></script>
<script src='ChoiceWidget.js'></script>
</head>
<body>
<?php if ( count($errors)> 0 ){ foreach ( $errors as $error ) { echo "$error<br>"; } die(); }?>

    <h1>Add a Poll</h1>
    <form action="./add_poll.php" method="POST">
        <table>
            <tr>
                <td>Topic Category</td>
                <td><input type="text" name="cat" size="10" /></td>
            </tr>
            <tr>
                <td>Topic Question</td>
                <td><input type="text" name="question" size="50" /></td>
            </tr>

            <tr>
                <td>Choice 1</td>
                <td><input type="text" name="choice1" size="15" /></td>
            </tr>

            <tr>
                <td>Choice 2</td>
                <td><input type="text" name="choice2" size="15" /></td>
            </tr>

            <tr>
                <td>Choice 3</td>
                <td><input type="text" name="choice3" size="15" /></td>
            </tr>

            <tr>
                <td>Choice 4</td>
                <td><input type="text" name="choice4" size="15" /></td>
            </tr>

            <tr>
                <td>Choice 5</td>
                <td><input type="text" name="choice5" size="15" /></td>
            </tr>
        </table>
        <hr />
        <strong>Your Password: </strong>
        <input type="password" name="password" size="15" />
        <br />
        <input type="reset" value="Reset Form" />
        <input type="submit" name="submit" value="Submit Form" />

    </form>

    <p></p>
    <h3>
        <a href="choose_a_poll.php">Choose a Poll</a>
    </h3>
</body>
</html>