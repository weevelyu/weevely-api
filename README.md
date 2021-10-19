<p align='center'><img src="https://raw.githubusercontent.com/PAXANDDOS/PAXANDDOS/main/weevely/svg/weevely-logo.svg" height="200"></p>
<p align="center">
        <a href="https://www.php.net/" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" height="70">
        </a>
        <a href="https://laravel.com/" target="_blank">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/36/Logo.min.svg" height="70">
        </a>
        <a href="https://www.mysql.com/" target="_blank">
            <img src="https://www.vectorlogo.zone/logos/mysql/mysql-ar21.svg" height="70">
        </a>
        <a href="https://github.com/tymondesigns/jwt-auth" target="_blank">
            <img src="https://jwt.io/img/pic_logo.svg" height="70">
        </a>
        <a href="https://aws.amazon.com/" target="_blank">
            <img src="https://www.logo.wine/a/logo/Amazon_Web_Services/Amazon_Web_Services-Logo.wine.svg" height="70">
        </a>
        <a href="https://holidayapi.com/" target="_blank">
            <img src="https://holidayapi.com/images/calendar.svg" height="70">
        </a>
</p>

## :inbox_tray: Downloads

- [v1.0 Latest](https://github.com/PAXANDDOS/weevely-api/releases/tag/v1.0) — [Download](https://github.com/PAXANDDOS/weevely-api/releases/download/v1.0/v1.0-weevely-api.zip)
    
## :anchor: Requirements

- PHP 8.0.7
- MySQL 6.x / MariaDB 10.x
- Composer 2.x

You can easily install those via Homebrew:  
```bash
brew install php mysql composer
```
## :toolbox: Run API Locally

You can easily host this API on your server if you want to. But if you only want to work with data that is used by official Weevely, you can skip this step.

**To host the API just follow these steps:**  
1. [Check the requirements ☝️](https://github.com/PAXANDDOS/weevely-api/#anchor-requirements)
2. [Download the latest version](https://github.com/PAXANDDOS/weevely-api/releases/download/v1.0/v1.0-weevely-api.zip)
3. Open folder in your terminal and run `composer install`
4. Create your `database`
5. Create `.env` file and fill it with your data accordingly to `.env.example` file
6. Run `php artisan migrate` to fill database with required tables
7. If you want to add some data to database for testing, run `php artisan db:seed`
8. Start the API server with `php artisan serve`
  
## :key: API Reference

#### Authorization module
| Action | Request | Method  | Requirements |
| :----- | :------ | :------ | :----------- |
| Register        | `/api/auth/register` | `POST` | Data |
| Sign in         | `/api/auth/signin`   | `POST` | Data |
| Sign out        | `/api/auth/signout`  | `POST` | Bearer token |
| Reset password  | `/api/auth/reset-password`   | `POST` | Data |
| Change password | `/api/auth/reset-password/{token}`   | `POST` | Data, token |
| Remove request  | `/api/auth/reset-password/{token}/remove` | `GET` | Token | 
| Refresh token   | `/api/auth/refresh`   | `GET` | Bearer token |
| Get user        | `/api/auth/me`   | `GET` | Bearer token | 

#### User module
| Action | Request | Method  | Requirements |
| :----- | :------ | :------ | :----------- |
| Update data   | `/api/users/me`| `PATCH` | Bearer token, data |
| Upload avatar | `/api/users/me/avatar`   | `POST`  | Bearer token, data |

#### Calendars and events module
| Action | Request | Method  | Requirements |
| :----- | :------ | :------ | :----------- |
| Get my calendars | `/api/calendars/my/{type}` | `GET` | Bearer token, type |
| Create calendar  | `/api/calendars/my`   | `POST` | Bearer token, data (optional) |
| Share calendar   | `/api/calendars/{calendar_id}/share` | `POST` | Bearer token, calendar_id, users (json string) |
| Hide calendar    | `/api/calendars/{calendar_id}/hide`   | `POST` | Bearer token, calendar_id |
| Get events       | `/api/calendars/{calendar_id}/events` | `GET` | Bearer token, calendar_id |
| Create event     | `/api/calendars/{calendar_id}/events` | `POST` | Bearer token, calendar_id, data (optional) |
| Update event     | `/api/calendars/{calendar_id}/events/{event_id}`  | `PATCH` | Bearer token, calendar_id, data |
| Delete event     | `/api/calendars/{calendar_id}/events/{event_id}`   | `DELETE` | Bearer token, calendar_id |
| Add holidays     | `/api/calendars/{calendar_id}/holidays` | `POST` | Bearer token, calendar_id, data (country, year) |

## :fox_face: Have a great day!
**Don't forget to check out [Weevely with Next.js](https://github.com/PAXANDDOS?tab=repositories)**  
**[Also check out my other projects](https://github.com/PAXANDDOS?tab=repositories) and [visit my website](https://paxanddos.github.io)!**
