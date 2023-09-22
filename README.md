# API CASE Installation Steps
-  Clone Project
-  Copy .env.example as .env and edit it according to your needs
-  composer install
-  php artisan key:generate
-  composer update
-  php artisan migrate
-  php artisan db:seed
-  php artisan spotify:cron
-  php artisan l5-swagger:generate  

##  User Authentication
###  Register User
```php 
Endpoint: /api/auth/register
Method: POST
Request Body:
Name (string)
Email (string)
Phone (string)
Password (string)
Description: Register a new user with the provided information.
```
###  User Login
```php 
Endpoint: /api/auth/login
Method: POST
Request Body:
Email (string)
Password (string)
Description: Authenticate the user and provide an access token for future API requests.
```
User Profile Management
###  My Profile
```php 
Endpoint: /api/user/my-profile
Method: GET
Authentication: Bearer Token
Description: Retrieve the user profile information.
```
###  Change Profile Photo
```php 
Endpoint: /api/user/update/image
Method: POST
Authentication: Bearer Token
Request Body: Multipart Form Data (Image Upload)
Description: Allow users to update their profile photo.
```

## Spotify Integration
###  Get Artist's Tracks
```php 
Endpoint: /api/artist/{artistID}/tracks
Method: GET
Authentication: Bearer Token
Path Parameter: artistID (string)
Query Parameter: per_page (integer, optional)
Description: Retrieve a paginated list of tracks by a specific artist.
```

###  Get Artist's Albums
```php 
Endpoint: /api/artist/{artistID}/albums
Method: GET
Authentication: Bearer Token
Path Parameter: artistID (string)
Query Parameter: per_page (integer, optional)
Description: Retrieve a paginated list of albums by a specific artist.
```
###  Get Genres by Artist
```php 
Endpoint: /api/artist/{artistID}/genres
Method: GET
Authentication: Bearer Token
Path Parameter: artistID (string)
Query Parameter: genre (string, optional) (e.g., "Turkish Rap")
Query Parameter: per_page (integer, optional) (default: 10)
Description: Retrieve a paginated list of genres associated with a specific artist. Optionally filter by genre name.
```

###  Cron Job

###  Track Count Change Notification
```php 
Cron Schedule: Every 30 minutes
Command: php artisan php artisan spotify:cron
Description: Run a cron job to check if the number of tracks for an artist has changed on Spotify. If a change is detected, send an email notification or log the change.
``` 

