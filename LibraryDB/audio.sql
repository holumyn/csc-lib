CREATE TABLE `audio` (
   `id` int(11) not null auto_increment,
   `username` varchar(250) not null,
   `title` text not null,
   `author` text not null,
   `category` text not null,
   `audioName` text not null,
   `description` text not null,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;

INSERT INTO `audio` (`id`, `username`, `title`, `author`, `category`, `audioName`, `description`) VALUES 
('1', 'admin', 'movie', 'me', 'Artificial Intelligence', 'joinbutton.wma', 'this is artificial intelligence audio'),
('2', 'admin', 'bible', 'jesus', 'Artificial Intelligence', '28_Hosea009.mp3', 'this isn jesus'),
('3', 'admin', 'thidhfg', 'k;lhdgf', 'Artificial Intelligence', 'NOT ALLOW PEOPLE TO LEBEL YOU.mp3', 'gjkjhjghhkjhgjnnm jkhhjj');