<?php

require_once 'src/SweetUrlHandler.php';

// Initialize the SweetUrlHandler
$handler = new SweetUrlHandler();

// Define your routes and their handlers
$handler->handleRoute('home', function() {
    echo '<h1>Welcome to the Home Page!</h1>';
});

$handler->handleRoute('products/{id}', function($params) {
    if (isset($params['id'])) {
        echo '<h1>Product Page</h1>';
        echo '<p>Product ID: ' . htmlspecialchars($params['id']) . '</p>';
    } else {
        echo '<h1>Product Page</h1>';
        echo '<p>Product ID not specified.</p>';
    }
});

$handler->handleRoute('about', function() {
    echo '<h1>About Us</h1>';
    echo '<p>This is the about page.</p>';
});

$handler->handleRoute('contact', function() {
    echo '<h1>Contact Us</h1>';
    echo '<p>This is the contact page.</p>';
});

$handler->handleRoute('orders/booking/{booking_id}', function($params) {
    if (isset($params['booking_id'])) {
        echo '<h1>Order Booking</h1>';
        echo '<p>Booking ID: ' . htmlspecialchars($params['booking_id']) . '</p>';
    } else {
        echo '<h1>Order Booking</h1>';
        echo '<p>Booking ID not specified.</p>';
    }
});

// Extract the path from the query parameter
$path = isset($_GET['path']) ? $_GET['path'] : '';

// Sanitize the path to prevent security issues
$path = filter_var($path, FILTER_SANITIZE_STRING);

// Check if the path is not empty
if (!empty($path)) {
    // Split the path into components
    $components = array_filter(explode('/', trim($path, '/')));

    // Rebuild the path for route matching
    $route = implode('/', $components);

    // Handle the route based on the extracted path
    $matched = false;
    $handler->handleRoute($route, function($params) use (&$matched) {
        $matched = true;
        // The default behavior for a matched route can be handled here, or by the route-specific handler.
    });
}

// If no route was matched, handle the 404 error
if (!$matched) {
    http_response_code(404);
    echo '<h1>404 Not Found</h1>';
    echo '<p>The page you are looking for does not exist.</p>';
}
