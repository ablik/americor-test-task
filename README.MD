I packaged the application in a docker-compose, so to test it, just run the container:

```
docker-compose up --build -d
```

The application hangs on port 8000 (no UI, only API endpoint)

```
http://localhost:8000
```

Also I added mailhog container on port 8025 to check email notifier

```
http://localhost:8025
```

Added few unit tests and code analyzers (psalm, phpstan, deptrac), so you can check it:
```
docker-compose exec app php bin/phpunit

docker-compose exec app vendor/bin/psalm
docker-compose exec app vendor/bin/phpstan analyse
docker-compose exec app vendor/bin/deptrac analyse
```


## Endpoints to check applications work

#### Create new user
```
curl -X POST --location "http://127.0.0.1:8000/customers" \
    -H "Content-Type: application/json" \
    -d '{
          "firstName": "John",
          "lastName": "Doe",
          "age": 30,
          "city": "LA",
          "state": "CA",
          "zipCode": "12345",
          "ssn": "123-45-6789",
          "fico": 600,
          "email": "john.doe@example.com",
          "phoneNumber": "555-555-5555"
        }'
```

#### Update customer
```
curl -X PUT --location "http://127.0.0.1:8000/customers/123-45-6789" \
-H "Content-Type: application/json" \
-d '{
      "firstName": "John",
      "lastName": "Doe",
      "age": 31,
      "city": "LA",
      "state": "CA",
      "zipCode": "12345",
      "fico": 600,
      "email": "john.doe@example.com",
      "phoneNumber": "555-555-5555"
    }'
```

#### Check loan eligibility
```
curl -X POST --location "http://127.0.0.1:8000/loans/check-eligibility" \
-H "Content-Type: application/json" \
-d '{
      "ssn": "123-45-6789",
      "monthlyIncome": 1000
    }'
```

#### Check loan eligibility
```
curl -X POST --location "http://127.0.0.1:8000/loans/issue" \
-H "Content-Type: application/json" \
-d '{
      "ssn": "123-45-6789",
      "productName": "Medical Debt",
      "term": 12,
      "amount": 50000
    }'
```

or JetBrains [request](rest-api.http) file