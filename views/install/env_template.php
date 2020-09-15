<?php
/**
 * @var array $params
 */
?>
# DATABASE CONFIG - db.php
DB_HOST="<?= $params['dbHost'] ?>"
DB_PORT="<?= $params['dbPort'] ?>"
DB_DATABASE="<?= $params['dbName'] ?>"
DB_USERNAME="<?= $params['dbUser'] ?>"
DB_PASSWORD="<?= $params['dbPassword'] ?>"
DB_CHARSET="<?= $params['dbCharset'] ?>"

# MAILER CONFIGURATION - inside web.php
MAILER_HOST=
MAILER_USERNAME=
MAILER_PASSWORD=
MAILER_PORT=
MAILER_ENCRYPTION=

# APPLICATION PARAMS - params.php
PARAMS_ADMIN_EMAIL=admin@example.com
PARAMS_SENDER_EMAIL=noreply@example.com
PARAMS_SENDER_NAME="John Doe"