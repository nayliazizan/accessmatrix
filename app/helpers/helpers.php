<?php

if (!function_exists('format_json_value')) {
    function format_json_value($json)
    {
        $data = json_decode($json, true);

        if (!$data) {
            return '';
        }

        $formatted = '';
        foreach ($data as $key => $value) {
            $formatted .= "• {$key}: {$value},\n";
        }

        return rtrim($formatted, ",\n");
    }
}