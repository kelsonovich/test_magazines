# Database

```sql
CREATE DATABASE magazines;

CREATE TABLE authors (
id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
first_name varchar(255) NOT NULL,
last_name varchar(255) NOT NULL,
middle_name varchar(255) DEFAULT NULL
);

CREATE TABLE magazines (
id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
title varchar(255) NOT NULL,
short_description varchar(1000) DEFAULT NULL,
image varchar(255) NOT NULL,
authors varchar(255) NOT NULL,
release_date date DEFAULT NULL
);
```