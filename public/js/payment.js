
const stripe = Stripe(STRIPE_PUBLISHABLE_KEY);
const elements = stripe.elements();

// Create an instance of the card Element
const card = elements.create('card', {
    hidePostalCode: true, // This hides the postal code field
});
card.mount('#card-element');

// Handle real-time validation errors from the card Element
card.addEventListener('change', (event) => {
    const displayError = document.getElementById('card-errors');
    if (!displayError) {
        console.error('Element with id "card-errors" not found.');
        return;
    }
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission
const form = document.getElementById('payment-form');
if (!form) {
    console.error('Form with id "payment-form" not found.');
}
form.addEventListener('submit', async (event) => {
    event.preventDefault();

    try {
        // Create a PaymentMethod and handle the response
        const {paymentMethod, error} = await stripe.createPaymentMethod('card', card);

        const paymentStatus = document.getElementById('payment-status');
        if (!paymentStatus) {
            console.error('Element with id "payment-status" not found.');
        }

        if (error) {
            console.error(error);
            if (paymentStatus) {
                paymentStatus.innerText = error.message;
            }
        } else {
            // Send the PaymentMethod ID to your server
            const response = await fetch('/stripe-integration/public/index.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({payment_method: paymentMethod.id})
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const result = await response.json();

            if (result.error) {
                if (paymentStatus) {
                    paymentStatus.className = 'payment-error';
                    paymentStatus.innerText = result.error;
                }
            } else {
                if (paymentStatus) {
                    paymentStatus.className = 'payment-success';
                    paymentStatus.innerText = 'Payment successful!';
                }
                // Optionally, redirect to a success page or update the UI
            }
        }
    } catch (error) {
        console.error('There was a problem with the fetch operation:', error);
        const paymentStatus = document.getElementById('payment-status');
        if (paymentStatus) {
            paymentStatus.innerText = 'An error occurred. Please try again.';
        }
    }
});