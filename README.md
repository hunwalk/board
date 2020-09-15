<p align="center">
    <a href="https://github.com/hunwalk/board" target="_blank">
        <img src="web/images/logo.png" width="200px">
    </a>
</p>

A simple alert board for self-host enthusiasts, startups, ...etc.
You can send various messages or alerts to this board via the provided
api.
This project is still a work in progress, so don't expect it to
work right out of the box. It needs some tweaking.

This project uses [Yii framework](https://www.yiiframework.com/), and a preconfigured app
template I created that you can find here: https://github.com/hunwalk/yii2-basic-firestarter/

Also the logo uses an icon I downloaded from here:
https://www.flaticon.com/free-icon/wild-boar_427417

Btw, this project looks something like this:

![screenshot](https://i.imgur.com/7dgMv3T.png)

 ## Get started | Installation
 > You will need composer for this project.
 You can find it here, as well as some instructions about how to install it:
 https://getcomposer.org/

 Use the latest release
```bash
$ composer create-project hunwalk/board <projectName>
```
Or use the current master branch, if you're in a hurry for features if there is  any
 
```
$ git clone https://github.com/hunwalk/board <projectName>
$ cd <projectName>
$ composer install
$ composer run-script post-create-project-cmd
```

>post-create-project-cmd script sets up the permissions for some folders 
and generates the cookieValidationKey for you

## Automatic Install
> Please note, that this is still in beta, it might not work yet properly.
> If you've found an error please create an issue on github

#### On a local machine
Use your favorite terminal and cd into your project.

Then use the command:
```bash
php yii serve
```

And that's it. Open up your browser, head to http://localhost:8080/
and hit install.

#### On a shared hosting environment.
Set the vhost's documentRoot to the web folder in this project.
That's it.

## Manual Configuration
You can skip this part if you've already used
the method above.

#### 1st step
Create a .env file from the .env.example

OSX / LINUX

```$ cp .env.example .env```

Windows

```$ copy .env.example .env```

#### 2nd step
 - Fill in the .env file. Add or remove things, it's your choice entirely
 - Run the following commands 
    ```
    $ php yii migrate-user
    $ php yii migrate-rbac
    $ php yii migrate
    ```
#### 3rd step

 - Run the server and be happy :)
    ```
    $ php yii serve
    ```
   
## Sending alerts

You have 2 options. The first one is to use the board.js provided inside this project.
You can find some informations about this on the project page.

##### Sending alerts manually through API
You need to send a POST request towards <hostname>/api/v1/alert/push.
The Content-Type can be either `application/json` or `application/x-www-form-urlencoded`

For the sake of simple demonstration, the body should look like something like this
in json:
```json
{
  "api_push_key": "<your_project_api_key>",
  "type": "html",
  "alertName": "Test alert name",
  "alertBody": "<p>Test alert body</p>",
  "keywords": [
    "example-keyword1",
    "example-keyword2"
  ],
  "sender": {
    "name" : "custom_alert_sender",
    "version" : "v0.1"
  }
}
```

The alert `type` can be a lot of things, but it basically describes the 
`alertBody`.

For example `"type": "html"` means that the body will be considered as an html.
Type can be: `html`, `text`, `error`, `json`

#### NOTE: 
If you choose error, make sure you have a stackTraceString attribute inside
the object. E.g.
```json
{
  "type": "error",
  "alertName": "Test alert name",
  "alertBody": {
    "stackTraceString": "your StackTraceString"
  }
}
```



## F.A.Q.
- How can I create users?
- I've got an RFC complaint error during user creation. What's next?

#### How can I create users?
This project utilizes the [dektrium/yii2-user](https://github.com/dektrium/yii2-user)
package. Because I still did not created an Installer, you will have to use the console
to add yourself in.
Use the command: 

`php yii user/create <email> <username> <password>`

#### I've got an RFC complaint error during user creation. What's next?
If you did not set up the email section of the .env file then probably
that is why. To fix this, just fill in these rows like this.
Don't worry, this won't send out any emails.

```
PARAMS_ADMIN_EMAIL=admin@example.com
PARAMS_SENDER_EMAIL=noreply@example.com
PARAMS_SENDER_NAME="John Doe"
```

## Todo
In progress

## Credits
If I left out someone, or something please create an issue, thx.

 - [Yii Framework](https://www.yiiframework.com/)
 - [Yii2 Basic Firestarter](https://github.com/hunwalk/yii2-basic-firestarter/)
 - [Boar icon](https://www.flaticon.com/free-icon/wild-boar_427417)
 - [Logo font](https://fonts.google.com/specimen/Montserrat?query=montserrat) 
 - [highlight.php](https://github.com/scrivo/highlight.php)
 - [FontAwesome v4.7](https://fontawesome.com/v4.7.0/)
 