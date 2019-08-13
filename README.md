# IF YOU WANT RUNNING THIS APP INTO YOUR LOCAL
1. Download XAMPP (its free) https://www.apachefriends.org/download.html
2. Intall it like usually you installed app 
3. Put Warehouse's folder into C:\xampp\htdocs

# HOW TO INSTALL / USE IT
This Web to manage your mini warehouse !

I made this with CodeIgniter so
1. Dont forget setting your config like routes and databse
2. Upload database file on folder _database/warehouse.sql into your xampp or whatever
3. Setting your email and password into Auth.php on folder Controller/Auth.php if you want to activate email service like register and change password
4. Use this account to access the admin panel: email -> r.rahmadianto@yahoo.com, password -> admin123

!! By default new user will be given access as "Member"

# COOKIE
Yup there is cookie inside the file Auth and file Config. So you can access the web without login again and again if you have checked the 'Remember Me' before login. By default, I try to set the cookie expired until 1 week.

# HOW TO BE CONTRIBUTOR
1. Clone this repo
2. Check out to Branch_stage1
