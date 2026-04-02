import paramiko
import os

host = '192.168.140.34'
port = 22
username = 'root'
password = 'AdmAgnov!2025'

local_file = 'C:/dashboard/test_api.php'
remote_file = '/var/www/html/dashboard/test_api.php'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect(host, port=port, username=username, password=password, timeout=10)

sftp = client.open_sftp()
sftp.put(local_file, remote_file)
sftp.close()
client.close()
print(f"Uploaded: {os.path.basename(local_file)}")
