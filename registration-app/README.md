# Mathew Agyei Henry Tires Ghana

A responsive tire shop website with account sign-in, registration, a six-product
catalog, and a WhatsApp order flow.

## Run with XAMPP

1. Copy this folder into XAMPP's `htdocs` directory, for example:
   `C:\xampp\htdocs\registration-app`
2. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
3. Open `http://localhost/phpmyadmin`.
4. Select **Import**, choose `schema.sql` from this folder, then select **Import**.
   The script creates the `registration_app` database and its `users` table.
5. Visit `http://localhost/registration-app/` to sign in, or create an account
   from the sign-up link. After successful sign-in or sign-up, the shop opens.

The tire catalog and cart are in `tires.php` and `shop.js`. All six displayed
tire sizes are GH₵ 300 per piece. The cart works while the shop page is open
and sends an order summary to WhatsApp at +233 244 603 485; it does not process
online payments.

The shop uses a locally included vector tire illustration (`tire.svg`), so the
product artwork does not rely on a third-party image service.

The app requires PHP with the PDO MySQL extension enabled. By default, it
connects to `127.0.0.1` as MySQL user `root` with an empty password, which is
the usual local XAMPP setup. If your MySQL credentials differ, set `DB_HOST`,
`DB_NAME`, `DB_USER`, and `DB_PASS` in the Apache/PHP environment before starting
Apache. Database connection errors are recorded in PHP's error log.
