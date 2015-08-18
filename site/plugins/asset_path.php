<?php

/**
 * @param  string  $asset_path
 * @param  string  $filename
 * @return string
 */
function asset_path($path, $filename) {
    $manifest_path = $path . '/../rev-manifest.json';

    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), TRUE);
        $fullpath = 'public/' . $path . '/' . $filename;
        if ( array_key_exists($fullpath, $manifest) && !file_exists($fullpath) ) {
            return str_replace('public/', '', $manifest[$fullpath]);
        }
    }

    return $path . '/' . $filename;
}
