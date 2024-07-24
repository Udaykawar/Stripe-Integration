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

            // Return success response
            echo json_encode(['status' => $paymentIntent->status, 'client_secret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            // Return error response
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
