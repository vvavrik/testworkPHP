create database department;

grant insert, update, delete, select on department.* to MySQL_user@localhost identified by '0L*9E8T7M06E5I54N3';

use department;

create table user (   /* site user NB: site permissions will be in separate table */
 id int(1) unsigned not null auto_increment primary key,
 login char(20),
 pass char(20),
 tabelNumber int(6),
 IP char(15)
)
DEFAULT CHARSET=utf8;



