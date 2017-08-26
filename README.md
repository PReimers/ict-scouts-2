# ICT-Scouts / Campus - Talent-App 

Management application for ICT-Scouts / Campus 

## Installation
Place Google-API authentication file in ```app/Resources/config/client_secret.json```

```
composer install --no-dev
```

```
php bin/console doctrine:schema:update --force
```

## Development

### Installation
```
composer install
```

```
npm install
```

### Commands

```
./node_modules/.bin/encore [dev|prod] [--watch]
```