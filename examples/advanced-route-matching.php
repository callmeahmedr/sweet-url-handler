<?php

require_once 'src/SweetUrlHandler.php';

// Initialize the SweetUrlHandler
$handler = new SweetUrlHandler();

// Example: Match a route like /products/123
$match = $handler->matchRoute('products/{id}');
if ($match) {
    echo 'Product ID: ' . $match['id'] . '<br>';
} else {
    echo 'No match found.<br>';
}

// Test another route segment
$segment = $handler->getRoute(1); // Second segment
if ($segment) {
    echo 'Second Segment: ' . $segment . '<br>';
} else {
    echo 'Second segment not found.<br>';
}
