<?php

/**
 * Update to version 3.1.3
 */

use Lychee\Modules\Database;
use Lychee\Modules\Response;


// Change DB engine for Photos table
$query  = Database::prepare($connection, "ALTER TABLE `?` ENGINE = InnoDB", array(LYCHEE_TABLE_PHOTOS));
$result = Database::execute($connection, $query, 'update_030103', __LINE__);

if ($result===false) Response::error('Could not change photos table DB engine!');


// Change DB engine for Albums table
$query  = Database::prepare($connection, "ALTER TABLE `?` ENGINE = InnoDB", array(LYCHEE_TABLE_ALBUMS));
$result = Database::execute($connection, $query, 'update_030103', __LINE__);

if ($result===false) Response::error('Could not change album table DB engine!');


// Change DB engine for Log table
$query  = Database::prepare($connection, "ALTER TABLE `?` ENGINE = InnoDB", array(LYCHEE_TABLE_LOG));
$result = Database::execute($connection, $query, 'update_030103', __LINE__);

if ($result===false) Response::error('Could not change logs table DB engine!');


// Change DB engine for Settings table
$query  = Database::prepare($connection, "ALTER TABLE `?` ENGINE = InnoDB", array(LYCHEE_TABLE_SETTINGS));
$result = Database::execute($connection, $query, 'update_030103', __LINE__);

if ($result===false) Response::error('Could not change settings table DB engine!');

// Set version
if (Database::setVersion($connection, '030103')===false) Response::error('Could not update version of database!');