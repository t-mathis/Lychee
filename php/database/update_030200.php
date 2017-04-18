<?php

/**
 * Update to version 3.2.0
 */

use Lychee\Modules\Database;
use Lychee\Modules\Response;

// Check if tags column exists.
$query  = Database::prepare($connection, "SELECT `tags` FROM `?` LIMIT 1", array(LYCHEE_TABLE_PHOTOS));
$result = Database::execute($connection, $query, 'update_030200', __LINE__);

if ($result === true) {
    // Get all the photos with tags
    $query = Database::prepare($connection, 'SELECT id, tags FROM ? WHERE tags != "" ', array(LYCHEE_TABLE_PHOTOS));
    $photosWithTags = Database::execute($connection, $query, 'update_030200', __LINE__);
    $allTags = array();

    //Loop through all the photos with tags.
    //Break apart the tags string, and loop though those.
    //For each tag, check if it exists in our array. If it doesn't:
    // Insert the tag
    // Add it to our array with the inserted ID.
    //Insert the association between the photo and the tag.
    while ($photoWithTags = $photosWithTags->fetch_object()) {
        $tempTags = explode(',', $photoWithTags->tags);
        foreach ($tempTags as $tempTag) {
            if (!array_key_exists($tempTag, $allTags)) {
                //Insert Tags
                $query = Database::prepare($connection, "INSERT INTO ? (title) VALUES ('?')", array(LYCHEE_TABLE_TAGS, $tempTag));
                $result = Database::execute($connection, $query, 'update_030200', __LINE__);
                if ($result === false) {
                    Response::error('Could not insert tag "' . $tempTag . '"!');
                }

                $insertId = Database::insertId($connection, 'update_030200', __LINE__);
                if ($insertId === false) {
                    Response::error('No insert ID for tag "' . $tempTag . '"!');
                }

                $allTags[$tempTag] = $insertId;
            }

            // Insert Photos To Tags
            $query = Database::prepare($connection, "INSERT INTO ? (photoId, tagId) VALUES ('?', '?')", array(LYCHEE_TABLE_PHOTOS_TO_TAGS, $photoWithTags->id, $allTags[$tempTag]));
            $result = Database::execute($connection, $query, 'update_030200', __LINE__);

            if ($result === false) {
                Response::error('Could not insert photos to tags for photo:' . $photoWithTags->id . ' and tag: "' . $tempTag . '"!');
            }
        }
    }

    // Drop tags column in Photos table
    $query = Database::prepare($connection, "ALTER TABLE `?` DROP COLUMN `tags`", array(LYCHEE_TABLE_PHOTOS));
    $result = Database::execute($connection, $query, 'update_030200', __LINE__);

    if ($result === false) {
        Response::error('Could not drop tags column!');
    }
}

// Set version
if (Database::setVersion($connection, '030200')===false) Response::error('Could not update version of database!');