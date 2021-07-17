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

create table auth_rule
(
    name       varchar(64) not null
        primary key,
    data       blob        null,
    created_at int         null,
    updated_at int         null
)
    collate = utf8_unicode_ci;

create table auth_item
(
    name        varchar(64) not null
        primary key,
    type        smallint    not null,
    description text        null,
    rule_name   varchar(64) null,
    data        blob        null,
    created_at  int         null,
    updated_at  int         null,
    constraint auth_item_ibfk_1
        foreign key (rule_name) references auth_rule (name)
            on update cascade on delete set null
)
    collate = utf8_unicode_ci;

create index `idx-auth_item-type`
    on auth_item (type);

create index rule_name
    on auth_item (rule_name);

create table auth_item_child
(
    parent varchar(64) not null,
    child  varchar(64) not null,
    primary key (parent, child),
    constraint auth_item_child_ibfk_1
        foreign key (parent) references auth_item (name)
            on update cascade on delete cascade,
    constraint auth_item_child_ibfk_2
        foreign key (child) references auth_item (name)
            on update cascade on delete cascade
)
    collate = utf8_unicode_ci;

create index child
    on auth_item_child (child);

create table context
(
    id    int auto_increment
        primary key,
    `key` varchar(50)  not null,
    name  varchar(255) not null,
    constraint `key`
        unique (`key`)
);

create table menu
(
    id         int auto_increment
        primary key,
    context_id int          not null,
    name       varchar(255) null,
    constraint menu_context
        foreign key (context_id) references context (id)
            on delete cascade
);

create table menu_tree
(
    id      int auto_increment
        primary key,
    menu_id int           not null,
    parent  int           null,
    title   varchar(255)  not null,
    url     varchar(255)  not null,
    icon    varchar(255)  null,
    sort    int default 0 null,
    constraint menu_tree_menu
        foreign key (menu_id) references menu (id)
            on delete cascade
);

create index parent_id
    on menu_tree (parent);

create table resource
(
    id         int auto_increment
        primary key,
    context_id int           not null,
    parent     int default 0 null,
    title      varchar(255)  not null,
    url        varchar(255)  not null,
    icon       varchar(255)  null,
    sort       int default 0 null,
    constraint context
        foreign key (context_id) references context (id)
            on delete cascade
);

create index context_id
    on resource (context_id);

create index parent
    on resource (parent);

create table user
(
    id            int auto_increment
        primary key,
    username      varchar(255)      not null,
    email         varchar(255)      not null,
    password_hash varchar(255)      not null,
    auth_key      varchar(32)       not null,
    status        tinyint default 9 not null,
    created_at    int               not null,
    updated_at    int               not null,
    constraint email
        unique (email),
    constraint username
        unique (username)
)
    collate = utf8_unicode_ci;

create table auth_assignment
(
    item_name  varchar(64) not null,
    user_id    int         not null,
    created_at int         null,
    primary key (item_name, user_id),
    constraint auth_assignment_ibfk_1
        foreign key (item_name) references auth_item (name)
            on update cascade on delete cascade,
    constraint auth_assignment_user
        foreign key (user_id) references user (id)
            on delete cascade
)
    collate = utf8_unicode_ci;

create index `idx-auth_assignment-user_id`
    on auth_assignment (user_id);

create table user_option
(
    user_id int          not null,
    `key`   varchar(255) not null,
    value   varchar(255) not null,
    primary key (user_id, `key`),
    constraint user_option_user
        foreign key (user_id) references user (id)
            on delete cascade
)
    collate = utf8_unicode_ci;

create index user_id
    on user_option (user_id);




INSERT INTO context (id, `key`, name) VALUES (1, 'backend', 'Backend');
INSERT INTO context (id, `key`, name) VALUES (2, 'frontend', 'Frontend');

INSERT INTO menu (id, context_id, name) VALUES (1, 1, 'top_menu_title');
INSERT INTO menu (id, context_id, name) VALUES (2, 1, 'top_right_menu_title');

INSERT INTO menu_tree (id, menu_id, parent, title, url, icon, sort) VALUES (1, 1, 0, 'top_menu_system_title', '#', 'fas fa-file', 0);
INSERT INTO menu_tree (id, menu_id, parent, title, url, icon, sort) VALUES (2, 1, 1, 'rm_contexts_title', 'contexts/', 'fas fa-file', 0);
INSERT INTO menu_tree (id, menu_id, parent, title, url, icon, sort) VALUES (3, 1, 1, 'rm_users_title', 'users/', 'fas fa-file', 0);
INSERT INTO menu_tree (id, menu_id, parent, title, url, icon, sort) VALUES (4, 2, 0, 'rm_lk_title', '#', 'fas fa-file', 0);
INSERT INTO menu_tree (id, menu_id, parent, title, url, icon, sort) VALUES (5, 2, 4, 'rm_profile_title', 'profile/', 'fas fa-file', 0);
INSERT INTO menu_tree (id, menu_id, parent, title, url, icon, sort) VALUES (6, 1, 0, 'top_menu_clear_cache_title', '#', 'fas fa-file', 0);
INSERT INTO menu_tree (id, menu_id, parent, title, url, icon, sort) VALUES (7, 1, 6, 'Backend', '#', 'fas fa-file', 0);
INSERT INTO menu_tree (id, menu_id, parent, title, url, icon, sort) VALUES (8, 2, 4, 'top_right_logout_title', 'user/logout/', 'fas fa-file', 0);
INSERT INTO menu_tree (id, menu_id, parent, title, url, icon, sort) VALUES (9, 1, 6, 'Frontend', '#', 'fas fa-file', 0);

INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (1, 1, 0, 'rm_home_title', '/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (2, 1, 0, 'rm_contexts_title', 'contexts/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (3, 1, 2, 'rm_create_context_title', 'contexts/create/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (4, 1, 0, 'rm_users_title', 'users/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (5, 1, 4, 'rm_create_user_title', 'users/create/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (6, 1, 2, 'rm_update_context_title', 'contexts/update/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (7, 1, 4, 'rm_update_user_title', 'users/update/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (8, 1, 0, 'rm_auth_login_title', 'login/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (9, 1, 0, 'rm_profile_title', 'profile/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (10, 1, 0, 'rm_recovery_title', 'recovery/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (11, 1, 0, 'rm_register_title', 'register/', 'fas fa-file', 0);
INSERT INTO resource (id, context_id, parent, title, url, icon, sort) VALUES (12, 2, 0, 'Home', '/', 'fas fa-file', 0);