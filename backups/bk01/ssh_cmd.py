#!/usr/bin/env python3
import paramiko
import sys

host = '192.168.140.34'
port = 22
username = 'root'
password = 'AdmAgnov!2025'

if len(sys.argv) > 1:
    cmd = ' '.join(sys.argv[1:])
else:
    cmd = 'echo "Usage: python ssh_cmd.py <command>"'

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())

try:
    client.connect(host, port=port, username=username, password=password, timeout=10)
    stdin, stdout, stderr = client.exec_command(cmd)
    print(stdout.read().decode())
    print(stderr.read().decode())
    client.close()
except Exception as e:
    print(f"Error: {e}")
