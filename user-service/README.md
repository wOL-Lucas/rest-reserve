### Endpoints

# User Related

Register User
```
OPEN ENDPOINT

POST /user

Content-Type: multipart/form-data

  formData.append('first_name', 'James');
  formData.append('last_name', 'Bond');
  formData.append('email', 'james@email.com');
  formData.append('password', '12345678');
  formdata.append('role', 'user') (OPTIONS: user for normal users and manager for restaurant owners)
  formData.append('user_image', imageFile);
```

Get user details
```
LOGGED USER OR MANAGER PRIVILEGES

GET /user/{user_id}

Content-Type: application/json
```

## Auth Related

Login
```
OPEN ENDPOINT

POST /login

Content-Type: application/json

  {
    "email": "james@email.com",
    "password": "123456"
  }
```