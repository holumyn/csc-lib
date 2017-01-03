CREATE TABLE `subjects` (
   `id` int(11) not null auto_increment,
   `menu_name` varchar(250) not null,
   `position` int(11) not null,
   `visible` tinyint(4) not null,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;

INSERT INTO `subjects` (`id`, `menu_name`, `position`, `visible`) VALUES 
('3', 'Browse by:', '1', '1'),
('4', 'Programming', '2', '1');