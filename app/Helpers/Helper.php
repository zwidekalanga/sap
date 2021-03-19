<?php

if (!function_exists('strncmp_startswith')) {
    function strncmp_startswith($haystack, $needle) {
      return strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}