# SPC Hub

SPC Hub is a Laravel-based student community portal for St. Peter's College. It gives students one place to buy and sell items, report lost and found items, comment on posts, and privately message other students.

## Main Features

- User registration and login
- Logout and password reset
- Student profile information
- Buy & Sell marketplace
- Lost & Found reports
- Create, read, update, and delete posts
- Image uploads for products and reports
- Public comments and threaded replies
- Private Messenger-style conversations
- Private message replies and deletion
- Owner-only edit, resolve, and delete actions
- Responsive SPC Hub branding and campus portal design

## Technology Used

- Laravel 13
- PHP 8.3+
- Blade templates
- Laravel Eloquent ORM
- Laravel Breeze authentication
- SQLite or the configured database connection
- Tailwind CSS
- Vite
- Pest tests

## Project Structure

```text
app/
  Http/Controllers/       Application and authentication logic
  Http/Requests/          Reusable request validation
  Models/                 Database models and relationships
  View/Components/        Blade layout components

database/
  migrations/             Database table definitions
  factories/              Test data factories
  seeders/                Database seed data

resources/
  css/app.css             Centralized custom CSS classes
  js/app.js               Alpine and frontend setup
  views/                  Blade pages and reusable partials

routes/
  web.php                 Main application routes
  auth.php                Authentication routes

tests/
  Feature/                Application behavior tests
  Unit/                   Unit tests

public/
  images/                 Logo and campus images
  build/                  Generated production assets
```

## How Laravel Works in This Project

The application follows the MVC pattern:

1. A user visits a URL.
2. The route in `routes/web.php` selects a controller.
3. The controller validates input and calls a model.
4. The model communicates with the database through Eloquent.
5. The controller returns a Blade view or redirect.

Example flow:

```text
POST /buy-sell
    -> ProductController@store
    -> validate the form
    -> save Product
    -> redirect to the marketplace
```

## Important Models

### User

Stores account and student information. A user can have many products, Lost & Found reports, sent messages, and received messages.

### Product

Represents a Buy & Sell listing. It contains the title, description, price, category, condition, location, image, owner, and status.

### LostFoundPost

Represents a lost or found report. It contains the item type, item name, description, location, date, image, owner, and status.

### PostComment

Stores public comments. Comments use a parent relationship so users can reply to another comment.

### PrivateMessage

Stores private messages between two users. Messages are linked to the original product or Lost & Found post.

## CRUD Functionality

### Buy & Sell

- Create: `products.create` and `products.store`
- Read: `products.index` and `products.show`
- Update: `products.edit` and `products.update`
- Delete: `products.destroy`

### Lost & Found

- Create: `lost-found.create` and `lost-found.store`
- Read: `lost-found.index` and `lost-found.show`
- Update: `lost-found.edit` and `lost-found.update`
- Delete: `lost-found.destroy`

Users can only edit or delete their own posts. Lost & Found owners can also mark reports as resolved.

## Authentication

Authentication is provided by Laravel Breeze.

Authentication includes:

- Registration
- Login
- Logout
- Password reset
- Email verification routes
- Profile update
- Account deletion

Private application routes are protected with the `auth` middleware:

```php
Route::middleware('auth')->group(function () {
    // Protected SPC Hub routes
});
```

Passwords are hashed before they are saved. Forms use CSRF protection through `@csrf`.

## Authorization

The application checks ownership before allowing sensitive actions.

Example:

```php
if ($product->user_id !== Auth::id()) {
    abort(403);
}
```

This prevents another student from editing or deleting someone else's post.

## Comments and Private Messages

Comments are public and appear on the post details page. Users can reply to comments, and post owners can moderate comments on their own posts.

Private messages are visible only to the sender and recipient. Messages are grouped into Messenger-style conversations. Both participants can reply, and either participant can delete a message.

The shared interaction logic is handled by:

```text
InteractionController
PostComment model
PrivateMessage model
resources/views/partials/post-interactions.blade.php
resources/views/messages/index.blade.php
```

## CSS Organization

The source CSS is located at:

```text
resources/css/app.css
```

Reusable semantic classes are defined there, including:

```text
spc-panel
spc-card
spc-input
spc-button-primary
spc-button-secondary
form-panel
post-shell
interactions
messages-shell
```

Blade files mainly contain page structure, text, routes, and data. Generated files inside `public/build` should not be edited manually.

## Local Setup

The project requires PHP 8.3 or newer.

Install dependencies:

```powershell
composer install
npm install
```

Create the environment file if needed:

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

Run migrations:

```powershell
php artisan migrate
```

Build frontend assets:

```powershell
npm run build
```

Start the application using the Laragon PHP 8.3 executable:

```powershell
& 'C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe' artisan serve --host=127.0.0.1 --port=8000
```

Open:

```text
http://127.0.0.1:8000
```

## Testing

Run all tests:

```powershell
& 'C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64\php.exe' artisan test
```

The test suite covers authentication, CRUD, authorization, comments, replies, private messages, and deletion.

## Presentation Demo Flow

1. Open the SPC Hub portal.
2. Register a student account.
3. Log in and show the dashboard.
4. Create a Buy & Sell listing.
5. Edit the listing and show validation.
6. Open the listing details page.
7. Add a public comment.
8. Send a private message from another account.
9. Reply to the comment and private message.
10. Show the Messenger-style inbox.
11. Create a Lost & Found report.
12. Mark the report as resolved.
13. Delete a comment or message.
14. Log out and return to the SPC Hub portal.

## Short Presentation Explanation

> SPC Hub is a Laravel student community portal for St. Peter's College. It uses the MVC pattern. Routes receive requests, controllers process the logic, models communicate with the database through Eloquent, and Blade views display the interface.
>
> The system has authentication and protected routes. It supports full CRUD for Buy & Sell and Lost & Found posts. Users can comment publicly, reply to comments, send private messages, and continue conversations through a Messenger-style inbox.
>
> Ownership checks prevent users from editing or deleting posts that do not belong to them. Form validation, CSRF protection, password hashing, migrations, Eloquent relationships, and feature tests are used to keep the application reliable.

## Common Questions

### Why Laravel?

Laravel provides routing, authentication, validation, migrations, Eloquent ORM, middleware, storage, and testing tools in one consistent framework.

### Why use migrations?

Migrations define the database structure in code. They make the database reproducible and easier to update.

### How is CRUD implemented?

Controllers provide create, read, update, and delete actions. Routes connect those actions to forms and pages.

### How do you protect user data?

Authentication middleware protects private routes. Ownership checks protect posts. Private messages are only shown to their participants.

### How are forms protected?

Forms use Laravel validation and CSRF tokens. Uploaded images are validated for file type and size.

### Where is the custom CSS?

The source CSS is in `resources/css/app.css`. The files in `public/build` are generated by Vite.
#   N a r a _ S P C - H u b - P o r t a l  
 