CREATE TABLE IF NOT EXISTS dl_report (
	id int(11) NOT NULL PRIMARY KEY,
	track_id int(11) NOT NULL,
	ip_address varchar(20) DEFAULT NULL,
	expiry_date datetime DEFAULT NULL,
	transaction_id int(11) NOT NULL,
	dl_status varchar(30) NOT NULL,
	dl_source varchar(30) DEFAULT NULL,
	dl_type varchar(30) NOT NULL,
	dl_date datetime NOT NULL
);