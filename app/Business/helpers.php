<?php

if (! function_exists('assetCDN')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function assetCDN($path, $secure = null)
    {
        return app('url')->assetFrom(config('app.cdn'), $path, $secure);
    }
}

if (! function_exists('elixirCDN')) {
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param  string  $file
     * @param  string  $buildDirectory
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    function elixirCDN($file, $buildDirectory = 'build')
    {
        return assetCDN(elixir($file, $buildDirectory));
    }
}
