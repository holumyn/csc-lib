CREATE TABLE `navigation_pages` (
   `id` int(11) not null auto_increment,
   `header` text not null,
   `note` text not null,
   `page` varchar(250) not null,
   UNIQUE KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=13;

INSERT INTO `navigation_pages` (`id`, `header`, `note`, `page`) VALUES 
('1', 'Explore our resources', 'Access and Publishing in my hood. .  lol', 'explore'),
('3', 'header 3', 'Discovery &amp; Delivery', ''),
('4', 'header 4', 'this is header 4. thanks', ''),
('5', 'header 5', 'his is great', ''),
('9', 'i am the developer', 'this is the developer.....our project', 'developer'),
('11', 'services 12', 'this is service 12', 'services'),
('12', 'project 2', 'this is project 2', 'project');