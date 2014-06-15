<?php

/**
 * @param  string  $asset_path
 * @param  string  $filename
 * @return string
 */
function asset_path($dist_path, $filename) {
    $manifest_path = $dist_path . '/rev-manifest.json';

    if (file_exists($manifest_path)) {
        $manifest = json_decode(file_get_contents($manifest_path), TRUE);
    } else {
        $manifest = array();
    }

    if ( array_key_exists($filename, $manifest) && !file_exists($dist_path . '/' . $filename) ) {
        return $dist_path . '/' . $manifest[$filename];
    }

    return $dist_path . '/' . $filename;
}