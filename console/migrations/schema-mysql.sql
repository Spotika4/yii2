/**
 * Database schema required by \yii\rbac\DbManager.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @author Alexander Kochetov <creocoder@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @since 2.0
 */

drop table if exists `auth_assignment`;
drop table if exists `auth_item_child`;
drop table if exists `auth_item`;
drop table if exists `auth_rule`;

create table `auth_rule`
(
   `name`                 varchar(64) not null,
   `data`                 blob,
   `created_at`           integer,
   `updated_at`           integer,
    primary key (`name`)
) engine InnoDB;

create table `auth_item`
(
   `name`                 varchar(64) not null,
   `type`                 smallint not null,
   `description`          text,
   `rule_name`            varchar(64),
   `data`                 blob,
   `created_at`           integer,
   `updated_at`           integer,
   primary key (`name`),
   foreign key (`rule_name`) references `auth_rule` (`name`) on delete set null on update cascade,
   key `type` (`type`)
) engine InnoDB;

create table `auth_item_child`
(
   `parent`               varchar(64) not null,
   `child`                varchar(64) not null,
   primary key (`parent`, `child`),
   foreign key (`parent`) references `auth_item` (`name`) on delete cascade on update cascade,
   foreign key (`child`) references `auth_item` (`name`) on delete cascade on update cascade
) engine InnoDB;

create table `auth_assignment`
(
   `item_name`            varchar(64) not null,
   `user_id`              varchar(64) not null,
   `created_at`           integer,
   primary key (`item_name`, `user_id`),
   foreign key (`item_name`) references `auth_item` (`name`) on delete cascade on update cascade,
   key `auth_assignment_user_id_idx` (`user_id`)
) engine InnoDB;

create table context
(
    id int auto_increment primary key,
    `key` varchar(50) not null,
    name  varchar(255) not null,
    constraint `key`
    unique (`key`)
);

create table menu
(
    id  int auto_increment primary key,
    context_id int not null,
    name varchar(255) null,
    constraint menu_context
    foreign key (context_id) references context (id) on delete cascade
);

create table menu_tree
(
    id int auto_increment primary key,
    menu_id int not null,
    parent int null,
    title varchar(255) not null,
    url varchar(255) not null,
    icon varchar(255) null,
    sort int default 0 null,
    constraint menu_tree_menu
    foreign key (menu_id) references menu (id) on delete cascade
);
create index parent_id on menu_tree (parent);

create table resource
(
    id int auto_increment primary key,
    context_id int not null,
    parent int default 0 null,
    title varchar(255) not null,
    url varchar(255) not null,
    icon varchar(255) null,
    sort int default 0 null,
    constraint context
    foreign key (context_id) references context (id) on delete cascade
);
create index context_id on resource (context_id);
create index parent on resource (parent);