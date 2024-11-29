### Endpoints

Register reserve

```
LOGGED USER PRIVILEGES

POST /reserves

Content-Type: application/json
Authorization: Bearer <token>

  {
    "user_id": 1,
    "restaurant_id": 2,
    "reservation_date": "2023-12-25",
    "reservation_time": "19:00",
    "number_of_people": 4,
    "observation": "Window seat, please"
  }
```

Cancel Reserve
```
LOGGED USER PRIVILEGES

PUT /reserves/{id}

Content-Type: application/json
Authorization: Bearer <token>
```

Get all reserves by user_id

```
LOGGED USER PRIVILEGES

GET /reserves/user/{user_id}

Content-Type: application/json
Authorization: Bearer <token>
```

Get all reserves by restaurant_id
```
MANAGER PRIVILEGES

GET /reserves/restaurant/{restaurant_id}

Content-Type: application/json
Authorization: Bearer <token>
```