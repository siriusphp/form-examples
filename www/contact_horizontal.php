<?php

require_once('_global.php');

$form = new \Sirius\FormExamples\Form\Contact;
// this is needed because the default error message class cannot be "inspected" (ie: access its properties)
$form->getValidator()->setErrorMessagePrototype(new \Sirius\FormExamples\Validation\ErrorMessage());

$formRenderer = new \Sirius\FormRenderer\Renderer([
    'language' => 'fr'
]);
$formRenderer->addDecorator(new \Sirius\FormExamples\FormRenderer\Decorator\Bootstrap());
$formRenderer->addDecorator(new \Sirius\FormExamples\FormRenderer\Decorator\HorizontalForm());

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
</head>
<body>

<div class="container">

    <h1>Contact form, styled horizontally via decorators</h1>
<?php

echo $formRenderer->render($form)->render();


?>
</div>

</body>
</html>

