# Stripe Integration Module

This repository contains a Stripe integration module for handling payments. Follow the instructions below to set up and run the module.

## Prerequisites

- PHP 7.4 or higher
- Composer
- MySQL or MariaDB

## Setup Instructions

### 1. Set Up a Stripe Account

1. **Create a Stripe Account**

   - Go to [Stripe's website](https://stripe.com) and sign up for a new account if you don’t already have one.

2. **Obtain Your Stripe API Keys**

   - After logging in, go to the [Stripe Dashboard](https://dashboard.stripe.com/).
   - Navigate to the **Developers** section on the left sidebar, then click on **API keys**.
   - You will find your **Publishable key** and **Secret key** under the **Standard Keys** section.
   - Make a note of these keys as you will need to add them to your configuration file.
     
### 2. Clone the Repository

Clone the repository from GitHub:

```bash
git clone https://github.com/Udaykawar/stripe-integration.git
cd stripe-integration
```
### 3.  Install Dependencies
Ensure you have Composer installed. Run the following command to install the required PHP libraries:

```bash
composer install
```
This command will read the composer.json file in your project and download the necessary libraries into the vendor directory.

### 4. Configure Database and Stripe Keys
Update config.php with your database and Stripe keys:

```bash
<?php
return [
    'database' => [
        'host' => 'localhost',
        'user' => 'your-db-username',
        'password' => 'your-db-password',
        'name' => 'your-database-name',
    ],
    'stripe' => [
        'publishable_key' => 'your-publishable-key',
        'secret_key' => 'your-secret-key',
        'webhook_secret' => 'your-webhook-secret',
    ],
];
```
Ensure your Stripe keys and database credentials are correctly entered.

### 4. Set Up the Database
1. **Run setup.ph**
Navigate to the root directory of your project and execute setup.php to automatically create the database and required tables:

```bash
php setup.php
```
### 5. Configure Stripe CLI for Local Webhook
1. Install Stripe CLI: Download and install the Stripe CLI if you haven't already.
2.Login to Stripe CLI: Authenticate your CLI with Stripe by running:

```bash
stripe login
```
3.Set Up Webhook Endpoint: Use the Stripe CLI to forward events to your local server.

```bash
stripe listen --forward-to localhost:80/stripe-integration/webhooks/stripe_webhook.php
```
### 6. Run the Project
1.Start Your Local Server: Make sure your local server (e.g., XAMPP) is running.
2.Access the Payment Form: Open your browser and navigate to the payment form URL (e.g., http://localhost/stripe-integration/public/index.php).
This command will listen for events and forward them to your local webhook endpoint.

### 7. Test Card Details
Here are some test card details you can use for different scenarios with Stripe:
1. Successful Payment
   - Card Number: 4242 4242 4242 4242
   - Expiry Date: Any future date (e.g., 12/24)
   - CVC: Any 3-digit number (e.g., 123)
2. Card Declined (Insufficient Funds)
   - Card Number: 4000 0000 0000 9995
   - Expiry Date: Any future date (e.g., 12/24)
   - CVC: Any 3-digit number (e.g., 123)
     






