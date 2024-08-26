![[](frame_generic)](https://github.com/callmeahmedr/sweet-url-handler/blob/e52046ace9deea94607d8d3c1b0a8940164481eb/docs/frame_generic.png)
# SweetUrlHandler
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

# Rewrite request to a PHP file containing SweetUrlHandler initialization (by default it's index.php)
RewriteRule ^(.*)$ index.php?path=$1 [QSA,L]
```

## Basic Usage
Here’s a simple example of how to use the 'SweetUrlHandler' class in your project:
```php
require_once 'src/SweetUrlHandler.php';

// Create an instance of the SweetUrlHandler class
$handler = new SweetUrlHandler();

// Example URL for demonstration
// Suppose the current URL is http://example.com/products/category/item
// The SweetUrlHandler will process this URL to extract the route
$currentUrl = 'http://example.com/products/category/item';

// Set the current URL (this might be done automatically in a real application)
$handler->setUrl($currentUrl);

// Get the entire route as an array
$route = $handler->getRoute();
echo 'Current Route: ' . implode('/', $route) . PHP_EOL;

// Get a specific segment of the route
$segment = $handler->getRoute(0); // First segment
echo 'First Segment: ' . $segment . PHP_EOL;
```

## Advanced Usage
### Route Matching
You can match specific routes using patterns. This allows you to define routes with parameters, making your URL handling more dynamic:
```php
require_once 'src/SweetUrlHandler.php';

// Create an instance of the SweetUrlHandler class
$handler = new SweetUrlHandler();

// Example URL for demonstration
// Suppose the current URL is http://example.com/products/123
$currentUrl = 'http://example.com/products/123';

// Set the current URL (this might be done automatically in a real application)
$handler->setUrl($currentUrl);

// Define the route pattern
$pattern = 'products/{id}';

// Match the route against the pattern
$match = $handler->matchRoute($pattern);

if ($match) {
    echo 'Product ID: ' . $match['id'] . PHP_EOL;
} else {
    echo 'No match found' . PHP_EOL;
}
```

### Route Matching with Parameters
The `matchRoute()` method has been enhanced to merge route parameters with query parameters, providing a comprehensive set of parameters.
```php
require_once 'src/SweetUrlHandler.php';

// Create an instance of the SweetUrlHandler class
$handler = new SweetUrlHandler();

// Example URL for demonstration
// Suppose the current URL is http://example.com/products/123?sort=asc
$currentUrl = 'http://example.com/products/123?sort=asc';

// Set the current URL (this might be done automatically in a real application)
$handler->setUrl($currentUrl);

// Define a route pattern with parameters
$handler->handleRoute('products/{id}', function($params) {
    // Display the extracted parameters
    echo 'Product ID: ' . $params['id'] . '<br>';
    echo 'Sort Order: ' . (isset($params['sort']) ? $params['sort'] : 'not specified') . '<br>';
});

// Example: Get a specific route segment
echo 'Second Segment: ' . $handler->getRoute(1) . '<br>';

// Example: Get all query parameters
print_r($handler->getParams());
```

### Custom Route Handlers
You can define custom route handlers for specific patterns:
```php
require_once 'src/SweetUrlHandler.php';

// Create an instance of the SweetUrlHandler class
$handler = new SweetUrlHandler();

// Example URL for demonstration
// Suppose the current URL is http://example.com/articles/456
$currentUrl = 'http://example.com/articles/456';

// Set the current URL (this might be done automatically in a real application)
$handler->setUrl($currentUrl);

// Add a custom route handler for 'articles/{id}'
$handler->addCustomHandler('articles/{id}', function($params) {
    echo 'Article ID: ' . $params['id'] . '<br>';
});

// Handle custom routes based on the current URL
$handler->handleCustomRoutes();
```

## Method Summary
### `getRoute($index)`
| <!-- --> | <!-- --> |
| ------------- | ------------- |
| **Purpose**          | Retrieves the route segments as an array or a specific segment if an index is provided.  |
| **Parameters**       | `$index` (optional)  |
| **Returns**          | Route segment at index or entire route array  |

### `getParams($name)`
| <!-- --> | <!-- --> |
| ------------- | ------------- |
| **Purpose**          | Retrieves query parameters or a specific parameter if a name is provided.  |
| **Parameters**       | `$name` (optional)  |
| **Returns**          | Value of specific query parameter or entire parameters array  |

### `matchRoute($pattern)`
| <!-- --> | <!-- --> |
| ------------- | ------------- |
| **Purpose**          | Matches the current route against a given pattern and extracts parameters if matched.  |
| **Parameters**       | `$pattern`  |
| **Returns**          | Associative array of parameters or `false` if no match	  |

### `handleRoute($pattern, $callback)`
| <!-- --> | <!-- --> |
| ------------- | ------------- |
| **Purpose**          | Matches the current route against a pattern and executes a callback function if matched.  |
| **Parameters**       | `$pattern`, `$callback`  |
| **Returns**          | None |

### `handleCustomRoutes()`
| <!-- --> | <!-- --> |
| ------------- | ------------- |
| **Purpose**          | Executes custom handlers for registered patterns.  |
| **Parameters**       | None  |
| **Returns**          | None |

## Contributing
I welcome contributions to enhance the functionality and improve the `SweetUrlHandler`. To contribute:

1. **Fork the Repository**: Create a fork of this repository to your own GitHub account.
2. **Create a Branch**: Create a new branch for your changes.
3. **Make Your Changes**: Implement your improvements or bug fixes.
4. **Submit a Pull Request**: Submit a pull request with a clear description of your changes.

Please ensure your contributions follow the existing coding standards and add tests where appropriate. Open an issue to discuss your changes.

Thank you for helping improve SweetUrlHandler!
