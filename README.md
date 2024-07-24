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
git clone https://github.com/your-username/your-repository.git
cd your-repository
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



