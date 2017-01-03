CREATE TABLE `help` (
   `id` int(11) not null auto_increment,
   `name` varchar(250) not null,
   `email` varchar(250) not null,
   `comment` text not null,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;

INSERT INTO `help` (`id`, `name`, `email`, `comment`) VALUES 
('1', 'olu', 'noble2016@gmail.com', 'this is serious'),
('2', 'olum', 'me@gmail.com', 'this isngreat'),
('3', 'olum', 'me@gmail.com', 'this isngreat');