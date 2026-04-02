DROP USER IF EXISTS 'katherine_bank'@'localhost';
CREATE USER 'katherine_bank'@'localhost' IDENTIFIED BY 'Katherine2025!';
GRANT ALL PRIVILEGES ON katherine_bank.* TO 'katherine_bank'@'localhost';
FLUSH PRIVILEGES;