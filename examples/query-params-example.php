<?php

require_once 'src/SweetUrlHandler.php';

// Initialize the SweetUrlHandler
$handler = new SweetUrlHandler();

// Handle a route and retrieve query parameters
$handler->handleRoute('products/{id}', function($params) {
    echo 'Product ID: ' . $params['id'] . '<br>';
    echo 'Sort Order: ' . $params['sort'] . '<br>';
    
    if (isset($params['filter'])) {
        echo 'Filter: ' . $params['filter'] . '<br>';
    } else {
        echo 'No filter applied.<br>';
    }
});

// Print all query parameters
echo '<pre>';
print_r($handler->getParams());
echo '</pre>';
