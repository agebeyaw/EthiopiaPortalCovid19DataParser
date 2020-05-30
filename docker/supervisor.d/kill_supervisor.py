#!/usr/bin/env python
# inspired to https://blog.zhaw.ch/icclab/process-management-in-docker-containers/

import sys
import os
import signal

def write_stdout(s):
   sys.stdout.write(s)
   sys.stdout.flush()
def write_stderr(s):
   sys.stderr.write(s)
   sys.stderr.flush()
def main():
   while 1:
       write_stdout('READY\n')
       line = sys.stdin.readline()
       write_stdout('This line kills supervisor: ' + line + '\n')
       try:
            os.kill(1, signal.SIGTERM)
       except Exception as e:
               write_stdout('Could not kill supervisor: ' + e.strerror + '\n')
       write_stdout('RESULT 2\nOK')
if __name__ == '__main__':
   main()
   import sys
