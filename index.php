<?php
// Include the SweetUrlHandler class
require_once 'src/SweetUrlHandler.php';

// Initialize the SweetUrlHandler
$urlHandler = new SweetUrlHandler();

// Define a custom 404 handler
function handle404() {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found<br>";
    echo "The page you are looking for does not exist.";
    exit;
}

// Define routes and their handlers

// Home route (root path)
$urlHandler->handleRoute('/', function() {
    echo "Welcome to the Home Page!<br>";
    exit;
});

// Products route
$urlHandler->handleRoute('products', function() {
    echo "Welcome to the Products Page!<br>";
    exit;
});

// Product details route with a dynamic ID
$urlHandler->handleRoute('products/{id}', function($params) {
    echo "Product Details for ID: " . htmlspecialchars($params['id']) . "<br>";
    exit;
});

// About route
$urlHandler->handleRoute('about', function() {
    echo "Welcome to the About Page!<br>";
    exit;
});

// Handle custom routes if defined
$urlHandler->handleCustomRoutes();

// If no route is matched, show a 404 error
handle404();
