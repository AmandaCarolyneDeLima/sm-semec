<?php

/**
 * Activate sidebar link
 *
 *  @param  string $path
 *  @param  string $active
 *  @return string
 */
function setActive($path, $active = 'active')
{
    return call_user_func_array('Request::is', (array) $path) ? $active : '';
}

/**
 * Pretty url for pagination, from ?page=2 -> page/2
 *
 *  @param string $links
 */
function prettyPaginationLinks($links): string
{
    $pattern = '#\?page=#';
    $replacement = '/page/';
    $one = preg_replace($pattern, $replacement, $links);

    $pattern = '#page/([1-9]+[0-9]*)/page/([1-9]+[0-9]*)#';
    $replacement = 'page/$2';

    return preg_replace($pattern, $replacement, $one);
}
