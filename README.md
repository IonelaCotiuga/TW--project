# M-PIC
The website is online at the following address: <a href="https://mpic-app.herokuapp.com/">https://mpic-app.herokuapp.com/</a>
The link to the video : <a href="https://youtu.be/zYxAERLqYnI">https://youtu.be/zYxAERLqYnI</a>

Alternatively, if you wish to run the website locally, you can follow these steps:
1. Rename the `src` folder to `MPic`
2. Move it into your `xampp/htdocs` directory
3. Create a MySQL database named `mpic_users`, and run the commands found in the `util/create_database.php` file
4. Access the website at `https://localhost/MPic`

## API Documentation
This API allows users to register new accounts, get new JWT tokens, and view the images they've edited or created using the M-Pic app.

It can be found at `https://mpic-app.herokuapp.com/api`

### Create user
POST `/signup.php`

Allows you to register a new account.

The request body needs to be in JSON format and include the following properties:
- `username` - String - Can only contain English alphabet letters and numbers
- `email` - String - A valid address, not used by another account
- `password` - String

Example
```
POST /signup.php
{
    "username": "testuser",
    "email": "example@host.com",
    "password": "Password123"
}
```

### Log in
POST `/login.php`

Allows you to obtain a new JWT bearer token.

The request body needs to be in JSON format and include the following properties:
- `username` - String - Can be either username or e-mail
- `password` - String

Example
```
POST /login.php
{
    "username": "testuser",
    "password": "Password123"
}
```

### View images
GET `/images.php`

Allows you to view all of the images you have edited (or created) using the app. Requires authentication.

Example
```
GET /images.php
Authorization: Bearer <YOUR TOKEN>
```
