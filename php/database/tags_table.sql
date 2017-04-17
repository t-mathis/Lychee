# Dump of table lychee_tags
# ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `?` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` varchar(100) NOT NULL,
    `description` varchar(1000) DEFAULT '',
    `category` varchar(32) DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;