
--
-- Table structure for table `#__base`
--

CREATE TABLE IF NOT EXISTS `#__base` (
    `id`            int(11)         NOT NULL AUTO_INCREMENT,
    `title`         varchar(64)     NOT NULL,
    `description`   text            NOT NULL,
    `field_1`       decimal(10,0)   NOT NULL,
    `field_2`       tinyint(1)      NOT NULL DEFAULT '0',
    `field_3`       int(11)         NOT NULL DEFAULT '0',
    `state`         TINYINT         NOT NULL DEFAULT '1',
    PRIMARY KEY (`id`)

) ENGINE InnoDB DEFAULT COLLATE utf8mb4_unicode_ci;



--
-- Datos de prueba
--

INSERT IGNORE INTO `#__base` (`id`, `title`, `description`, `field_1`, `field_2`, `field_3`, `state`) VALUES 
(1, 'Item 1', 'El primer item', '5', 1, 120, 1),
(2, 'Item 2', 'El segundo item', '6', 0, 0, 1),
(3, 'Item 3', 'El tercer item', '123', 1, 16, 0),
(4, 'Item 4', 'El cuarto item', '4', 0, 87, 0),
(5, 'Item 5', 'El quito item', '5', 1, 23, 1);