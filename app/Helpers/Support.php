<?php

if (!function_exists('g')) {
    /**
     * Alias for data-get
     * @param $data
     * @param $key
     * @param null $default
     * @return mixed
     */
    function g($data, $key, $default = null)
    {
        return data_get($data, $key, $default);
    }
}

if (!function_exists('redirectSuccess')) {
    /**
     * @param string $route
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirectSuccess(string $route, string $message)
    {
        return redirect(route($route))->with('success', $message);
    }
}

if (!function_exists('redirectFail')) {
    /**
     * @param string $route
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    function redirectFail(string $route, string $message)
    {
        return redirect(route($route))->with('fail', $message);
    }
}
