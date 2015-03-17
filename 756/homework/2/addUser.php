<?php
require 'lib/lib_homework2.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['submitted'])
{
    // Clean Data
    $_POST['username'] = clean_input( $_POST['username'] );
    $_POST['first_name'] = clean_input( $_POST['first_name'] );
    $_POST['last_name'] = clean_input( $_POST['last_name'] );
    $_POST['type'] = clean_input( $_POST['type'] );
    $_POST['area_code'] = preg_replace('/[-]*|[^0-9]*/', '', clean_input( $_POST['area_code'] ) );
    $_POST['number'] = preg_replace('/[-]*|[^0-9]*/', '', clean_input( $_POST['number'] ) );

    $user = new MemberForm( $_POST['username'], $_POST['first_name'], $_POST['last_name'],
        $_POST['type'], $_POST['area_code'], $_POST['number'] );
    
    $errors = SignUpFormValidator::validateMember( $user );
    
    // See if user is unique
    try
    {
        if ($DBMANAGER->loadMemberByUsername( $user->getUsername() ))
        {
            $errors[] .= sprintf( 'Username \'%s\' already exists!', $user->getUsername() );
        }
    } catch ( Exception $e )
    {
    }
    
    if (count( $errors ) == 0)
    {
        /* Process new user */
        $DBMANAGER->createUser( $user );

        header( 'Location: ./' );
        die();
    }
}

?>

<!DOCTYPE HTML>
<html lang='EN'>

<?php
echo templateHead( 'Add User', array ( 'css/formStyle.css' ), array ( 'js/SignupWidget.js' ) );
?>

<body>

    <?= templateHeader( false )?>
    <div id='content'>
        <form id='signupForm' method='POST'>
            <?= $feedback?>
            <?php if(count($errors)>0) {foreach ($errors as $error){printf("<p class='error'><span>%s</span></p>", $error);}} ?>
                
            <p>
                <label for='username'>Username:</label>
                <input id='username' type='text' maxlength='16' name='username'
                    placeholder='username'
                    <?= (isset($_POST['username']))? 'value="' . $_POST['username'] . '"':''?>
                />
            </p>
            <p>
                <label for='first_name'>First Name:</label>
                <input id='first_name' type='text' name='first_name' placeholder='Your first name'
                    <?= (isset($_POST['first_name']))? 'value="' . $_POST['first_name'] . '"':''?>
                />
            </p>
            <p>
                <label for='last_name'>Last Name:</label>
                <input id='last_name' type='text' name='last_name' placeholder='Your last name'
                    <?= (isset($_POST['last_name']))? 'value="' . $_POST['last_name'] . '"':''?>
                />
            </p>
            <p>
                <label for='area_code'>Area Code:</label>
                <input id='area_code' type='tel' name='area_code' placeholder='Area code'
                    <?= (isset($_POST['area_code']))? 'value="' . $_POST['area_code'] . '"':''?>
                />
            </p>
            <p>
                <label for='number'>Phone Number:</label>
                <input id='number' type='tel' name='number' placeholder='Phone Number'
                    <?= (isset($_POST['number']))? 'value="' . $_POST['number'] . '"':''?>
                />
            </p>
            <p>
                <label for='type'>Phone Number:</label>
                <select id='type' name='type'>
                    <option value="home">home</option>
                    <option value="office">office</option>
                    <option value="cell">cell</option>
                    <option value="other">other</option>
                </select>
            </p>
            <div id='formButtons'>
                <p>
                    <input type='submit' value='Sign Up' name='submitted' />
                    <input type='reset' value='Clear'
                        onclick="$('#signupForm input[type=text], #signupForm input[type=email], #signupForm input[type=password]').val('')"
                    />
                </p>
                <p>
                    <input type='button' value='Nevermind'
                        onclick="window.location='./'"
                    />
                </p>
            </div>
        </form>

    </div>
</body>

</html>