CREATE TABLE `resource` (
   `id` int(11) not null auto_increment,
   `username` varchar(250) not null,
   `resourceInfo` text not null,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;

INSERT INTO `resource` (`id`, `username`, `resourceInfo`) VALUES 
('1', 'admin', 'This is the real thing'),
('2', 'admin', 'Members Subscribe to the IEEE Computer Society Digital Library.'),
('3', 'admin', 'Non Members: Free access to abstracts and tables of contents of all Digital Library.'),
('4', 'admin', 'Also, purchase individual articles and papers.');