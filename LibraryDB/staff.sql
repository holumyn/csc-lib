CREATE TABLE `staff` (
   `username` varchar(250) not null,
   `password` varchar(40) not null,
   `reg_date` timestamp not null default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
   PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `staff` (`username`, `password`, `reg_date`) VALUES 
('admin', '7018d9174fb00aaa4b853b352d90b923967ab4c7', '2014-07-31 22:48:14'),
('holumyn', '8cb2237d0679ca88db6464eac60da96345513964', '2014-05-23 22:20:24'),
('iyanu', '8cb2237d0679ca88db6464eac60da96345513964', '2014-07-22 13:09:12'),
('shaddy', '8cb2237d0679ca88db6464eac60da96345513964', '2014-07-15 21:16:43');