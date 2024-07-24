<?php

require_once __DIR__ . '/../helpers/Database.php';

class PaymentModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function savePayment($paymentIntentId, $amount, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO payments (payment_intent_id, amount, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $paymentIntentId, $amount, $status);
        return $stmt->execute();
    }

    public function updatePaymentStatus($paymentIntentId, $status)
    {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("UPDATE payments SET status = ? WHERE payment_intent_id = ?");
        $stmt->bind_param("ss", $status, $paymentIntentId);
        return $stmt->execute();
    }
}

?>
