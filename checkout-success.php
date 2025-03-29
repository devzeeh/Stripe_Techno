<?php
if(!isset($_REQUEST['provider_session_id'])){
    die();
}

//use the provider_session_id to look up order in database, then take further action.
echo 'Payment Successful!';





// Check if the popup should be shown
// This is AI generated code, so it may not work as expected
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout Success</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Payment Successful!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your payment has been processed successfully.
                    <p>Redirecting to Home Page in <span id="countdown"></span> seconds...</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="redirectToCart()">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Show modal when page loads
        window.onload = function() {
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            startCountdown();
        }

        // Function to redirect to cart.php
        function redirectToCart() {
            window.location.href = 'cart.php';
        }

        // Countdown function
        function startCountdown() {
            var seconds = 6;
            var countdown = document.getElementById('countdown');
            var timer = setInterval(function() {
                seconds--;
                countdown.textContent = seconds;
                if (seconds <= 0) {
                    clearInterval(timer);
                    redirectToCart();
                }
            }, 1000);
        }
    </script>
</body>
</html>