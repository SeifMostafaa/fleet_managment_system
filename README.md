## Tech Stack
- Language: PHP 8.2.1
- Framework: Laravel 9.48.0
- DB: SQLite
- Authentication: Sanctum
- Unit-Testing: PHPUnit

## Prerequisites

- PHP 8
- Laravel 9
- Composer

## Getting Started

- Install composer packages ```composer install``` (You may need to update composer packages ```composer update```)
- Create database.sqlite file inside the database folder (Accept this option when running the next step )
- ```php artisan migrate```
- ```php artisan db:seed --class=DatabaseSeeder```
- ```php artisan serve```



## API Reference

### Endpoints
* Note: When testing APIs, make sure you add "Accept: application/json" in your request header 

#### POST /api/register (Public)

* General: Signing up a new user
* Sample: `curl http://localhost:8000/api/register`
  * Message body:
    ```
           {
              "name": "Seif",
              "email": "Seif@gmail.com",
              "password": "password",
              "password_confirmation": "password"
           }
    ```
* Return:
  ```
        {
            "user": {
                      "name": "Seif",
                      "email": "Seif@gmail.com",
                      "updated_at": "2023-01-31T17:48:24.000000Z",
                      "created_at": "2023-01-31T17:48:24.000000Z",
                      "id": 2
            },
            "token": "2|UfQAyKogrZtTbNLG5cYAUbvNlF5boryGW4apE3OI"
        }
   ```
* If user already exists:
  ```
      {
           "message": "Email already exists"
      }
  ```
* Make sure to use the token as Bearer authenticity token


#### POST /api/login (Public)

* General: Logging an existing user
* Sample: `curl http://localhost:8000/api/login`
* Message body:
  ```
        {
            "email": "seif@robusta.com",
            "password": "seif@robusta.com"
        }
  ```
* Return:
  ```
    {
        "user": {
            "id": 1,
            "name": "seif",
            "email": "seif@robusta.com",
            "email_verified_at": null,
            "created_at": null,
            "updated_at": null
        },
        "token": "3|toPW30ts9o9VJX6RdgRt3ivtXY7MX8QAu6rW9WD0"
    }
   ```
* Make sure to use the token as Bearer authenticity token


#### GET /api/trips (Authenticated)

* General: Returns a list trips that fall in a given range.
* Sample: `curl http://localhost:8000/api/trips`
* Message body:
```
{
    "start_station": "Cairo",
    "end_station": "Asyut"
} 
```
* Return:
```
[
    {
        "trip_id": 2,
        "bus_id": 9,
        "start_station": "Cairo",
        "end_station": "Asyut",
        "available_seats": 12,
        "start_trip_order": 1,
        "end_trip_order": 6
    },
    {
        "trip_id": 4,
        "bus_id": 3,
        "start_station": "Cairo",
        "end_station": "Luxor",
        "available_seats": 12,
        "start_trip_order": 1,
        "end_trip_order": 11
    }
]
```

#### POST /api/book (Authenticated)

* General: Booking a specific trip providing start_station, end_station and trip_id
* Sample: `curl http://localhost:8000/api/book`
* Message body:
  ```
         {
	        "start_station": "Cairo",
	        "end_station": "Luxor",
            "trip_id": 4
        }
  ```
* Return (If seats available):
  ```
    {
	    "success": "Trip booked successfully"
    }
   ```
* If no seats available:
  ```
  {
    "error": "404",
    "message": "No trips found"
  }
  ```



#### POST /api/logout (Authenticated)

* General: Logging current user out
* Sample: `curl http://localhost:8000/api/logout`
* Return:
  ```
    {
        "message": "Logged out",
        "status": 200
    }
   ```
* If user already logged out (no current user logged in) :
  ```
    {
    "message": "Unauthenticated."
    }
   ```


### Error Handling

Errors are returned as JSON and are formatted in the following manner:<br>
```
    {
        "error": "404",
        "message": "No available seats"
    }
``` 
```
    {
        "error": "404",
        "message": "Station not found"
    }
```

```
    {
        "error": "404",
        "message": "No trips found with this id, fetch trips to find a suitable trip id"
    }
```
```
    {
        "error": "401"
        "message": "Unauthenticated."
    }
```
Example errors the user may encounter:

* 400 – bad request
* 404 – resource not found
* 401 – Unauthenticated

## Unit Testing
However unit testing is a simple way of testing if the things work right logically.
Yet, it's an important part for any developer to make sure he is on the right track 

To run all unit tests: ```php artisan test```


#### Authentication Unit Testing
| UnitTest                        |                  Description                 | Expected Return |
| ------------------------------- | ---------------------------------------------|-----------------|
|test_register_happy_scenario     | Tests creating account with valid data       |     201         |
|test_register_existing_email     | Tests creating account with duplicate data   |     404         |

#### Booking Unit Testing
| UnitTest                           |                  Description                 | Expected Return |
| ---------------------------------- | ---------------------------------------------|-----------------|
|test_booking_without_authentication | Tests booking without authentication         |     401         |
|test_booking_happy_scenario         | Tests fetching trips using Bearer token      |     200         |
|test_booking_no_available_seet      | Tests fetching trips without available seets |     404         |
|test_booking_non_existing_trip      | Tests booking with a non existing stations   |     404         |
|test_booking_non_existing_trip_id   | Tests booking with a non existing trip id    |     404         |


#### Trip Fetching Unit Testing

| UnitTest                                  |                  Description                     | Expected Return |
| ------------------------------------------| -------------------------------------------------|-----------------|
|test_fetching_trips_without_authentication | Tests fetching trips without authentication      |     401         |
|test_fetching_trips_happy_scenario         | Tests fetching trips using Bearer token          |     200         |
|test_fetching_trips_non_existing_stations  | Tests fetching trips with a non exsiting stations|     404         |
