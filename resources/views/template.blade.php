<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charSet='UTF-8' />
        <meta
            httpEquiv='content-type'
            content='text/html; charset=UTF-8'
        />
        <meta
            name='description'
            content='Simple event calendar for creating, managing, and searching events.'
        />
        <meta
            name='keywords'
            content='weevely, calendar, events, event-calendar, time, time-management, weekend, holiday'
        />
        <meta name='author' content='Paul Litovka' />
        <meta name='owner' content='Paul Litovka' />
        <meta name='copyright' content='Paul Litovka' />
        <meta name='designer' content='Paul Litovka' />
        <meta name='reply-to' content='pashalitovka@gmail.com' />
        <meta name='distribution' content='global' />
        <meta name='subject' content='Event calendar' />
        <meta name='language' content='EN, RU, UK, HU, DE' />
        <meta name='coverage' content='worldwide' />
        <meta name='rating' content='general' />
        <meta name='robots' content='all' />
        <meta name='googlebot' content='all' />
        <meta name='googlebot-news' content='all' />
        <meta name='revisit-after' content='1 day' />
        <meta httpEquiv='pragma' content='no-cache' />
        <meta httpEquiv='cache-control' content='no-cache' />
        <meta name='theme-color' content='#7c6aef' />
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="cache-control" content="no-cache" />
        <title id="pageTitle">Weevely</title>
    </head>
    <body class="antialiased" style="margin: 0; padding: 0;">
        @yield('body')
    </body>
</html>
