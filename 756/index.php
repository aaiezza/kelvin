<?php
// define variables and set to empty values
$name = $email = $comments = "";

// Form Processing
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset ( $_POST["contact-submit"] ) )
{
    $name = clean_input ( $_POST["contact-name"] );
    $email = clean_input ( $_POST["contact-email"] );
    $comments = clean_input ( $_POST["contact-comments"] );
    
    $errors = array ();
    
    if (empty ( $name ) && !is_numeric ( $name ))
    {
        $errors[] = "Name is invalid.";
    }
    
    if (empty ( $email ) && !is_numeric ( $email ))
    {
        $errors[] = "Email is invalid.";
    }
    
    if (empty ( $comments ) && !is_numeric ( $comments ))
    {
        $errors[] = "Comment is invalid.";
    }
    
    if (count ( $errors ) == 0)
    {
        // foreach : designed for maps!
        foreach ( $_POST as $key => $value )
        {
            $message .= $key . " : " . $value . "\n";
        }
        
        if (mail ( "axa9070@rit.edu", "PHP 101 EMAIL", $message, "Cc: {$email}" ))
        {
            $feedback = "Form was successfully submitted.";
        } else
        {
            $feedback = "There was an error submitting the form.";
        }
    }
}
function clean_input( $data )
{
    $data = trim ( $data );
    $data = stripslashes ( $data );
    $data = htmlspecialchars ( $data );
    return $data;
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='utf-8' />
<meta name="description" content="756 Homepage">
<meta name="author" content="Alex Aiezza">
<title>ISTE-756 Homepage</title>

<link rel='stylesheet' type='text/css' href='css/mainStyle.css' />
<link rel='stylesheet' type='text/css' href='css/lib/perfect-scrollbar.min.css' />
<link rel='stylesheet' type='text/css'
    href='css/theme/<?= isset($_GET["theme"])?$_GET["theme"]:"dnax"?>.css' id='theme'
/>
<link rel='stylesheet' type='text/css' href='css/lib/jquery-ui.css' />

<link rel="icon" type="image/ico" href="images/favicon.ico">

<script type='text/javascript' src='//code.jquery.com/jquery-2.1.3.min.js'></script>
<script type='text/javascript' src='//code.jquery.com/ui/1.11.3/jquery-ui.min.js'></script>
<script type='text/javascript' src='js/lib/url-util.js'></script>
<script type='text/javascript' src='js/ThemeWidget.js'></script>
<script type='text/javascript' src='js/Main.js'></script>
</head>
<body>
    <div id='content'>
        <div class='leftPane'>
            <div id='pictureBlock'>
                <a class='shadow'><img id='myPicture' src='images/alexAndDave.jpg' alt='Alex Aiezza' /></a>
            </div>
            <?= file_get_contents('./panes/work.html'); ?>
        </div>

        <div id='info' class='rightPane'>
            <h2 id='courseTitle'>ISTE-756 Server Design &amp; Development</h2>

            <h3 id='myName'>Alessandro Aiezza II</h3>
            <div id='contactInfo'>
                <p>axa9070 [at] rit [dot] edu</p>
                
                <?= $feedback?>
                <?php if(count($errors)>0) {foreach ($errors as $error){printf("<p class='error'><span>%s</span></p>", $error);}} ?>
                <!-- Current page is the default action -->
            </div>


            <div id="formBlock">
                <h3>Contact Me</h3>
                <div>
                    <!-- \<\?= \?\> is SHORT TAG! The equals sign is echo -->
                    <form method="post" <?= !empty($feedback)? 'class="hidden"':""?>>
                        <p>
                            <label for="contact-name">Name:</label>
                            <input id="contact-name" name="contact-name" type="text"
                                <?= (isset($name))?"value=\"$name\"":''?>
                            />
                        </p>
                        <p>
                            <label for="contact-email">Email:</label>
                            <input id="contact-email" name="contact-email" type="email"
                                <?= (isset($email))?"value=\"$email\"":''?>
                            />
                        </p>
                        <p>
                            <label for="contact-comments">Comments:</label>
                            <textarea id="contact-comments" name="contact-comments"><?= (isset($comments))?$comments:''?></textarea>
                        </p>
                        <p>
                            <input type="submit" name="contact-submit" value="Send" />
                        </p>
                        <p>
                            <input type="reset" name="contact-submit" value="Clear"
                                onclick="$('input[type=email],input[type=text],textarea').attr('value',null).html('');"
                            />
                        </p>
                    </form>
                    <?= !empty($feedback)? "<p>Check your email ^_^</p>":""?>
                </div>
            </div>


            <hr style="margin-top: 4px;">
            <?= file_get_contents('./panes/aboutMe.html'); ?>
        </div>
    </div>
</body>
</html>