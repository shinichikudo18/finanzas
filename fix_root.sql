UPDATE mysql.user SET plugin='mysql_native_password', Password=PASSWORD('Maria2025!') WHERE User='root' AND Host='localhost';
FLUSH PRIVILEGES;