<?php
require_once '../lib/lib_project1.php';

redirectIfLoggedOut();

$username = getActingUsername( "You cannot access another user's information!" );

// See if user exists
try
{
    $user = $MEMBER_DB_MANAGER->loadMemberByUsername( $username );
}
catch( Exception $e )
{
    echo "Username: '$username' does not exist.";
    die();
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
    $errors = array();

    // Clean Data
    $_POST['first_name'] = clean_input( $_POST['first_name'] );
    $_POST['last_name'] = clean_input( $_POST['last_name'] );
    $_POST['email'] = clean_input( $_POST['email'] );
    $_POST['username'] = clean_input( $_POST['username'] );
    $_POST['password'] = clean_input( $_POST['password'] );
    $_POST['confirmPassword'] = clean_input( $_POST['confirmPassword'] );

    $userForm = new MemberForm( $_POST['username'], $_POST['password'], $_POST['confirmPassword'], 
                $_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['date_joined'],
                $_POST['last_online'], isset( $_POST['enabled'] ) );

    if ( empty( $_POST['confirmPassword'] ) )
    {
        $errors = SignUpFormValidator::validateRequiredFields( $userForm );

        if ( sha1( $userForm->getPassword() ) != $user->getPassword() &&
                    !$MEMBER_DB_MANAGER->isAdmin() )
        {
            $errors[] = "Wrong Password";
        }
    }
    else
    {
        $errors = array_merge( $errors, SignUpFormValidator::validateRequiredFields( $userForm ) );
    }

    if ( count( $errors ) == 0 )
    {
        // SUBMIT A CHANGE
        if ( empty( $_POST['confirmPassword'] ) )
        {
            // Get Authorities
            $auths = &$userForm->getAuthorities();
            $auths = array_keys( $_POST['auths'] );

            try
            {
                $MEMBER_DB_MANAGER->updateUser( $userForm );
            } catch ( InadequateRightsException $e )
            {
                die( $e->getMessage() );
            }
        }
        else
        {
            $MEMBER_DB_MANAGER->changePassword( $user->getPassword(), $userForm->getPassword(), $username );
        }

        header( 'Location: ./userDetails.php?' . $_SERVER['QUERY_STRING'] );
        die();
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
        array ( '../css/formStyle.css', '../css/detailsStyle.css' ), 
        array ( '../js/lib/jquery.tablesorter.js', '../js/lib/underscore-min.js', 
                        '../js/UserDetailsWidget.js' ) );
?>

<body>
    <?= templateHeader(true, true, false, true)?>
    <div id="content">
        <form method="POST">
            <div id="nice_tableBlock">
                <table id="detailsTable">
                    <tbody>
                        <tr id="usernameRow" class="permanent">
                            <td><label for="username">Username</label></td>
                            <td><input type="text" id="username" name="username"
                                /></td>
                        </tr>
                        <tr id="first_nameRow" <?= !$MEMBER_DB_MANAGER->getCurrentUser()->getUsername() == $username ?'class="permanent"':'' ?>>
                            <td><label for="first_name">First Name</label></td>
                            <td><input type="text" id="first_name" name="first_name"
                                /></td>
                        </tr>
                        <tr id="last_nameRow" <?= !$MEMBER_DB_MANAGER->getCurrentUser()->getUsername() == $username ?'class="permanent"':'' ?>>
                            <td><label for="last_name">Last Name</label></td>
                            <td><input type="text" id="last_name" name="last_name"
                                /></td>
                        </tr>
                        <tr id="emailRow" <?= !$MEMBER_DB_MANAGER->getCurrentUser()->getUsername() == $username ?'class="permanent"':'' ?>>
                            <td><label for="email">Email</label></td>
                            <td><input type="email" id="email" name="email"
                                /></td>
                        </tr>
                        <tr id="authoritiesRow" <?= $MEMBER_DB_MANAGER->isAdmin()?'':'class="permanent"' ?>>
                            <td><label for="authorites">Authorites</label></td>
                            <td>
                                <table id="authorities">
                                <?php
                                forEach ( $MEMBER_DB_MANAGER->getAvailableAuthorities() as $auth )
                                {
                                    echo "<td><input type='checkbox' name='auths[$auth]' value='$auth' id='authorities' auth='$auth' class='authBox' /></td>
                                          <td><label for='$auth'>$auth</label></td>";
                                }
                                ?>
                            </table>
                            </td>
                        </tr>
                        <tr id="enabledRow" <?= $MEMBER_DB_MANAGER->isAdmin()?'':'class="permanent"' ?>>
                            <td><label for="enabled">Enabled</label></td>
                            <td><input type="checkbox" id="enabled" name="enabled"
                                /></td>
                        </tr>
                        <tr id="dateJoinedRow" class="permanent">
                            <td><label for="date_joined">Date Joined</label></td>
                            <td><input type="datetime" id="date_joined" name="date_joined"
                                /></td>
                        </tr>
                        <tr id="lastOnlineRow" class="permanent">
                            <td><label for="last_online">Last Online</label></td>
                            <td><input type="datetime" id="last_online" name="last_online"
                                /></td>
                        </tr>
                        <?php
                        if ( $MEMBER_DB_MANAGER->isAdmin() || $MEMBER_DB_MANAGER->getCurrentUser()->getUsername() == $username )
                        {
                            echo <<< EOF
                            <tr id="passwordRow">
                                <td><label for="password">Password</label></td>
                                <td><input type="password" id="password" name="password"
                                    /></td>
                            </tr>
                            <tr id="confirmPasswordRow" style="display: none;">
                                <td><label for="confirmPassword">Confirm Password</label></td>
                                <td><input type="password" id="confirmPassword" name="confirmPassword"
                                    /></td>
                            </tr>
EOF;
                        }
                        
                        if ( isset( $message ) )
                        {
                            echo "
                            <tr>
                                <td colspan='2' style='color: red'><p>$message</p></td>
                            </tr>";
                        }
                        ?>
                        <tr id="buttonsRow" class="permanent">
                            <td><input type="button" id="changePasswordButton" name="password-submitted"
                                    value="Change Password"
                                >
                                </td>
                            <td><input type="submit" id="updateFieldsButton" name="submitted"
                                    value="Update With New Info"
                                >
                                </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
    <span id="user"><?= $username ?></span>

</body>

</html>
