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
<link rel='stylesheet' type='text/css' href='css/libs/perfect-scrollbar.min.css' />
<link rel='stylesheet' type='text/css'
    href='css/theme/<?= isset($_GET["theme"])?$_GET["theme"]:"dnax"?>.css' id='theme'
/>
<link rel='stylesheet' type='text/css' href='css/libs/jquery-ui.css' />

<link rel="icon" type="image/ico" href="images/favicon.ico">

<script type='text/javascript' src='//code.jquery.com/jquery-2.1.3.min.js'></script>
<script type='text/javascript' src='//code.jquery.com/ui/1.11.3/jquery-ui.min.js'></script>
<script type='text/javascript' src='js/libs/url-util.js'></script>
<script type='text/javascript' src='js/ThemeWidget.js'></script>
<script type='text/javascript' src='js/Main.js'></script>
</head>
<body>
    <div id='content'>
        <div class='leftPane'>
            <div id='pictureBlock'>
                <a class='shadow'><img id='myPicture' src='images/alexAndDave.jpg' alt='Alex Aiezza' /></a>
            </div>
            <div id='work'>
                <h4>Homeworks</h4>
                <ul>
                    <li><a href="homework/1">Homework 1</a></li>
                    <li><a href="homework/2">Homework 2</a></li>
                    <li><a href="homework/3/choose_a_poll.php">Homework 3</a></li>
                    <li>Homework 4</li>
                    <li>...</li>
                </ul>
                <h4>ICEs</h4>
                <ul>
                    <li><a href="week/1">ICE 1</a></li>
                    <li><a href="week/2">ICE 2</a></li>
                    <li><a href="week/3/session1.php">ICE 3</a></li>
                    <li><a href="week/4">ICE 4</a></li>
                    <li><a href="week/5/file_demo.php">ICE 5</a></li>
                    <li><a href="week/6">ICE 6</a></li>
                    <li>ICE 7</li>
                    <li>...</li>
                </ul>
                <h4>Projects</h4>
                <ul>
                    <li><a href="project1">Individual Project 1</a></li>
                    <li>Individual Project 2</li>
                    <li>Group Project 1</li>
                    <li>Group Project 2</li>
                </ul>
            </div>
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
            <div id='aboutMe'>
                <!-- Click my face to go to space!!! -->
                <p>
                    Though my full first name is Alessandro, I'm better known as Alex. I was born <a
                        href="http://en.wikipedia.org/wiki/August_31"
                    >August 31, 1991</a> and raised in <a href="https://goo.gl/maps/AXfbN">Rochester,
                        NY</a>.
                </p>
                <!-- <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d11643.192906080374!2d-77.69519305390142!3d43.15076616010746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0x104a0a20ab5e3211!2sTown+of+Gates!5e0!3m2!1sen!2sus!4v1422905122500"
                    width="600" height="450" frameborder="0" style="border: 0"
                ></iframe> -->
                <p>
                    I'm a first year grad student here at RIT. My undergrad and current major is <a
                        href="http://www.rit.edu/cos/bioinformatics/about.html"
                    >Bioinformatics</a>. Bioinformatics utilizes today's technological resources to
                    solve many problems in the fields of <a
                        href="http://en.wikipedia.org/wiki/Biology"
                    >Biology</a>, <a href="http://en.wikipedia.org/wiki/Genomics">Genomics</a>, <a
                        href="http://en.wikipedia.org/wiki/Transcriptome"
                    >Transcriptomics</a>, <a href="http://en.wikipedia.org/wiki/Proteomics">Proteomics</a>
                    and <a href="http://en.wikipedia.org/wiki/Pharmacogenomics">Pharmacogenomics</a>
                    (Thus the DNA strand in the background).

                </p>
                <p>
                    Currently, I work as a freelance developer where I work to develop random web
                    applications like this <a href="http://french-resistance.servegame.com/resist">one</a>
                    and experiment with the latest and greatest web dev technologies like <a
                        href="http://projects.spring.io/spring-framework/"
                    >Spring IO</a> and <a href="http://jmesnil.net/stomp-websocket/doc/">web sockets</a>.
                </p>
                <p>The fellows you see in the photo are myself [on the left] and also, my
                    cousin/good friend Dave Scribani. I thought he'd find it funny I used a picture
                    with him in it for this assignment.</p>
                <p>
                    In my down time, you can find me at <a href="https://www.bristolmountain.com/">Bristol
                        Mountain</a> snowboarding, at my home church The Father's House (<a
                        href="http://www.tfhny.org/"
                    >TFHNY</a>) or at my home in North Chili, NY with my beautiful wife Kristina
                    Aiezza reading <a href="http://xkcd.com">xkcd</a> comics.
                </p>
            </div>
        </div>

    </div>
</body>
</html>