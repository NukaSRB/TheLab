# Populating the database

- [Toggl](#toggl)
    - [Clients](#toggl-clients)

<a name="toggl"></a>
## Toggl
To begin, we should populate the database tables with what information we can determine on our own.  To do this we will 
run the toggl populate commands.

```shell
php artisan toggl:populate:users        // Adds all users.  Assigns employee and admin roles.
php artisan toggl:populate:clients      // Adds all existing clients. 
```

This will fill the database with all the clients from toggl and add their toggl_id.
