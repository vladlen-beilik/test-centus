By default, Sail commands are invoked using the `vendor/bin/sail` script that is included with all new Laravel applications:

```shell
  ./vendor/bin/sail up
```

However, instead of repeatedly typing `vendor/bin/sail` to execute Sail commands, you may wish to configure a shell alias that allows you to execute Sail's commands more easily:

```shell
  alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```

1. `composer install`
2. `sail up -d`
3. `sail npm i`
4. `sail npm run build`
5. `sail artisan migrate`
6. `sail artisan app:get-countries` (Creating all countries to the database from https://restcountries.com)
7. `sail artisan app:get-cities` (Creating all cities in the database from [worldcities.csv](app/Services/data/worldcities.csv))
8. [Login](http://localhost/login)
9. [Registration](http://localhost/register)
10. `sail artisan test`

> To send email notifications I used [sandbox.mailtrap.io](https://mailtrap.io)

---

#### I would like to draw your attention to the fact that:
- To get the list of countries I use a free api https://restcountries.com (I think that's enough)
- To get a list of cities I downloaded the file [worldcities.csv](app/Services/data/worldcities.csv) from [simplemaps.com](https://simplemaps.com/data/world-cities) (The free version allows you to download only 47 thousand cities. This is enough for testing, but in production I would use some additional resource or buy a larger database.)
- To scale weather services I wrote [WeatherServiceFactory.php](app/Weather/WeatherServiceFactory.php)
- All services return the same array with the name of their service. And then the arithmetic mean is calculated.
```php
return [
    'service' => 'accuweather',
    'precipitation' => $precipitation ?? null,
    'uvi' => $uvi ?? null,
];
```
- Unfortunately, all weather services are limited in use or only paid, so I found several suitable ones for demonstration.
- That is why I did not implement the receipt of weather data for the user. The plan was to put it in the scheduled tasks when there was data in the alerts table.
- The actual process of collecting data and sending notifications is in [TestCommand.php](app/Console/Commands/TestCommand.php)
- I only use the `mail driver` to send notifications, because others are difficult to test. `Slack` is inconvenient for the average user. It is also inconvenient for setting up any `broadcast`. For `SMS`, you know, you need to bother with documents.

> In the end, the project is certainly not ideal, I deliberately missed many details. I think that for demonstration and test work it is enough. I spent 8-9 hours on it.
