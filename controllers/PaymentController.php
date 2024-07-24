<?php

require_once __DIR__ . '/../helpers/Database.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController
{
    private $db;
    private $config;

    public function __construct()
    {
        $this->db = new Database();
        $this->config = require __DIR__ . '/../config/config.php';
        
        // Set Stripe API key from config
        Stripe::setApiKey($this->config['stripe']['secret_key']);
        
    }

    public function createPaymentIntent()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $paymentMethodId = $input['payment_method'];
        $amount = 100;

        try {
            // Create PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'payment_method' => $paymentMethodId,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);

            // // Update payment status in the database
            // $this->updatePaymentStatus($paymentIntent->id, $paymentIntent->status, $amount);

            // Return success response
            echo json_encode(['status' => $paymentIntent->status, 'client_secret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            // Return error response
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // private function updatePaymentStatus($paymentIntentId, $status, $amount)
    // {
    //     $conn = $this->db->getConnection();
    //     // Ensure payment_intent_id exists in your table structure
    //     $stmt = $conn->prepare("INSERT INTO payments (payment_intent_id, status, amount) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status = ?, amount = ?");
    //     $stmt->bind_param("ssiss", $paymentIntentId, $status, $amount, $status, $amount);
    //     if (!$stmt->execute()) {
    //         // Output SQL errors for debugging
    //         echo "Error: " . $stmt->error;
    //     }
    //     $stmt->close();
    // }
}
?>
