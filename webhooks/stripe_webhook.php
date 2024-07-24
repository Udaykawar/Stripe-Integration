<?php

require __DIR__ . '/../vendor/autoload.php';

// Your Stripe secret key
$stripe = new \Stripe\StripeClient('sk_test_51Pg16rGo38VCWMIgdKnmyyVb6IYJUaBdXuOhd8vWkseDzVbvrDzsIQIrBbfHaSNdh1qHWJD1h4G6LaEbf7AKJ20Y00oxFa8XSP');

// Your Stripe CLI webhook secret for testing
$endpoint_secret = 'whsec_8682d15b4880038cefc2cd7c10e6e322fbfdad4a34c7b5349dd66e49c130d2db';

// Debugging: Log incoming headers and payload
error_log("Headers: " . print_r(getallheaders(), true));
error_log("Payload: " . file_get_contents('php://input'));

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? null; // Use null coalescing operator
$event = null;

if (!$sig_header) {
    http_response_code(400);
    error_log("HTTP_STRIPE_SIGNATURE header is missing.");
    exit("HTTP_STRIPE_SIGNATURE header is missing.");
}

try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    echo "Invalid payload: " . $e->getMessage();
    exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    echo "Invalid signature: " . $e->getMessage();
    exit();
}

// Handle the event
switch ($event->type) {
    case 'payment_intent.succeeded':
        $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
        // Debugging: Output payment details
        error_log("PaymentIntent succeeded: " . print_r($paymentIntent, true));

        // Update the payment status in the database
        updatePaymentStatus($paymentIntent->id, $paymentIntent->status, $paymentIntent->amount_received);
        break;

    // Other event types can be handled here
    default:
        echo 'Received unknown event type ' . $event->type;
}

// Respond to Stripe that the webhook was received successfully
http_response_code(200);

// Function to update the payment status in the database
function updatePaymentStatus($paymentIntentId, $status, $amount)
{
    // Debugging: Log function call
    error_log("Updating payment status for $paymentIntentId: status = $status, amount = $amount");

    // Database connection
    $conn = new mysqli('localhost', 'root', 'root', 'stripe_integration');

    // Check connection
    if ($conn->connect_error) {
        error_log("Database connection failed: " . $conn->connect_error);
        die("Connection failed: " . $conn->connect_error);
    }

    // Ensure payment_intent_id exists in your table structure
    $stmt = $conn->prepare("INSERT INTO payments (payment_intent_id, status, amount) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status = ?, amount = ?");
    if ($stmt === false) {
        error_log("Prepare failed: " . $conn->error);
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ssiss", $paymentIntentId, $status, $amount, $status, $amount);
    if (!$stmt->execute()) {
        // Output SQL errors for debugging
        error_log("Execute failed: " . $stmt->error);
    }
    $stmt->close();
    $conn->close();
}
?>
