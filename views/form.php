
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="/stripe-integration/public/css/style.css"> <!-- Link to the CSS file -->
    <script src="https://js.stripe.com/v3/"></script>
    <script src="/stripe-integration/public/js/payment.js" defer></script>
</head>
<body>
   
    <form id="payment-form">
    <h1>Payment Form</h1>
        <div id="card-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>
        <div id="card-errors" role="alert"></div>
        <button type="submit">Submit Payment</button>
        <div id="payment-status"></div>
    </form>
</body>
</html>
