<?php
require_once 'lib/lib_homework2.php';

$username = $_GET['username'];

$user = $DBMANAGER->loadMemberByUsername( $username );

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    // DELETE A NUMBER
    if ( $_POST['deleteNumber'] )
    {
        $id = $_POST['phone_number'];
        
        foreach ( $user->getNumbers() as $number )
        {
            if ( $number->id == $id )
            {
                $phoneNumber = $number;
                break;
            }
        }
        
        if ( $phoneNumber == null )
        {
            $errors[] = "No Phone number chosen to delete.";
        } else
        {
            $DBMANAGER->deletePhoneNumber( $username, $phoneNumber );
            
            header( 'Location: ./userDetails.php?' . $_SERVER['QUERY_STRING'] );
            die();
        }
    }
    
    // SUBMIT A CHANGE
    if ( $_POST['submitted'] )
    {
        $id = $_POST['phone_number'];
        
        // Clean Data
        $_POST['username'] = clean_input( $_POST['username'] );
        $_POST['first_name'] = clean_input( $_POST['first_name'] );
        $_POST['last_name'] = clean_input( $_POST['last_name'] );
        $_POST["type$id"] = clean_input( $_POST["type$id"] );
        $_POST["area_code$id"] = preg_replace( '/[-]*|[^0-9]*/', '', 
                clean_input( $_POST["area_code$id"] ) );
        $_POST["number$id"] = preg_replace( '/[-]*|[^0-9]*/', '', 
                clean_input( $_POST["number$id"] ) );
        
        $userForm = new MemberForm( $_POST['username'], $_POST['first_name'], $_POST['last_name'], 
                $_POST["type$id"], $_POST["area_code$id"], $_POST["number$id"], $id );
        
        $errors = SignUpFormValidator::validateMember( $userForm );
        
        // See if user exists
        try
        {
            if ( !$DBMANAGER->loadMemberByUsername( $userForm->getUsername() ) )
            {
                $errors[] .= sprintf( 'Username \'%s\' doesn\'t exist!', 
                        $userForm->getUsername() );
            }
        } catch ( Exception $e )
        {
        }
        
        if ( count( $errors ) == 0 || $id == null )
        {
            if ( $id == -1 )
            {
                $DBMANAGER->createPhoneNumber( $userForm->getUsername(), $userForm->getAreaCode(), 
                        $userForm->getNumber(), $userForm->getType() );
            } else if ( $id != null )
            {
                $numbers = $userForm->getNumbers();
                $DBMANAGER->updatePhoneNumber( $numbers[0] );
            }
            echo 'hey';
            
            $DBMANAGER->updateUser( $userForm );

            header( 'Location: ./userDetails.php?' . $_SERVER['QUERY_STRING'] );
            die();
        }
    }
    
    foreach ( $errors as $error )
    {
        $message .= "<p>$error</p>";
    }
}

?>

<!DOCTYPE HTML>
<html lang="EN">

<?php
echo templateHead( "$username's Details", 
        array ( 'css/formStyle.css', 'css/userDetailsStyle.css' ), 
        array ( 'js/lib/jquery.tablesorter.js', 'js/lib/underscore-min.js', 
                        'js/UserDetailsWidget.js' ) );
?>

<body>
    <?= templateHeader()?>
    <div id="content">
        <form method="POST">
            <div id="user_tableBlock">
                <table id="detailsTable">
                    <tbody>
                        <tr id="usernameRow" class="permanent">
                            <td><label for="username">Username</label></td>
                            <td><input type="text" id="username" name="username"
                                    value="<?= $user->getUsername()?>"
                                /></td>
                        </tr>
                        <tr id="first_nameRow">
                            <td><label for="first_name">First Name</label></td>
                            <td><input type="text" id="first_name" name="first_name"
                                    value="<?= $user->getFirstName()?>"
                                /></td>
                        </tr>
                        <tr id="last_nameRow">
                            <td><label for="last_name">Last Name</label></td>
                            <td><input type="text" id="last_name" name="last_name"
                                    value="<?= $user->getLastName()?>"
                                /></td>
                        </tr>
                        <tr id="phone_numbersRow">
                            <td><label for="phone_numbers">Phone Numbers</label></td>
                            <td>
                                <table id="phone_numbers">
                                <?php
                                if ( count( $user->getNumbers() ) > 0 )
                                {
                                    forEach ( $user->getNumbers() as $number )
                                    {
                                        $htmlPhone = "<tr>";
                                        $htmlPhone .= "<td><input type=\"radio\" name=\"phone_number\" value=\"$number->id\" id=\"phone_numbers\" number_id=\"$number->id\" class=\"phoneNumberBox\" /></td>";
                                        $htmlPhone .= "<td>";
                                        
                                        $htmlPhone .= "<span class='phone_type phone'>";
                                        $htmlPhone .= "<select id='type' name='type$number->id'>";
                                        $htmlPhone .= "<option value='home'";
                                        $htmlPhone .= ( $number->type == "home" ) ? " selected" : "";
                                        $htmlPhone .= ">home</option>";
                                        $htmlPhone .= "<option value='office'";
                                        $htmlPhone .= ( $number->type == "office" ) ? " selected" : "";
                                        $htmlPhone .= ">office</option>";
                                        $htmlPhone .= "<option value='cell'";
                                        $htmlPhone .= ( $number->type == "cell" ) ? " selected" : "";
                                        $htmlPhone .= ">cell</option>";
                                        $htmlPhone .= "<option value='other'";
                                        $htmlPhone .= ( $number->type == "other" ) ? " selected" : "";
                                        $htmlPhone .= ">other</option>";
                                        $htmlPhone .= "</select> </span>";
                                        
                                        $htmlPhone .= "<input class='phone_area_code phone' name='area_code$number->id' value=\"(" .
                                                 $number->area_code . ")\">";
                                        $htmlPhone .= "<input class='phone_number phone' name='number$number->id' value=\"" .
                                                 preg_replace( '/(\d{3})(\d{4})/', "$1-$2", 
                                                        $number->number ) . "\">";
                                        $htmlPhone .= "</td></tr>";
                                        
                                        echo $htmlPhone;
                                    }
                                }
                                ?>
                            </table>
                            </td>
                        </tr>
                        <?php
                        
                        if ( isset( $message ) )
                        {
                            echo <<< EOF
                            <tr>
                                <td colspan="2" style="color: red"><p>$message</p></td>
                            </tr>
EOF;
                        }
                        ?>
                        <tr id="buttonsRow" class="permanent">
                            <td><input type="button" id="doneButton" value="Done"
                                    onclick="window.location='./'"
                                ></td>
                            <td><input type="button" id="addNumberButton" value="Add a Phone Number">
                                <input type="button" id="deleteNumberButton" name="deleteNumber"
                                    value="Delete a Phone Number"
                                > <input type="submit" id="updateFieldsButton" name="submitted"
                                    value="Update With New Info"
                                ></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <span id="user"><?= $username ?></span>

</body>

</html>
