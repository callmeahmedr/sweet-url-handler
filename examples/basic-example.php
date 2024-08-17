<?php

require_once 'src/SweetUrlHandler.php';

// Initialize the SweetUrlHandler
$handler = new SweetUrlHandler();

// Get the entire route as an array
$route = $handler->getRoute();
echo 'Current Route: ' . implode('/', $route) . '<br>';

// Get a specific segment of the route
$segment = $handler->getRoute(0); // First segment
echo 'First Segment: ' . $segment . '<br>';

// Check if the first segment is 'products'
if ($segment === 'products') {
    echo 'You are viewing products!<br>';
} else {
    echo 'This is not a product route.<br>';
}
