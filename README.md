## TRANSMEET LAB

```
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache/data
```

```
// linux
ln -s ../storage/app storage
```
- windows _(public folder && run as admin)_
```
// windows
mklink /D storage ..\storage\app
```
- rabbitmq
```
bind no painel de controle do exchange amq.direct => routing_key=aweb-msg
```

- shared aweb
```
// disable safe write on phpstorm
-
//
mklink /h c:\wamp\www\aweb-pickbox\app\Models\LogItem.php c:\wamp\www\aweb-shared\LogItem.php
mklink /h c:\wamp\www\aweb-msg\app\Models\LogItem.php c:\wamp\www\aweb-shared\LogItem.php
-
```

- queueing
```
// image processing so far
php artisan queue:work database

```

# cronjob for aweb-msg queues hostinger
```
ps aux -ww
flock -nx /home/u698191618/public_html/ms-msg/queue-worker-1.lock /opt/alt/php74/usr/bin/php /home/u698191618/public_html/ms-msg/artisan rabbitmq:consume
flock -nx /home/u698191618/public_html/ms-msg/queue-worker-2.lock /opt/alt/php74/usr/bin/php /home/u698191618/public_html/ms-msg/artisan rabbitmq:consume
```

#supervisor
```
sudo supervisorctl status
```
