CREATE USER IF NOT EXISTS 'bankapp'@'127.0.0.1' IDENTIFIED BY 'BankApp2025!';
CREATE USER IF NOT EXISTS 'bankapp'@'localhost' IDENTIFIED BY 'BankApp2025!';
GRANT ALL PRIVILEGES ON katherine_bank.* TO 'bankapp'@'127.0.0.1';
GRANT ALL PRIVILEGES ON katherine_bank.* TO 'bankapp'@'localhost';
FLUSH PRIVILEGES;