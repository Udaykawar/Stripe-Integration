<?php

require_once __DIR__ . '/../controllers/PaymentController.php';
require_once __DIR__ . '/../setup.php';

// Instance Of Payment Controller
$controller = new PaymentController();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->createPaymentIntent();
} else {
    
    include __DIR__ . '/../views/form.php';
}
?>