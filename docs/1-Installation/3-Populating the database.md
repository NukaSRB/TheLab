# Populating the database

- [Toggl](#toggl)
    - [Clients](#toggl-clients)

<a name="toggl"></a>
## Toggl

<a name="toggl-clients"></a>
### Clients
To begin, we should make the clients table full of our clientele.  This is done by running one command.

```shell
php artisan toggl:populate:clients
```

This will fill the database with all the clients from toggl and add their toggl_id.
