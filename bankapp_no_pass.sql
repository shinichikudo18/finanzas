DROP USER IF EXISTS 'bankapp'@'localhost';
CREATE USER 'bankapp'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON katherine_bank.* TO 'bankapp'@'localhost';
FLUSH PRIVILEGES;