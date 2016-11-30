Yii 2 Test Task RESTful  API
============================


INSTALLATION
------------

1. Unpack project.
2. Init environments by command `php init`.
3. Configure DB: Edit the file `config/common-local.php` with real data
4. Run migration: `php yii/migrate`
5. Create user `php user/add-user admin admin@localhost.ru password`. See user's `access_token` in DB for next tests.

RESTful TESTING
---------------

### Non-auth request
```
>curl -i -H "Accept:application/json" "http://yii2-test-rest.localhost/api/v1/cities"
HTTP/1.1 401 Unauthorized
Date: Wed, 30 Nov 2016 10:34:45 GMT
Server: Apache/2.4.23 (Win64) PHP/7.0.8
X-Powered-By: PHP/7.0.8
Www-Authenticate: Bearer realm="api"
Content-Length: 165
Content-Type: application/json; charset=UTF-8

{
    "status": "error",
    "errors": [
        {
            "message": "You are requesting with an invalid credential.",
            "code": 401
        }
    ]
}
```

### LIST
```
>curl -i -H "Accept:application/json" "http://yii2-test-rest.localhost/api/v1/cities?access-token=QA8qhjioBrKQkag5ZHad0B1DYky9y4pC"

HTTP/1.1 200 OK
Date: Wed, 30 Nov 2016 08:48:03 GMT
Server: Apache/2.4.23 (Win64) PHP/7.0.8
X-Powered-By: PHP/7.0.8
X-Pagination-Total-Count: 3
X-Pagination-Page-Count: 1
X-Pagination-Current-Page: 1
X-Pagination-Per-Page: 20
Link: <http://yii2-test-rest.localhost/api/v1/cities?page=1>; rel=self
Content-Length: 676
Content-Type: application/json; charset=UTF-8

[
    {
        "id": 1,
        "name": "Barnaul",
        "country": {
            "id": 1,
            "name": "Russia"
        },
        "region": {
            "id": 1,
            "name": "Altai region"
        }
    },
    {
        "id": 2,
        "name": "Biysk",
        "country": {
            "id": 1,
            "name": "Russia"
        },
        "region": {
            "id": 1,
            "name": "Altai region"
        }
    },
    {
        "id": 3,
        "name": "Barnaul",
        "country": {
            "id": 1,
            "name": "Russia"
        },
        "region": {
            "id": 2,
            "name": "Kurgan region"
        }
    }
]
```

### ITEM
```
>curl -i -H "Accept:application/json" "http://yii2-test-rest.localhost/api/v1/cities/1?access-token=QA8qhjioBrKQkag5ZHad0B1DYky9y4pC"

HTTP/1.1 200 OK
Date: Wed, 30 Nov 2016 08:48:28 GMT
Server: Apache/2.4.23 (Win64) PHP/7.0.8
X-Powered-By: PHP/7.0.8
Content-Length: 175
Content-Type: application/json; charset=UTF-8

{
    "id": 1,
    "name": "Barnaul",
    "country": {
        "id": 1,
        "name": "Russia"
    },
    "region": {
        "id": 1,
        "name": "Altai region"
    }
}
```

### CREATE with error validation
```
>curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST "http://yii2-test-rest.localhost/api/v1/cities?access-token=QA8qhjioBrKQkag5ZHad0B1DYky9y4pC" -d '{"name": "city"}'

HTTP/1.1 422 Data Validation Failed.
Date: Wed, 30 Nov 2016 08:50:57 GMT
Server: Apache/2.4.23 (Win64) PHP/7.0.8
X-Powered-By: PHP/7.0.8
Content-Length: 90
Content-Type: application/json; charset=UTF-8

[
    {
        "field": "region_id",
        "message": "Region cannot be blank."
    }
]
```

### CREATE
```
>curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPOST "http://yii2-test-rest.localhost/api/v1/cities?access-token=QA8qhjioBrKQkag5ZHad0B1DYky9y4pC" -d '{"name": "city","region_id":2}'

HTTP/1.1 201 Created
Date: Wed, 30 Nov 2016 08:51:16 GMT
Server: Apache/2.4.23 (Win64) PHP/7.0.8
X-Powered-By: PHP/7.0.8
Location: http://yii2-test-rest.localhost/api/v1/cities/4
Content-Length: 173
Content-Type: application/json; charset=UTF-8

{
    "id": 4,
    "name": "city",
    "country": {
        "id": 1,
        "name": "Russia"
    },
    "region": {
        "id": 2,
        "name": "Kurgan region"
    }
}
```

### UPDATE

```
>curl -i -H "Accept:application/json" -H "Content-Type:application/json" -XPUT "http://yii2-test-rest.localhost/api/v1/cities/4?access-token=QA8qhjioBrKQkag5ZHad0B1DYky9y4pC" -d '{"name": "city2","region_id":1}'
HTTP/1.1 200 OK
Date: Wed, 30 Nov 2016 08:51:57 GMT
Server: Apache/2.4.23 (Win64) PHP/7.0.8
X-Powered-By: PHP/7.0.8
Content-Length: 173
Content-Type: application/json; charset=UTF-8

{
    "id": 4,
    "name": "city2",
    "country": {
        "id": 1,
        "name": "Russia"
    },
    "region": {
        "id": 1,
        "name": "Altai region"
    }
}
```

### DELETE
```
>curl -i -H "Accept:application/json" -XDELETE "http://yii2-test-rest.localhost/api/v1/cities/4?access-token=QA8qhjioBrKQkag5ZHad0B1DYky9y4pC"
HTTP/1.1 204 No Content
Date: Wed, 30 Nov 2016 08:52:24 GMT
Server: Apache/2.4.23 (Win64) PHP/7.0.8
X-Powered-By: PHP/7.0.8
Content-Length: 0
Content-Type: application/json; charset=UTF-8

```


### Distance check

Адрес: Москва,Тверская 6

Координата: 55.762410, 37.609169 ( Москва,Тверская 8)

Радиус: 0.3 км
```
>curl -i -H "Accept:application/json" "http://yii2-test-rest.localhost/api/v1/geo/address-in-radius?address=Москва,Тверская+6&lat=55.762410&long=37.609169&r=0.3
HTTP/1.1 200 OK
Date: Wed, 30 Nov 2016 11:47:53 GMT
Server: Apache/2.4.23 (Win64) PHP/7.0.8
X-Powered-By: PHP/7.0.8
Content-Length: 291
Content-Type: application/json; charset=UTF-8

{
    "query": "Москва,Тверская 6",
    "address": "Россия, Москва, Тверская улица, 6с1",
    "lat": 55.760241,
    "long": 37.611347,
    "point": {
        "lat": 55.76241,
        "long": 37.609169
    },
    "distance": 0.277,
    "result": true
}
```