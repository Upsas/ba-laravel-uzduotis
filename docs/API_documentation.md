## Api documentation ##

Postman Api documentation: https://documenter.getpostman.com/view/11525094/TzzGHtpM

### First login or register via API request ###

#### Login
```
curl --location -g --request POST 'http://localhost/api/login' \
--header 'Accept: application/json' \
--data-urlencode 'email=test@gmail.com' \
--data-urlencode 'password=password'
```

#### Register
```
curl --location -g --request POST 'http://localhost/api/register' \
--header 'Accept: application/json' \
--data-urlencode 'name=testas' \
--data-urlencode 'email=testas@gmail.com' \
--data-urlencode 'password=password' \
--data-urlencode 'password_confirmation=password'
```

### You will get response with token:

```
    "user": {
        "name": "testas",
        "email": "testas@gmail.com",
        "updated_at": "2021-08-26T12:20:42.000000Z",
        "created_at": "2021-08-26T12:20:42.000000Z",
        "id": 12
    },
    "token": "6UTlRPpWCv0xsyK0LdT3aoOB1CWB3BeBCC"
```

### Token will be used to authenticate

#### For example get all user contacts:

```
curl --location -g --request GET 'http://localhost/api/contacts' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}'
```

#### Get one contact:

```
curl --location -g --request GET 'http://localhost/api/contacts/{id}' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}'
```

#### Search contact by number or name:

```
curl --location -g --request GET 'http://localhost/api/contacts/search/{searchValue}' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}'
```

#### Create contact:

```
curl --location -g --request POST http://localhost/api/contacts' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}' \
--data-urlencode 'name=testas' \
--data-urlencode 'number=867598989'
```

#### Delete contact (also deletes if shared with someone):

```
curl --location -g --request DELETE 'http://localhost/api/contacts/{contactId}' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}'
```

#### Edit contact:

```
curl --location -g --request PUT 'http://localhost/api/contacts/{contactId}' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}' \
--data-urlencode 'name=testas' \
--data-urlencode 'number=86759898'
```

#### Get all shared contacts:

```
curl --location -g --request GET 'http://localhost/api/sharedContacts' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}'
```

#### Delete shared contact:

```
curl --location -g --request GET 'http://localhost/api/sharedContacts' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}'
```

#### Get all users to share contact with:

```
curl --location -g --request GET 'http://localhost/api/sharedContacts/users' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}'
```

#### Share contact:

```
curl --location -g --request POST 'http://localhost/api/sharedContacts/share/{contactId}/{userIdToShareWith}' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}'
```

#### Add shared contact (you can add contacts shared with you):

```
example:
"id": 63,
"ContactName": "Ashly Daniel",
"number": "(248) 980-8823",
"Contact Shared With": "ME From: test"
```

```
curl --location -g --request POST ''http://localhost/api/sharedContacts/add/{sharedContactWithMeId}' \
--header 'Accept: application/json' -H 'Authorization: Bearer {token}'
```