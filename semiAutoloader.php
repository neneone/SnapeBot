<?php

/*
 * SnapeBot, PHP Framework for Telegram Bots
 * Copyright (C) 2019 Enea Dolcini
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

$autoloadDirectories = [
  'src',
];

function autoloadDirectory($directory)
{
    foreach (new DirectoryIterator($directory) as $item) {
        if (!$item->isDot()) {
            if (!$item->isFile()) {
                autoloadDirectory($item->getPathname());
            } elseif ($item->isFile() && 'src/SnapeBot.php' != $item->getPathname()) {
                require_once $item->getPathname();
            }
        }
    }
}

foreach ($autoloadDirectories as $directory) {
    autoloadDirectory($directory);
}
require_once 'src/SnapeBot.php';
