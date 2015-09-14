<?php

require_once('_global.php');

$form = new \Sirius\FormExamples\Form\Contact;
$formRenderer = new \Sirius\FormRenderer\Renderer();
$formRenderer->addDecorator(new \Sirius\FormExamples\FormRenderer\Decorator\Bootstrap());
$formRenderer->addDecorator(new \Sirius\FormExamples\FormRenderer\Decorator\ClientSideValidation());

// you should do this in your controller

if ($_POST) {
    $form->populate($_POST);
    $form->isValid();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://cdn.jsdelivr.net/jquery.validation/1.14.0/jquery.validate.js"></script>
</head>
<body>

<div class="container">

    <h1>Contact form with client side validation</h1>
<?php
echo $formRenderer->render($form)->render();
?>
</div>

</body>
</html>

