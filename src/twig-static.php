<?php

/**
 * returns a twig filter that takes a file path (relative to $asset_root)
 * and returns a full url (prepended with $asset_url) and versioned with
 * a hash of the file contents.
 * @param  string $asset_root a relative path from the app root to the assets root dir
 * @param  string $asset_url  an absolute url to the assets root
 * @return function           a twig template filter
 */
function create_static_filter($asset_root, $asset_url) {

    // Turn path relative to app root to absolute
    $asset_root = realpath($asset_root);
    // Test if the path exists
    if ($asset_root == false) {
        error_log("Couldn't find path: $asset_root");
        // Return a noop
        return function ($filename) {
            return $filename;
        };
    }

    /**
     * returns a full url versioned with a hash of the file contents
     * @param  string $filename a relative path to a file in $asset_root
     * @return string           an absolute path to the asset
     */
    return function ($filename) use ($asset_root, $asset_url) {
        $fullpath = realpath($asset_root . '/' . $filename);
        // Test if the file exists
        if ($fullpath == false) {
            error_log("Couldn't find \"$filename\" in \"$asset_root\"");
            return $asset_url . $filename;
        }
        // We're using crc32 which gives a short hash with a low enough number of
        // hashes per site that we shouldn't expect a collision. Example output: 3d653119
        // To get a list of usable algorithms with example output see: https://gist.github.com/anonymous/055b1d8779ce71d2556dbb96df94d6af
        $hash = hash_file('crc32', $fullpath);
        return $asset_url . $filename . '?v=' . $hash;
    };
}
