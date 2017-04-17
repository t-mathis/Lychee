# Dump of table lychee_photos_to_tags
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `?` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `photoId` bigint(14) unsigned NOT NULL,
    `tagId` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (photoId)
        REFERENCES `?`(`id`)
        ON DELETE CASCADE,
    FOREIGN KEY (tagId)
        REFERENCES `?`(`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;