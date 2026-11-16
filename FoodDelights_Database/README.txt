FOOD DELIGHTS - PHP + MYSQL (XAMPP)

INSTALLATION
1. Extract the FoodDelights_Database folder into:
   C:\xampp\htdocs\
2. Start Apache and MySQL from XAMPP Control Panel.
3. Open http://localhost/phpmyadmin
4. Choose Import, select database.sql from this folder, then click Import/Go.
   This creates the food_delights database and inserts the six sample desserts.
5. Open config.php and check host, database, username, and password.
   XAMPP default is root with a blank password.
6. Open:
   http://localhost/FoodDelights_Database/

IMPORTANT
- Use localhost, not Live Server, because PHP must run through Apache.
- Products are loaded from the products table.
- Cart contents are kept in a PHP session.
- Checkout saves orders and order items in MySQL.
- Contact Us messages are saved in contact_messages.
- The project uses USD ($), matching the original sample website.
- about_us.html and style.css/images are retained from the original project.

USER ACCOUNTS
- register.php: customer sign-up
- login.php: customer log-in
- user.php: customer profile and order history
- logout.php: ends the customer session
- Passwords are stored as secure PHP password hashes, not plain text.
- Customers must log in before checkout. Orders are linked to the signed-in account.
- Email addresses must be unique. Passwords must be at least 8 characters.
- Import the updated database.sql into a fresh food_delights database. If you already imported an older version, back up any data before recreating/updating the schema.
