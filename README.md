# HelloFresh Senior Backend Developer Test

## Author

Carlos Gonser <carlosgonser [at] gmail [dot] com>

## Technology

- PHP 7.2
- PostgreSQL for data persistency
- Redis for level 2 caching with Doctrine

## Requirements

- Docker

## Instructions

1. Clone this repository.
2. Type `docker-compose up -d`

### Endpoints

This application provides the following endpoint structure

#### Recipes

| Name   | Method      | URL                    | Protected |
| ---    | ---         | ---                    | ---       |
| List   | `GET`       | `/recipes`             | ✘         |
| Create | `POST`      | `/recipes`             | ✓         |
| Get    | `GET`       | `/recipes/{id}`        | ✘         |
| Update | `PUT/PATCH` | `/recipes/{id}`        | ✓         |
| Delete | `DELETE`    | `/recipes/{id}`        | ✓         |
| Rate   | `POST`      | `/recipes/{id}/rating` | ✘         |
| Search | `POST`      | `/recipes/search`      | ✘         |

For convenience, this project contains a sample Postman Collection and a Swagger File with all its endpoints.

- [Postman Collection](doc/Hellofresh Recipe API.postman_collection.json)
- [Swagger File](doc/swagger.yaml)

#### Authentication

For the endpoints which require authentication, an additional header must be provided with the following format:

`Authorization: Basic dXNlcjpwYXNz`

The token can be generated with the following command:

`echo -n <USERNAME>:<PASSWORD> | base64`

For testing purposes, this app accepts the following username and password combination

- Username: `user`
- Password: `pass`
