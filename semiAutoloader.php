<?php

$autoloadDirectories = [
  'src'
];

function autoloadDirectory($directory)
{
    foreach (new DirectoryIterator($directory) as $item) {
        if (!$item->isDot()) {
            if (!$item->isFile()) {
                autoloadDirectory($item->getPathname());
            } elseif ($item->isFile()) {
                require_once $item->getPathname();
            }
        }
    }
}

foreach ($autoloadDirectories as $directory) {
    autoloadDirectory($directory);
}
