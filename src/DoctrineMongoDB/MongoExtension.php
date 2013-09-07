<?php

namespace DoctrineMongoDB;


use Silex\Application;
use Silex\ServiceProviderInterface;
use Doctrine\MongoDB\Connection;
use Doctrine\MongoDB\Configuration;
use Doctrine\Common\EventManager;

class MongoExtension implements ServiceProviderInterface {

	public function register(Application $app) {

		$app['mongodb.connection'] = $app->share(function ($app) {
			$configuration = $app['mongodb.configuration'];
			$eventManager = $app['mongodb.event_manager'];
			$server = $app['mongodb.server'];
			$options = $app['mongodb.options'];
			return new Connection($server, $options, $configuration, $eventManager);
		});

		$app['mongodb.configuration'] = $app->share(function () {
			return new Configuration();
		});

		$app['mongodb.event_manager'] = $app->share(function () {
			return new EventManager();
		});

	}

	public function boot(Application $app) {
		$app['mongodb.options'] = array_replace(array(
            'connect' => false
        ), isset($app['mongodb.options']) ? $app['mongodb.options'] : array());

        $app['mongodb.server'] = isset($app['mongodb.server']) ? $app['mongodb.server'] : null;

	}

}