<?php

namespace app\services;

use Exception;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\base\InvalidRouteException;
use yii\console\controllers\MigrateController;
use yii\helpers\ArrayHelper;

/**
 * Class InstallerService
 * @package app\services
 *
 * @property bool dbOk
 */
class InstallerService extends Component
{
    const MIGRATIONS = [
        'migrate-user',
        'migrate-rbac'
    ];

    public $consoleConfig;

    public $version;

    public $installerEnabled = false;

    public $recommendInstall = false;

    public $installed = false;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();

        $this->consoleConfig = require dirname(__DIR__) . '/config/console.php';
        $config = json_decode(file_get_contents(Yii::getAlias('@app/board.json')));

        //assigning values to props found in json
        foreach ($config as $key => $value) {
            if ($this->hasProperty($key)) {
                $this->$key = $value;
            }
        }

        if (!$this->dbOk && $this->installerEnabled) {
            // If the connection has not been established yet, installing will be recommended
            $this->recommendInstall = true;
        }
    }

    /**
     * Returns whether we are connected to a readable db
     * @return bool
     */
    public function getDbOk()
    {
        try {
            Yii::$app->db->createCommand('SELECT 1;')->execute();
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @throws InvalidConfigException
     * @throws InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function install()
    {
        $controllerConfigs = $this->consoleConfig['controllerMap'];

        //these are basically 3rd party migrations, I want to handle them here separately
        foreach ($controllerConfigs as $controllerId => $controllerConfig) {
            if (ArrayHelper::isIn($controllerId, self::MIGRATIONS)) {
                $result = $this->migrate($controllerId, $controllerConfig['migrationPath'], $controllerConfig['migrationTable']);

                if (!$result) {
                    return false;
                }
            }
        }

        if ($this->migrate('migrate', '@app/migrations', 'migrations')) {
            $this->installerEnabled = false;
            $this->installed = true;
            return true;
        }

        return false;
    }

    protected function writeConfig()
    {
        $config = [
            'version' => $this->version,
            'installerEnabled' => $this->installerEnabled,
            'installed' => $this->installed
        ];

        $configJson = json_encode($config, JSON_PRETTY_PRINT);
        file_put_contents(Yii::getAlias('@app/board.json'),$configJson);
    }

    /**
     * This method helps us migrate the user and rbac tables without having to
     * tweak with the console
     * @param $id
     * @param $path
     * @param $table
     * @return bool
     * @throws InvalidConfigException
     * @throws InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function migrate($id, $path, $table)
    {
        if (!defined('STDIN')) define('STDIN', fopen('php://stdin', 'rb'));
        if (!defined('STDOUT')) define('STDOUT', fopen('php://stdout', 'wb'));
        if (!defined('STDERR')) define('STDERR', fopen('php://stderr', 'wb'));

        /** @var MigrateController $migrateController */
        $migrateController = Yii::createObject('yii\console\controllers\MigrateController', [$id, Yii::$app]);
        $migrateController->migrationPath = $path;
        $migrateController->migrationTable = $table;

        echo "<pre>";
        $result = $migrateController->runAction('up', ['interactive' => 0]);
        echo "</pre>";

        if ($result == 0)
            return true;

        return false;
    }
}