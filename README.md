# MessageAkoh

MessageAkoh is a Restful API. build with PHP (<a href="https://www.slimframework.com/">Slim Framework</a>) & DB Mysql.


## Table of Contents

- [Requirements](#Requirements)
- [Setting Database](#setting-database)
- [Running the Project](#running-the-project)
- [How To Use](#how-to-use)
	- [1. API for sending a message](#api-for-sending-a-message)
	- [2. API for collect message that has been sent out](#api-for-collect-message-that-has-been-sent-out)
	- [3. API for display message in real time](#api-for-display-message-in-real-time)
 


## Requirements ##

* PHP 5.5.15 or lates version
* DB : Mysql 5
* Composer 1.2.0

 
## Setting Database ##
clone this project, next go to directory `src/settings.php`. find DB section setting:

        'db' => [
            'host' => 'YOURHOSTDB',
            'dbname' => 'YOURDBNAME',
            'user' => 'YOURUSERDB',
            'pass' => 'YOURPASSDB',
        ],

Replace all settings parameter to correct your database connection setting .

## Running the Project ##
if you already clone this project, and finish to set up the database.
you can run these commands

    cd [my-app-name]
    php -S localhost:[yourport] -t public public/index.php

Replace `[my-app-name]` with the desired directory name for your new application.
Replace `[yourport]` with the port number you want, ex: 8088. the full commands :

    php -S localhost:8088 -t public public/index.php

Voila! MessageAkoh is running :)


## How To Use ##

in this example, I am using `Restlet Client` - Rest API testing (the extension already installed in my google chrome).

### API for sending a message ###

```js
URL 			: http://localhost:8088/msg
Method			: POST
URL Params 		: -
Data Params		: {msg:[string],sender_id:[string]}
Response Code 		: Success (200 OK),Bad Request (404),Not Allowed (405)
Response Data 		: [{"status":"[succes/failed]","data":"[thisvalues]"}]

```

#### Send Parameter : 

<img src="https://user-images.githubusercontent.com/5528011/48444357-51664d80-e7c6-11e8-8e38-a247810219ae.png" width="90%"></img> 

#### Responses : 

if send parameter is success, the result will return data [id message].

```js
[
	{
		"status": "success",
		"data": "14"
	}
]
```
<img src="https://user-images.githubusercontent.com/5528011/48444485-a3a76e80-e7c6-11e8-939e-1aa67bcbc8a2.png" width="90%"></img> 
 
### API for collect message that has been sent out ###

```js
URL 			: http://localhost:8088/msg/:id
Method			: GET
URL Params 		: Required: :id[integer]
Data Params		: -
Response Code 		: Success (200 OK),Bad Request (404)
Response Data 		: [{"status":"[succes/failed]","data":"[thisvalues]"}]

```

#### Send Parameter : 

<img src="https://user-images.githubusercontent.com/5528011/48444791-8921c500-e7c7-11e8-884d-d7f6071be086.png" width="90%"></img> 

#### Response : 

```js
[
    {
        "status": "success",
        "data": {
            "message_id": "14",
            "message_value": "Hallo Hendra, how are u today ?",
            "sender_id": "121",
            "created_at": "2018-11-14 04:52:57",
            "updated_at": null,
            "deleted_at": null
        }
    }
]

```

<img src="https://user-images.githubusercontent.com/5528011/48444862-bec6ae00-e7c7-11e8-91ed-575b0fa79104.png" width="90%"></img> 

 
### API for display message in real time ###

```js
URL 			: http://localhost:8088/msg
Method			: GET
URL Params 		: -
Data Params		: -
Response Code 		: Success (200 OK),Bad Request (404)
Response Data 		: [{"status":"[succes/failed]","data":"[thisvalues]"}]

```

#### Send Parameter : ####

<img src="https://user-images.githubusercontent.com/5528011/48444979-06e5d080-e7c8-11e8-8f98-d3983188d673.png" width="90%"></img> 

#### Response : ####

```js
[
	{
	"status": "success",
	"data": [
	            {
	                "message_id": "14",
	                "message_value": "Hallo Hendra, how are u today ?",
	                "sender_id": "121",
	                "created_at": "2018-11-14 03:45:38",
	                "updated_at": null,
	                "deleted_at": null
	            },
	            {
	                "message_id": "13",
	                "message_value": "hahahahah",
	                "sender_id": "0",
	                "created_at": "2018-11-13 11:15:26",
	                "updated_at": null,
	                "deleted_at": null
	            },
	            {
	                "message_id": "12",
	                "message_value": "hahahahah",
	                "sender_id": "0",
	                "created_at": "2018-11-13 11:13:59",
	                "updated_at": null,
	                "deleted_at": null
	            }
	             
			]
	}
]
```

<img src="https://user-images.githubusercontent.com/5528011/48445230-a4410480-e7c8-11e8-833f-f243bc8ed3a9.png" width="90%"></img> 



Finish.

Thanks all, if you have any question feel free to contant me.

**Regards.**

`Hendra Setiawan` | +6285781830394 | hendset.ti04@gmail.com

~~Hidup Seperti Lerry~~