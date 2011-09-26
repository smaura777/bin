/**  drop  database IF EXISTS RAM; **/

CREATE DATABASE IF NOT EXISTS RAM;
USE RAM;

CREATE TABLE IF NOT EXISTS accounts (
  uid VARCHAR(36) NOT NULL, 
  user VARCHAR(80) NOT NULL,
  pass VARCHAR(60) NOT NULL,
  fname VARCHAR(36),
  lname VARCHAR(36),
  created_on bigint unsigned NOT NULL,
  last_modified  bigint unsigned NOT NULL,
  status ENUM('active','cancelled','blocked','innactive'),
  PRIMARY KEY (uid),
  UNIQUE KEY (user)
);


CREATE TABLE IF NOT EXISTS tags (
  tagid VARCHAR(36)  NOT NULL,
  tagname VARCHAR(128) NOT NULL,
  tagdisplay VARCHAR(128) NOT NULL,
  tagdescription text,
  created_on bigint unsigned  NOT NULL,
  uid VARCHAR(36) NOT NULL, 
  lng float default 0.0 ,
  lat float default 0.0,
  PRIMARY KEY (tagid)
);

CREATE TABLE IF NOT EXISTS document_tag_mapping (
  tagid VARCHAR(36)  NOT NULL,
  docid VARCHAR(36) NOT NULL,
  created_on bigint unsigned  NOT NULL,
  PRIMARY KEY (docid,tagid)
);

CREATE TABLE IF NOT EXISTS entry_tag_mapping (
  tagid VARCHAR(36)  NOT NULL,
  entryid VARCHAR(36) NOT NULL,
  created_on bigint unsigned  NOT NULL,
  PRIMARY KEY (entryid,tagid)
);


CREATE TABLE IF NOT EXISTS documents (
  docid VARCHAR(36) NOT NULL,
  docname VARCHAR(128) NOT NULL,
  docdisplay VARCHAR(128) NOT NULL,
  docdescription text,
  user_agent text,
  created_on bigint unsigned  NOT NULL,
  uid VARCHAR(36) NOT NULL, 
  PRIMARY KEY (docid)
);

CREATE TABLE IF NOT EXISTS entry (
  docid VARCHAR(36) NOT NULL,
  entryid VARCHAR(36) NOT NULL,
  entryteaser VARCHAR(128) NOT NULL,
  entrybody text,
  user_agent text,
  client_ip VARCHAR(15) NOT NULL default '0.0.0.0',
  created_on bigint unsigned  NOT NULL,
  uid VARCHAR(36) NOT NULL, 
  PRIMARY KEY (entryid)
);

CREATE TABLE IF NOT EXISTS groups (
  groupid VARCHAR(36) NOT NULL,
  groupname VARCHAR(128) NOT NULL,
  groupdisplay VARCHAR(128) NOT NULL,
  created_on bigint unsigned  NOT NULL,
  uid VARCHAR(36) NOT NULL, 
  lng float default 0.0 ,
  lat float default 0.0,
  PRIMARY KEY (groupid)
);

CREATE TABLE IF NOT EXISTS group_membership (
  groupid VARCHAR(36) NOT NULL,
  uid VARCHAR(36) NOT NULL, 
  created_on bigint unsigned  NOT NULL,
  lng float default 0.0 ,
  lat float default 0.0,
  PRIMARY KEY (groupid,uid)
);

CREATE TABLE IF NOT EXISTS document_access (
  groupid VARCHAR(36) NOT NULL,
  docid VARCHAR(36) NOT NULL, 
  created_on bigint unsigned  NOT NULL,
  lng float default 0.0,
  lat float default 0.0,  
  PRIMARY KEY (groupid,docid)
);

CREATE TABLE IF NOT EXISTS entry_access (
  groupid VARCHAR(36) NOT NULL,
  entryid VARCHAR(36) NOT NULL,
  created_on bigint unsigned  NOT NULL,
  lng float default 0.0,
  lat float default 0.0,  
  PRIMARY KEY (groupid,entryid)
);


CREATE TABLE IF NOT EXISTS app_error_code (
 code int unsigned NOT NULL,
 err_type VARCHAR(100),
 description text,
 PRIMARY KEY (code) 
);


CREATE TABLE IF NOT EXISTS app_errors (
   created_on bigint unsigned  NOT NULL,
   host_ip VARCHAR(15) NOT NULL default '0.0.0.0',
   client_ip VARCHAR(15) NOT NULL default '0.0.0.0',
   uid VARCHAR(36) NOT NULL, 
   message text,
   code int unsigned NOT NULL,
   user_agent text,
   session_id VARCHAR(40),
   key (session_id)
);






