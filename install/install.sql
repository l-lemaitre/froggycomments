CREATE TABLE IF NOT EXISTS `PREFIX_froggy_comment` (
`id_froggy_comment` int NOT NULL AUTO_INCREMENT,
`id_product` int NOT NULL,
`firstname` VARCHAR(255) NOT NULL,
`lastname` VARCHAR(255) NOT NULL,
`email` VARCHAR(255) NOT NULL,
`grade` tinyint(1) NOT NULL,
`comment` text NOT NULL,
`date_add` datetime NOT NULL,
PRIMARY KEY (`id_froggy_comment`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4 AUTO_INCREMENT=1;