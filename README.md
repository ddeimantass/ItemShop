## Item shop

### Build and Run

- Build and run containers
```
docker-compose up --build -d
```

- Enter web container and run migrations
```
docker exec -it web bash
bin/console d:d:c
bin/console d:m:m -n
bin/console d:f:l -n
```

### Run Tests

- Run tests inside web container
```
bin/phpunit 
```

### API

#### reduce item quantity Endpoint

- Method: GET
- URI: /api/item/{id}/reduce
- Success response code: 200 
