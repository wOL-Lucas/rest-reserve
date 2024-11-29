### Endpoints

## Restaurant Related

Register restaurant
```
MANAGER PRIVILEGES REQUIRED

POST /restaurant

Content-Type: multipart/form-data
Authorization: Bearer <token>

  formData.append('name', 'Restaurant Name');
  formData.append('description', 'Restaurant Description');
  formData.append('user_id', 1);
  formData.append('address.street', '123 Main St');
  formData.append('address.zip_code', '12345678');
  formData.append('address.neighborhood', 'Downtown');
  formData.append('address.state', 'CA');
  formData.append('address.city', 'Los Angeles');
  formData.append('address.country', 'USA');
  formData.append('address.complement', 'Suite 100'); (OPTIONAL)
  formData.append('address.number', 123);
  formData.append('mainImage', mainImageFile);

Additional images could be send with any field name, example:

  formData.append('0', additionalImage1);
  formData.append('1', additionalImage2);
```

Get all restaurants without details
```
OPEN ENDPOINT

GET /restaurant

Content-Type: application/json
```

Get restaurant details
```
OPEN ENDPOINT

GET /restaurant/{restaurant_id}

Content-Type: application/json
```

Update restaurant details
```
MANAGER PRIVILEGES

PATCH /restaurant

Content-Type: application/json
Authorization: Bearer <token>

  {
    "id": 1,
    "name": "Updated",
    "description": "Some new description"
  }
```

Delete restaurant
```
MANAGER PRIVILEGES

DELETE /restaurant/{restaurant_id}

Content-Type: application/json
Authorization: Bearer <token>
```

## Address Related

Register another address
```
MANAGER PRIVILEGES

POST /address

Content-Type: application/json
Authorization: Bearer <token>

  {
    "restaurant_id": 1,
    "street": "Some two",
    "zip_code": "89340000",
    "neighborhood": "Neighborhood",
    "state": "SC",
    "city": "Itaiópolis",
    "country": "Brasil",
    "complement": "Some Complement" (OPTIONAL),
    "number": 23
  }
```

Get all addresses by restaurant
```
MANAGER PRIVILEGES

GET /address/restaurant/{restaurant_id}

Content-Type: application/json
Authorization: Bearer <token>
```

Update address
```
MANAGER PRIVILEGES

PATCH /address

Content-Type: application/json
Authorization: Bearer <token>

  { 
    "id": 1,
    "street": "Some two",
    "zip_code": "89340000",
    "neighborhood": "Neighborhood",
    "state": "SC",
    "city": "Itaiópolis",
    "country": "Brasil",
    "complement": "Some Complement" (OPTIONAL),
    "number": 23
  }
```

Delete address
```
MANAGER PRIVILEGES

DELETE /address/{address_id}

Content-Type: application/json
Authorization: Bearer <token>
```

## Menu Related

Register menu
```
MANAGER PRIVILEGES

POST /menu

Content-Type: multipart/form-data
Authorization: Bearer <token>

  const menuItems = [
    {
      name: 'Menu Item 1',
      description: 'Description for Menu Item 1',
      price: 19.99,
      image: ImageFile
    },
    {
      name: 'Menu Item 2',
      description: 'Description for Menu Item 2',
      price: 29.99,
      image: ImageFile
    }
  ];

  formData.append('restaurant_id', 1);
  menuItems.forEach((item, index) => {
      formData.append(`menuItems[${index}][name]`, item.name);
      formData.append(`menuItems[${index}][description]`, item.description);
      formData.append(`menuItems[${index}][price]`, item.price);
      formData.append(`menuItems[${index}][image]`, item.image);
    }
  )
```

Add item to menu
```
MANAGER PRIVILEGES

POST /menu/item

Content-Type: multipart/form-data
Authorization: Bearer <token>

  const menuItems = [
    {
      name: 'Menu Item 1',
      description: 'Description for Menu Item 1',
      price: 19.99,
      image: ImageFile
    },
    {
      name: 'Menu Item 2',
      description: 'Description for Menu Item 2',
      price: 29.99,
      image: ImageFile
    }
  ];

  formData.append('menu_id', 1);
  menuItems.forEach((item, index) => {
      formData.append(`menuItems[${index}][name]`, item.name);
      formData.append(`menuItems[${index}][description]`, item.description);
      formData.append(`menuItems[${index}][price]`, item.price);
      formData.append(`menuItems[${index}][image]`, item.image);
    }
  )
```

Delete menu
```
MANAGER PRIVILEGES

DELETE /menu/{menu_id}

Content-Type: application/json
Authorization: Bearer <token>
```

Delete menu item
```
MANAGER PRIVILEGES

DELETE /menu/item/{item_id}

Content-Type: application/json
Authorization: Bearer <token>
```

## Review Related

Register restaurant review
```
LOGGED USER PRIVILEGES

POST /review

Content-Type: application/json
Authorization: Bearer <token>

  {
    "user_id": 1,
    "user_name": "James",
    "restaurant_id": 1,
    "review": "Very nice",
    "rating": "5"
  }
```

Get all reviews by restaurant
```
OPEN ENDPOINT

GET /review/restaurant/{restaurant_id}

Content-Type: application/json
```

Update review
```
LOGGED USER PRIVILEGES

PATCH /review

Content-Type: application/json
Authorization: Bearer <token>

  {
    "id": 1,
    "review": "Sucks",
    "rating": "1"
  }
```

Delete review
```
LOGGED USER PRIVILEGES

DELETE /review/{review_id}

Content-Type: application/json
```