CREATE TABLE `video` (
   `id` int(11) not null auto_increment,
   `username` varchar(250) not null,
   `title` text not null,
   `author` text not null,
   `category` varchar(250) not null,
   `videoName` text not null,
   `description` text not null,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;

INSERT INTO `video` (`id`, `username`, `title`, `author`, `category`, `videoName`, `description`) VALUES 
('1', 'admin', 'my vid', 'me', 'Biometrics', 'corporate_programs.mp4', 'my first vid');
