CREATE TABLE `about` (
   `id` int(11) not null auto_increment,
   `username` varchar(250) not null,
   `page` varchar(20) not null,
   `content` text not null,
   `when` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;

INSERT INTO `about` (`id`, `username`, `page`, `content`, `when`) VALUES 
('1', 'admin', 'about', 'You can place the tag containing your JavaScript anywhere within you web page but it is preferred way to keep it within the tags. The tag alert the browser program to begin interpreting all the text be to print, micro form, or other media), along with means for organizing, ......testing', '2014-07-22 21:14:48'),
('2', 'admin', 'contact', 'contact us details....modified', '2014-07-22 21:11:58'),
('3', 'admin', 'policy', 'policy comes here....testing', '2014-07-22 21:15:19'),
('4', 'admin', 'terms', 'Terms right here...testing terms', '2014-07-22 21:15:40');