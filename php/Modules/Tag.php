<?php

namespace Lychee\Modules;

final class Tag {

    private $tagIds = null;

    /**
     * @return boolean Returns true when successful.
     */
    public function __construct($tagIds) {

        // Init vars
        $this->tagIds = $tagIds;

        return true;
    }

    /**
     * @return string|false title of the created tag.
     */
    public function add($title) {
        
        // Call plugins
        Plugins::get()->activate(__METHOD__, 0, func_get_args());

        // Check exists first.
        $query = Database::prepare(Database::get(), "SELECT title FROM ? WHERE title = '?'", array(LYCHEE_TABLE_TAGS, $title));
        $result = Database::execute(Database::get(), $query, __METHOD__, __LINE__);
        if($result === false) {
            return false;
        }
        
        if($result->num_rows == 0) {
            // Insert new.
            $query = Database::prepare(Database::get(), "INSERT INTO ? (title) VALUES ('?')", array(LYCHEE_TABLE_TAGS, $title));
            $result = Database::execute(Database::get(), $query, __METHOD__, __LINE__);
            if ($result === false) {
                return false;
            }
        } 

        // Call plugins
        Plugins::get()->activate(__METHOD__, 1, func_get_args());

        return array('title' => $title);
    }
}
?>

