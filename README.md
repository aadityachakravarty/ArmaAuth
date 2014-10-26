ArmaAuth
========
ArmaAuth is a simple armathentication script for the 3D lightcycle game [Armagetron Advanced](http://armagetronad.org/). The script is designed to fit in with a forum authentication table with minimal modification to the forum software.

Usage
-----
- Prepare a MySQL table for use with authentication or configure your forum software to store passwords in the md5 format with an optional static salt.
- Edit `config.php` with database connection details and authentication table details.
- Place `index.php` and `config.php` under the public directory `/armaauth/0.1`.

Disclaimer
----------
I know md5 is no longer considered secure, but unless the whole Armagetron community decides to move on, I am stuck with it.
