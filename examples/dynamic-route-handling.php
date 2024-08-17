<?php

require_once 'src/SweetUrlHandler.php';

// Initialize the SweetUrlHandler
$handler = new SweetUrlHandler();

// Route matching with a callback for dynamic handling
$handler->handleRoute('orders/booking/{booking_id}', function($params) {
    echo 'Booking ID: ' . $params['booking_id'] . '<br>';
    
    // Example logic based on booking ID
    if ($params['booking_id'] == 786) {
        echo 'Special booking number detected!<br>';
    } else {
        echo 'Regular booking.<br>';
    }
});
