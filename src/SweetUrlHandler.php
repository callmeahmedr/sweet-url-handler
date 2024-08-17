<?php

class SweetUrlHandler {
    private $route;

    public function __construct() {
        // Parse the request URI and remove the query string if present
        $requestURI = $_SERVER['REQUEST_URI'];
        $path = parse_url( $requestURI, PHP_URL_PATH );

        // Split the path into components and remove any empty values
        $this->route = array_filter( explode( '/', trim( $path, '/' ) ) );
    }

    /**
    * Get the entire route as an array, or a specific segment if index is provided.
    *
    * @param int|null $index The index of the route segment to return.
    * @return mixed The route array or specific segment.
    */

    public function getRoute( $index = null ) {
        if ( $index !== null ) {
            return isset( $this->route[$index] ) ? $this->route[$index] : null;
        }
        return $this->route;
    }

    /**
    * Match the current route against a given pattern.
    *
    * @param string $pattern The route pattern to match, e.g., 'products/{id}'.
    * @return array|false Returns an associative array of parameters if matched, or false if no match.
    */

    public function matchRoute( $pattern ) {
        // Split the pattern into components
        $patternComponents = explode( '/', trim( $pattern, '/' ) );

        if ( count( $patternComponents ) !== count( $this->route ) ) {
            return false;
        }

        $params = [];

        foreach ( $patternComponents as $index => $component ) {
            if ( preg_match( '/\{(\w+)\}/', $component, $matches ) ) {
                // If the component is a parameter, store it in the params array
                $params[$matches[1]] = $this->route[$index];
            } elseif ( $component !== $this->route[$index] ) {
                // If the component does not match, return false
                return false;
            }
        }

        return $params;
    }
}
