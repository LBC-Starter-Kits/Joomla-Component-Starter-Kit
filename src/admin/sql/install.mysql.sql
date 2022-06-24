
--
-- Table structure for table `#__mymodel`
--

CREATE TABLE IF NOT EXISTS `#__mymodel` (
    `id`            int(11)         NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `title`         varchar(64)     NOT NULL,
    `description`   text            NOT NULL,
    `field_1`       decimal(10,0)   NOT NULL,
    `field_2`       tinyint(1)      NOT NULL DEFAULT '0',
    `field_3`       int(11)         NOT NULL DEFAULT '0'

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;



--
-- Datos de prueba
--

INSERT IGNORE INTO `#__mymodel` (`id`, `title`, `description`, `field_1`, `field_2`, `field_3`) VALUES 
(1, 'Item 1', 'El primer item', '5', 1, 120),
(1, 'Item 2', 'El segundo item', '6', 0, 0),
(1, 'Item 3', 'El tercer item', '123', 1, 16),
(1, 'Item 4', 'El cuarto item', '4', 0, 87),
(1, 'Item 5', 'El quito item', '5', 1, 23),