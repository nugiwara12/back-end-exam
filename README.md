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

( Ticket APIs )
- The Ticket APIs manage the creation and control of ticket inventory for each event. After an event is created, organizers define ticket types (e.g., VIP, Regular) including pricing and available quantity. These APIs ensure that tickets are directly linked to their event and that only authorized organizers can modify them. Updating tickets allows organizers to adjust pricing or availability, while deletion removes ticket offerings if necessary. This module functions similarly to product inventory in an e-commerce platform, ensuring that ticket stock is accurately tracked before customers attempt to reserve them.

( Booking APIs )
- The Booking APIs allow customers to reserve tickets for events. When a customer books a ticket, the system validates availability, deducts the ticket quantity, and creates a booking record tied to that user. Customers can then retrieve a list of their bookings to track attendance or manage reservations. If plans change, a cancellation endpoint updates the booking status without deleting the record, preserving transaction history. These APIs enforce ownership rules so customers only access their own bookings, forming the core interaction layer between users and the ticket inventory.

( Payment APIs )
- The Payment APIs finalize the transaction process by simulating a payment workflow. After a booking is made, customers submit a payment request, and the system records a mock payment entry while marking the booking as paid. This step imitates real-world payment gateway integration, even though no actual financial transaction occurs. Users can later retrieve payment details for confirmation or record-keeping. These APIs complete the system’s flow by transforming a reservation into a confirmed purchase, ensuring traceability between bookings and their corresponding payments.





















