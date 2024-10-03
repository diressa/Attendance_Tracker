# How are the hashes done?

Once students scan their assigned QR code, they open a login page associated with the last digit of their student ID #.\
Modulus 10 is calculated with the ID (student_id % 10) to isolate the last digit.\
The student ID would be the 'key' ; the 'hash function' is modulus 10 ; the last digit isolated is the 'hash.'\
If the last digit matches the digit associated with the QR redirected login page, then the student can mark their attendence.\
I created this method of using different login pages to prevent attendance plagerism.

### Examples of ID's associated with login page:
Where 'x' is any number

xxxxxx0 --> qr_hash0.php\
xxxxxx1 --> qr_hash1.php\
xxxxxx2 --> qr_hash2.php\
xxxxxx3 --> qr_hash3.php\
...\
xxxxxx9 --> qr_hash9.php


### Successful Login:
Student scans correct ID and uses the right login credentials. Attendance is counted!

### Unsuccessful Login:
1. Student scans wrong ID and attempts to use their correct credentials. 
2. Student scans correct ID and incorrectly fills their credentials.

An error will appear and attendance will not be counted in both cases.
