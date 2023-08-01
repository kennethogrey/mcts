# MCTS Project Setup (Web application and Hardware)
This guide will walk you through the process of setting up the web application built with Laravel and configuring the tracking device to send and receive data in the web application.
# Web Application Setup
### Assumptions
1. XAMPP or another web server with PHP and MySQL is already installed and configured.
2. Node.js is installed, which includes npm.
3. Composer is installed globally, and Laravel is optional.
## Steps
1. Clone the project repository into your web server's htdocs folder. Open the terminal in that directory and run the following command:
`https://github.com/kennethogrey/mcts.git`
2. Change into the project directory: `cd bse23-10`
3. Install composer dependencies `composer install`
4. Install npm dependences `npm install`
5. Make a copy of the .env.example file and rename the copy to .env.
6. Generate the application encryption key: `php artisan key:generate`
7. In phpMyAdmin, create a new empty database called mcts.

8. Update the .env file with the database connection details:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name ie mcts
DB_USERNAME=database_username
DB_PASSWORD=your_database _password
```
9. Import the `mcts.sql` file located in the `mcts_database` folder of the project directory into the mcts database using phpMyAdmin's import feature.

### ThingSpeak setup
10. Create an account with thingspeak [link](https://thingspeak.com/)
11. After you have created an account create a channel of the following structure.

| Field | Value |
| :--- | :----: |
| Field 1 | device_id |
| Field 2 | latitude |
| Field 3 | longitude |
| Field 4 | time |
| Field 5 | date |
| Field 6 | alertStatus |

12. Get your channel read feed api an use it in the `automap.blade.php` file found under `resources/views/leaflet_maps/automap.blade.php` and edit add it on 

```
177    const url = "your_thingspeak_read_feeds_api";
```



### Email setup

13. Configure your email account for less secure apps. Follow the instructions provided by Google in this [support article](https://support.google.com/accounts/answer/6010255?hl=en).

14. Generate an app password for less secure apps and update the .env file with the email configuration:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=your_password generated for less secure apps
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youremail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```
With this configuration, you will be able to send verification emails to users and more.

### SMS Setup
15.  create an account with Vonage [link](https://www.vonage.com)
16. create your SMS API and get the `api_key` and `secret_key`
17. Locate the MapsController inside `app/HttpControllersMapsController.php` directory and modify the lines 
```
139    $basic  = new \Vonage\Client\Credentials\Basic("VONAGE_API_KEY", "VONAGE_API_SECRET");

and line

334    $basic  = new \Vonage\Client\Credentials\Basic("VONAGE_API_KEY", "VONAGE_API_SECRET");
```

### running the application
18. make sure you are into the main direcory `bse23-10`
19. inside the terminal run `php artisan serve`
20. copy the open the link that will be generate for you in the browser of your choice.
21. To login, we have 2 users in the database ie normal user and administrator. use the login credentials below to login

| User Type | Email | Password |
| :--- | :----: | ---: |
| Admin | ogirekenneth@gmail.com | 1234567890 |
| Normal User | ogreytesting@gmail.com | 1234567890 |

Use the Admin login credentials to login, create your own users and delete the default users.

# Device setup
### Assumptions
1. You have Arduino IDE installed and configured
2. You have installed TinyGPS++.h library by Mikal Hart in arduino IDE
3. You have installed Wire.h library by Nicholas Zambetti in arduino IDE
4. You have installed RTClib.h library by Adafruit in arduino IDE
5. You have installed AltSoftSerial.h library by Paul Stoffregen in the arduino IDE
### components
|  | component |
| :--- | :----: |
| 1 | 1 x Arduino Uno |
| 2 | 1 x SIM800L GSM/GPRS Module |
| 3 | 1 x GPS Module |
| 4 | 1 x RTC Module |
| 5 | 5v/2A power supply |
| 6 | 1 x button |
| 7 | 1 x 10k resistor |
| 8 | Male-Male jumper wires |
| 9 | Male-Female jumper wires |
## connections
### GSM
1. Connect Arduino `vin` to power supply `+ve`
2. connect Arduino uno `gnd` to power supply `-ve`
3. connect Gsm rx pin to arduino pin 6
4. connect Gsm tx pin to arduino pin 5
5. connect Gsm uart gnd pin to arduino gnd pin
6. connect Gsm power gnd pin to power supply `-ve`
7. connect Gsm vcc pin to power supply `+ve`
### GPS
8. connect GPS rx pin to arduino pin 9
9. connect GPS tx pin to arduino pin 8
10. connect GPS vcc to arduino 5v pin
### Button
11. connect pin1 of the button to a 10k resistor and then to the arduino gnd
12. connect pin2 of the button to the arduino 5v
13. connect pin3 of the buttonn to arduino digital pin2
### RTC
14. connect RTC scl pin to arduino A5 pin
15. connect RTC sda pin to arduino A4 pin
16. connect RTC vcc to 5v
17. connect RTC gnd to arduino gnd

## Code upload
1. Set the device_id to correspond with a device_id of a device that is registered in the web application. eg if you have a device with id = 2 in the database, then set the device_id in the code to 2.

After you have setup the IDE with all the necessary libraries and made the connections above, connect the arduino uno to you computer and uploade the sketch file called `device_code.ino` located in the `mcts_arduino` folder in the root directory.

Make sure to insert an active simcard with an active data plan in the GSM module and be outside to allow the GPS module to pick up a satelite signal in order for the device to work properly.



