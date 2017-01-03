CREATE TABLE `document` (
   `username` varchar(250) not null,
   `ISBN` varchar(250) not null,
   `title` text not null,
   `author` text not null,
   `docName` varchar(250) not null,
   `category` varchar(250) not null,
   `description` text not null,
   PRIMARY KEY (`ISBN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `document` (`username`, `ISBN`, `title`, `author`, `docName`, `category`, `description`) VALUES 
('admin', '12345678', 'art', 'me', 'jobs_board.pdf', 'Game Technology', 'this is my book'),
('admin', '23455', 'me and i', 'holumyn', 'Batch.pdf', 'Artificial Intelligence', 'my book ever green'),
('admin', '654322', 'libray', 'me', 'digital_library.jpg', 'Game Technology', 'this s librsrt'),
('admin', '89326894', 'this is seriu', 'holumyn', 'Java How To Program, Ninth Edition, Deitel &amp; Deitel.pdf', 'Artificial Intelligence', 'i love programming');