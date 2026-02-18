Setup Instructions.
- composer update
- php artisan key:generate
- php artisan serve
- php artisan migrate:fresh --seed

Add Your SMPT key and password using google
    MAIL_MAILER=log
    MAIL_SCHEME=null
    MAIL_HOST=127.0.0.1
    MAIL_PORT=2525
    MAIL_USERNAME=null
    MAIL_PASSWORD=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}"


Clear Cache the junk file 
- php artisan route:clear
- php artisan cache:clear
- php artisan config:clear
- php artisan optimize:clear


Database & Models
- In this event booking system, all models are connected to reflect real-world relationships: 
- User models include Events, Bookings, and Payments, where an Event is associated with a User and contains multiple Tickets. 
Each Ticket can have several Bookings from Users, with each Booking linked to a single Payment. 
The Payment is specifically associated with one Booking. These models correspond to migration tables (users, events, tickets, bookings, payments) 
that incorporate foreign key constraints to ensure data integrity and facilitate data management and querying.
- The login and registration are displayed in the user interface.
- php artisan migrate:fresh
- php artisan db:seed


Section 2: Authentication & Authorization
- install the sunctum in laravel 
- composer require laravel/sanctum
- php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
- The Sanctum function displays the token when the user logs in or registers, but the token is revoked when the user logs out.
- All the routes in auth.php is protected in middleware.
- The data is not showing in postman because the route or the endpoint is inside the middleware but the function is working.
- If the endpoint is outside of the middleware is get the data and showing into the postman.
- but the data is display and get perfectly 
- The validation of the data 
- All routes are role-based with middleware and validation: admins manage all events, organizers manage only their own events, 
and customers can book tickets and view their bookings, with authentication and input checks ensuring data integrity and secure access.

Section 3: API Development
( USER API )
- GET requests retrieve data (like userDetails) by reading from the database and returning it as a JSON response without changing anything.
POST requests create a new record (like AddUser), while PUT requests update an existing record (UpdateUser/{id}) by validating the input, 
modifying the stored data, and returning the updated result.

( Event APIs )
- The Event API enables the system to manage events through RESTful operations—using GET to retrieve event data, POST to create new records, PUT to update existing information, and DELETE to remove events—ensuring structured CRUD functionality and proper HTTP responses. A key challenge encountered is configuring Sanctum authentication within middleware, as Postman requests may default to CSRF-based web authentication and require correct token-based headers to avoid conflicts with @csrf protection. 



























