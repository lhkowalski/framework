rem set environment variables and start local built-in server

cd application_public
set DATABASE_URL=mysql://root:password@localhost:3306/database
php -S localhost:3000