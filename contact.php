<?php
if (isset($_POST['Email'])) {

    $email_to = "kontakt@arthurruckdeschel.de";
    $email_subject = "Websiteanfragen";

    function problem($error)
    {
        echo "Entschuldigung, anscheinend ist ein Fehler aufgetreten. ";
        echo "Folgende Fehler sind aufgetreten.<br><br>";
        echo $error . "<br><br>";
        echo "Bitte versuchen Sie es erneut.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Message'])
    ) {
        problem('Entschuldigung, aber es scheint ein Fehler mit Ihrem Inhalt zu bestehen.');
    }

    $name = $_POST['Name']; // required
    $email = $_POST['E-Mail']; // required
    $message = $_POST['Nachricht']; // required

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'Diese E-Mail scheint nicht echt zu sein.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'Ist das wirklich dein Name?<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'Spam ist gemein, bitte schreibe eine längere Nachricht!<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }

    $email_message = "Inhalt unten.\n\n";

    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }

    $email_message .= "Name: " . clean_string($name) . "\n";
    $email_message .= "Email: " . clean_string($email) . "\n";
    $email_message .= "Nachricht: " . clean_string($message) . "\n";

    // create email headers
    $headers = 'Von: ' . $email . "\r\n" .
        'An: ' . $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- SUCCESS MESSAGE BELOW -->

    Danke für deine Nachricht! Ich werde mich schnellstmöglich zurückmelden!

<?php
}
?>