<?php

// Only process POST reqeusts.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form fields and remove whitespace.
    $name      = strip_tags(trim($_POST["name"]));
    $name      = str_replace(array("\r", "\n"), array(" ", " "), $name);
    $email     = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message   = trim($_POST["your-message"]);
    $direccion = trim($_POST["address"]);
    $telefono  = trim($_POST["phone"]);

    // Check that data was sent to the mailer.
    if (empty($name) or empty($message) or !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Set a 400 (bad request) response code and exit.
        http_response_code(400);
        echo "Porfavor complete el formulario y pruebe nuevamente.";
        exit;
    }

    // Set the recipient email address.
    // FIXME: Update this to your desired email address.
    $recipient = "eisla@agricolaelalamo.com";

    // Set the email subject.
    $subject = "Nuevo contacto (Trabaja con nosotros) de $name";

    // Build the email content.
    $email_content = "Nombre: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Teléfono: $telefono\n\n";
    $email_content .= "Dirección: $address\n\n";
    $email_content .= "Asunto: $subject\n\n";
    $email_content .= "Mensaje:\n$message\n";

    // Build the email headers.
    $email_headers = 'From: ' . $name . ' - <' . $email . '>' . "\r\n";

    // Send the email.
    if (mail($recipient, $subject, $email_content, $email_headers)) {
        // Set a 200 (okay) response code.
        http_response_code(200);
        echo "Gracias! el mensaje se envio correctamente.";

        echo "<script language=Javascript> location.href=\"http://www.agricolaelalamo.com/web2018/trabajaconnosotros.html\"; </script>";
    } else {
        // Set a 500 (internal server error) response code.
        http_response_code(500);
        echo "Oops! Ocurrio un problema al enviar el mensaje.";

    }

} else {
    // Not a POST request, set a 403 (forbidden) response code.
    http_response_code(403);
    echo "Ocurrio un problema, pruebe nuevamente :( .";
}
