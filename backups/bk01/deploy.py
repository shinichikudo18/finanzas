import paramiko
import os

host = '192.168.140.34'
port = 22
username = 'root'
password = 'AdmAgnov!2025'

local_dir = 'C:/dashboard'
remote_dir = '/var/www/html/dashboard'

files = ['index.html', 'fortigate.php', 'proxy.php']

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect(host, port=port, username=username, password=password, timeout=10)

sftp = client.open_sftp()

for f in files:
    local_path = os.path.join(local_dir, f)
    remote_path = os.path.join(remote_dir, f)
    if os.path.exists(local_path):
        sftp.put(local_path, remote_path)
        print(f"Uploaded: {f}")
    else:
        print(f"File not found: {f}")

sftp.close()
client.close()
print("Deployment complete!")
