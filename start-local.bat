rem set environment variables and start local built-in server

cd application_public

set DATABASE_URL=mysql://user_417523641:2115922172542518173174073100@localhost:3306/database_429823650
set ROOT_URL=localhost:3000
rem set DATABASE_URL=mysql://root:password@localhost:3306/database
php -S localhost:3000