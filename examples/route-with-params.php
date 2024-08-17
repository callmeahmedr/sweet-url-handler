<?php

require_once 'src/SweetUrlHandler.php';

// Initialize the SweetUrlHandler
$handler = new SweetUrlHandler();

// Example: Match a route like /products/123?sort=asc
$handler->handleRoute('products/{id}', function($params) {
    echo 'Product ID: ' . $params['id'] . '<br>';
    echo 'Sort Order: ' . $params['sort'] . '<br>';
});

// Test route segment retrieval
$secondSegment = $handler->getRoute(1);
if ($secondSegment) {
    echo 'Second Segment: ' . $secondSegment . '<br>';
} else {
    echo 'Second segment not found.<br>';
}

// Test all query parameters
$queryParams = $handler->getParams();
if (!empty($queryParams)) {
    echo 'Query Parameters: <pre>' . print_r($queryParams, true) . '</pre>';
} else {
    echo 'No query parameters found.<br>';
}
