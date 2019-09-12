create table if not exists articles
(
  id smallint unsigned not null auto_increment,
  publicationDate date not null,
  title varchar(255) not null,
  summary text not null,
  content mediumtext not null,
  primary key(id)
)