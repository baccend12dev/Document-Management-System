<!-- connection postgresql -->
PGSQL_CONNECTION=pgsql
PGSQL_HOST=172.20.1.117
PGSQL_PORT=5432
PGSQL_DATABASE=OTTOPG
PGSQL_USERNAME=postgres
PGSQL_PASSWORD=otto321


<!-- config/database.php -->
'pgsql2' => [
    'driver' => 'pgsql',
    'host' => env('PGSQL_HOST'),
    'port' => env('PGSQL_PORT'),
    'database' => env('PGSQL_DATABASE'),
    'username' => env('PGSQL_USERNAME'),
    'password' => env('PGSQL_PASSWORD'),
    'charset' => 'utf8',
    'prefix' => '',
    'schema' => 'public',
],

