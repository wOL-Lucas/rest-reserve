### Endpoints

REGISTER RESERVE

```
POST /reserves

{
    "user_id": 1,
    "restaurant_id": 2,
    "reservation_date": "2023-12-25",
    "reservation_time": "19:00",
    "number_of_people": 4,
    "observation": "Window seat, please"
}
```

CANCEL RESERVE

```
PUT /reserves/{id}
```

GET ALL RESERVES BY USER_ID

```
GET /reserves/user/{id}
```

GET ALL RESERVES BY RESTAURANT_ID
```
GET /reserves/restaurant/{id}
```