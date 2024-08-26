<?php

/**
 * SweetUrlHandler - A simple URL routing handler for PHP.
 *
 * This class handles routing based on URL patterns and query parameters.
 * It allows you to define routes and corresponding handlers, and matches
 * incoming requests to these routes.
 */
class SweetUrlHandler {
    private $route;
    private $params = [];
    private $cache = [];
    private $customHandlers = [];

    /**
     * Constructor that parses the request URI and query parameters.
     */
    public function __construct() {
        $requestURI = $_SERVER['REQUEST_URI'];
        $path = parse_url($requestURI, PHP_URL_PATH);

        // Get and normalize the base directory
        $baseDir = trim(str_replace($_SERVER['DOCUMENT_ROOT'], '', dirname($_SERVER['SCRIPT_FILENAME'])), '/');

        // Remove the base directory from the path
        if (!empty($baseDir) && strpos($path, '/' . $baseDir) === 0) {
            $path = substr($path, strlen('/' . $baseDir));
        }

        // Handle root path properly
        $path = trim($path, '/');
        if ($path === '') {
            $path = '/';
        }

        // Split the path into components and remove empty values
        $this->route = array_filter(explode('/', $path));

        // Parse query parameters
        parse_str(parse_url($requestURI, PHP_URL_QUERY), $this->params);
    }

    /**
     * Get the entire route as an array, or a specific segment if index is provided.
     *
     * @param int|null $index The index of the route segment to return.
     * @return mixed The route array or specific segment.
     */
    public function getRoute($index = null) {
        $cacheKey = 'route_' . ($index !== null ? $index : 'all');
        if (!isset($this->cache[$cacheKey])) {
            $this->cache[$cacheKey] = $index !== null ? (isset($this->route[$index]) ? $this->route[$index] : null) : $this->route;
        }
        return $this->cache[$cacheKey];
    }

    /**
     * Get all query parameters or a specific parameter by name.
     *
     * @param string|null $name The name of the query parameter to return.
     * @return mixed The query parameters array or specific parameter value.
     */
    public function getParams($name = null) {
        return $name !== null ? ($this->params[$name] ?? null) : $this->params;
    }

    /**
     * Match the current route against a given pattern.
     *
     * @param string $pattern The route pattern to match, e.g., 'products/{id}'.
     * @return array|false Returns an associative array of parameters if matched, or false if no match.
     */
    public function matchRoute($pattern) {
        if (!is_string($pattern) || empty($pattern)) {
            if ($pattern === '') {
                $pattern = '/';
            } else {
                throw new InvalidArgumentException('Pattern must be a non-empty string.');
            }
        }

        $patternComponents = explode('/', trim($pattern, '/'));
        $routeComponents = $this->route;

        if (count($patternComponents) !== count($routeComponents)) {
            return false;
        }

        $params = [];
        foreach ($patternComponents as $index => $component) {
            if (preg_match('/\{(\w+)(?:\:(\w+))?\}/', $component, $matches)) {
                // Parameter with optional default value
                $params[$matches[1]] = $routeComponents[$index] ?? ($matches[2] ?? null);
            } elseif ($component !== $routeComponents[$index]) {
                return false;
            }
        }

        return array_merge($params, $this->params);
    }

    /**
     * Match the route against a pattern and call a callback function if matched.
     *
     * @param string $pattern The route pattern to match.
     * @param callable $callback The callback function to execute if the route matches.
     * @return void
     */
    public function handleRoute($pattern, $callback) {
        if (!is_string($pattern) || empty($pattern)) {
            throw new InvalidArgumentException('Pattern must be a non-empty string.');
        }
        if (!is_callable($callback)) {
            throw new InvalidArgumentException('Callback must be callable.');
        }

        $params = $this->matchRoute($pattern);
        if ($params !== false) {
            call_user_func($callback, $params);
        }
    }

    /**
     * Add a custom route handler for specific patterns.
     *
     * @param string $pattern The route pattern to match.
     * @param callable $handler The handler function to execute if the route matches.
     * @return void
     */
    public function addCustomHandler($pattern, $handler) {
        if (!is_string($pattern) || empty($pattern) || !is_callable($handler)) {
            throw new InvalidArgumentException('Invalid pattern or handler.');
        }
        $this->customHandlers[$pattern] = $handler;
    }

    /**
     * Handle custom routes by checking all registered handlers.
     *
     * @return void
     */
    public function handleCustomRoutes() {
        foreach ($this->customHandlers as $pattern => $handler) {
            $params = $this->matchRoute($pattern);
            if ($params !== false) {
                call_user_func($handler, $params);
                return;
            }
        }
    }
}
