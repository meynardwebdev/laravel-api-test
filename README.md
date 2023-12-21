# Laravel REST API


## Overview
****
This is a test laravel project for restful API


## Prerequisites
****

1. PHP 8.1 or higher
2. Sqlite
3. Composer


## Setting up local environment
****

1. Install project dependencies
    ```shell
    composer install
    ```

2. Run database migration and seeder
    ```shell
    php artisan migrate --seed
    ```

3. Run Laravel's local web server
    ```shell
    php artisan serve
    ```


## API endpoints
****
**Use Postman or your favorite API platform**

1. **GET /api/products**: Retrieve a list of products with their reviews.
   
    Sample API response:

    ```json
    {
        "success": true,
        "data": [
            {
                "id": 1,
                "name": "Yvonne Abernathy PhD",
                "description": "Amet sed perspiciatis ea sed. Id adipisci corrupti maiores. Dolores dolore totam dolore veritatis. Officia et est ducimus magnam rerum qui.",
                "price": 161.01,
                "reviews": [],
                "created_at": "21/12/2023",
                "updated_at": null
            },
            {
                "id": 2,
                "name": "Dr. Zion Stamm",
                "description": "Voluptatem voluptatibus quo veniam et asperiores atque ipsam. Dignissimos et aperiam numquam adipisci eos est eos. Cumque quasi et dolor aut non nemo. Ut et maxime et et qui maiores incidunt est.",
                "price": 976.75,
                "reviews": [
                    {
                        "id": 5,
                        "product_id": 2,
                        "user_name": "vharber",
                        "rating": 2,
                        "comment": "That's all.' 'Thank you,' said Alice, in a Little Bill It was as much as she spoke. (The unfortunate little Bill had left off when they liked, and left off sneezing by this time?' she said to Alice.",
                        "created_at": "21/12/2023",
                        "updated_at": null
                    }
                ],
                "created_at": "21/12/2023",
                "updated_at": null
            },
            ...
        ],
        "message": "Product list has been retrieved."
    }
    ```

2. **GET /api/products/{id}**: Retrieve a list of products with their reviews.

   Sample API response:

    ```json
    {
        "success": true,
        "data": {
            "id": 1,
            "name": "Yvonne Abernathy PhD",
            "description": "Amet sed perspiciatis ea sed. Id adipisci corrupti maiores. Dolores dolore totam dolore veritatis. Officia et est ducimus magnam rerum qui.",
            "price": 161.01,
            "reviews": [],
            "created_at": "21/12/2023",
            "updated_at": null
        },
        "message": "Product info has been retrieved."
    }
    ```

3. **POST /api/products**: Create a new product.

   Sample API request:

    ```json
    {
        "name": "Nike T-shirt",
        "description": "Nike T-shirt for man",
        "price": 19.99
    }
    ```

   Sample API response:

    ```json
    {
        "success": true,
        "data": {
            "id": 2,
            "name": "Nike T-shirt 123",
            "description": "Nike T-shirt for man 123",
            "reviews": [],
            "created_at": "21/12/2023",
            "updated_at": "21/12/2023"
        },
        "message": "Product has been created."
    }
    ```

4. **POST /api/products/{id}/reviews**: Create a review for a specific product.

    Sample API request: /api/products/1/reviews

    ```json
    {
        "rating": 5,
        "comment": "Item is good",
        "user_name": "anonymous",
        "created_at": "2023-12-19 10:10:10"
    }
    ```

    Sample API response:

    ```json
    {
        "success": true,
        "data": {
            "id": 1,
            "product_id": "1",
            "user_name": "anonymous",
            "rating": 5,
            "comment": "Item is good",
            "created_at": "21/12/2023",
            "updated_at": "21/12/2023"
        },
        "message": "Product review has been created."
    }
    ```

5. **PUT /api/products/{id}**: Update an existing product.

   Sample API request: PUT /api/products/1

    ```json
    {
        "name": "New product name",
        "description": "New ",
        "price": 29.99
    }
    ```

   Sample API response:

    ```json
    {
        "success": true,
        "data": {
            "id": 1,
            "name": "New product name",
            "description": "New ",
            "price": 29.99,
            "reviews": [],
            "created_at": "21/12/2023",
            "updated_at": "21/12/2023"
        },
        "message": "Product has been updated."
    }
    ```

6. **DELETE /api/products/{id}**: Delete a product.

   Sample API request: DELETE /api/products/1
   Sample API response:
    ```json
    {
        "success": true,
        "data": [],
        "message": "Product has been deleted."
    }
    ```


## Unit Tests
****

Run the unit test by running the command below:

```shell
php artisan test
```
