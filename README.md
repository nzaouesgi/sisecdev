# sisecdev
[WARNING] Contains a lot of bad code, don't use any of the code except the ones marked as safe. 

These PHP scripts were made in order to demonstrate many vulnerabilities amongst the OWASP top ten (XSS, SQIi, LFI/RFI, CSRF...) and how to protect these.

The repo has two main repositories:

/secdev represents our vulnerable website/app root folder.

For testing the scripts, you have to make two differents virtual hosts for both folders named secdev/ and evil-secdev/

They must both be set to listen on port 5000.

Requirements:

PHP
If you want to test SQLi, you will need a MySQL database with one table just like this:

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT
    name VARCHAR(255)
)
