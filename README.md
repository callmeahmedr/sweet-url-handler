# Sweet URL Handler

A lightweight and scalable PHP utility to handle clean and pretty URLs in your application.

## Features

- **Easy Integration:** Simple to set up and use in any PHP project.
- **Scalable:** Designed to handle multiple routes efficiently.
- **Customizable:** Easily extendable for more advanced routing needs.

## Installation

### Step 1: Clone the repository:
Clone the repository to your local machine using the following command:
```bash
git clone https://github.com/callmeahmedr/sweet-url-handler.git
```

### Step 2: Include the Handler in Your Project:
Add the `SweetUrlHandler.php` file to your project by including it in your PHP scripts:
```php
require_once 'src/SweetUrlHandler.php';
```

### Step 3: Configure Your `.htaccess` File
Ensure your .htaccess file has the following rules to enable clean URLs:
```apache
RewriteEngine On

# Check if the request is for a real file or directory
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# Rewrite request to a PHP file containing SweetUrlHandler initialization (by default it's router.php)
RewriteRule ^(.*)$ router.php?path=$1 [QSA,L]
```

## Basic Usage

Here’s a simple example of how to use the 'SweetUrlHandler' class in your project:
```php
require_once 'src/SweetUrlHandler.php';

$handler = new SweetUrlHandler();

// Get the entire route as an array
$route = $handler->getRoute();
echo 'Current Route: ' . implode('/', $route);

// Get a specific segment of the route
$segment = $handler->getRoute(0); // First segment
echo 'First Segment: ' . $segment;

```

## Advanced Usage
### Route Matching
You can match specific routes using patterns. This allows you to define routes with parameters, making your URL handling more dynamic:
```php
require_once 'src/SweetUrlHandler.php';

$handler = new SweetUrlHandler();

// Example: Match a route like /products/123
$match = $handler->matchRoute('products/{id}');
if ($match) {
    echo 'Product ID: ' . $match['id'];
} else {
    echo 'No match found';
}
```

### Route Matching with Parameters
The `matchRoute()` method has been enhanced to merge route parameters with query parameters, providing a comprehensive set of parameters.
```php
require_once 'src/SweetUrlHandler.php';

$handler = new SweetUrlHandler();

// Example: Match a route like /products/123?sort=asc
$handler->handleRoute('products/{id}', function($params) {
    echo 'Product ID: ' . $params['id'] . '<br>';
    echo 'Sort Order: ' . $params['sort'];
});

// Example: Get a specific route segment
echo 'Second Segment: ' . $handler->getRoute(1);

// Example: Get all query parameters
print_r($handler->getParams());
```

### Method Summary

| Method                     | Purpose                                                                                     | Parameters                | Returns                                               | Usage Example                                                   |
|----------------------------|---------------------------------------------------------------------------------------------|---------------------------|-------------------------------------------------------|-----------------------------------------------------------------|
| `getRoute($index)`         | Retrieves the route segments as an array or a specific segment if an index is provided.    | `$index` (optional)       | Route segment at index or entire route array         | `$route = $handler->getRoute();`<br>`$segment = $handler->getRoute(0);` |
| `getParams($name)`         | Retrieves query parameters or a specific parameter if a name is provided.                  | `$name` (optional)        | Value of specific query parameter or entire parameters array | `$params = $handler->getParams();`<br>`$value = $handler->getParams('sort');` |
| `matchRoute($pattern)`     | Matches the current route against a given pattern and extracts parameters if matched.      | `$pattern`                | Associative array of parameters or `false` if no match | `$match = $handler->matchRoute('products/{id}');`<br>`if ($match) { echo 'Product ID: ' . $match['id']; }` |
| `handleRoute($pattern, $callback)` | Matches the current route against a pattern and executes a callback function if matched. | `$pattern`, `$callback`   | None                                                  | `$handler->handleRoute('products/{id}', function($params) { echo 'Product ID: ' . $params['id']; });` |

### Summary Table

| Method                     | Description                                                                                 |
|----------------------------|---------------------------------------------------------------------------------------------|
| **`getRoute($index)`**     | Retrieves the route as an array or a specific segment by index.                             |
| **`getParams($name)`**     | Gets query parameters from the URL or a specific parameter value.                           |
| **`matchRoute($pattern)`** | Matches the route against a specified pattern and extracts route parameters.               |
| **`handleRoute($pattern, $callback)`** | Matches the route against a pattern and executes a callback with matched parameters.    |


## Contributing
I welcome contributions to enhance the functionality and improve the `SweetUrlHandler`. To contribute:

1. **Fork the Repository**: Create a fork of this repository to your own GitHub account.
2. **Create a Branch**: Create a new branch for your changes.
3. **Make Your Changes**: Implement your improvements or bug fixes.
4. **Submit a Pull Request**: Submit a pull request with a clear description of your changes.

Please ensure your contributions follow the existing coding standards and add tests where appropriate. Open an issue to discuss your changes.

*Thank you for helping make `SweetUrlHandler` better!*
