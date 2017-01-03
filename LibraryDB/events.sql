CREATE TABLE `events` (
   `id` int(11) not null auto_increment,
   `username` varchar(250) not null,
   `title` text not null,
   `eventImg` text not null,
   `description` text not null,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;

INSERT INTO `events` (`id`, `username`, `title`, `eventImg`, `description`) VALUES 
('1', '', 'nacoss', '', 'our week of code'),
('2', 'admin', 'at last', 'news14401.jpg', 'victoryat last'),
('3', 'admin', 'olamide the best', 'Snapshot_20140625_12.JPG', 'This is olamide the best lady in the department'),
('4', 'admin', 'linked In the best professional website', 'logo_132x32_2.png', 'this is linked in. &lt;a href=&quot;&quot; target=&quot;_blank&quot;&gt;Click&lt;/a&gt; to go to site.'),
('5', 'holu', 'Penguins party on the beach tonight', 'Penguins.jpg', 'An electronic procurement system is also known as e-procurement. This term is used to describe software that allows purchasers to access supplier’s catalogs via the Internet, as well as accepting electronic invoices. The purchasers select their materials, indicate the accounts to be charged for the purchase, and create a purchase order in the accounting system. All procurement-related activity is completed in the electronic system, reducing paperwork and increasing efficiency.\r\nElectronic invoice processing allows selected companies to further streamline invoice review and approval. The data is then routed through a series of online approvals before being processed for payment in the accounting system. This type of procurement system is very popular in large firms, where procurement contracts are in place to manage spending activity. For these firms, the reduction in staff time for invoice processing provides an excellent return on investment.\r\n');