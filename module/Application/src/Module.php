<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\ContactController;
use Application\Model\Contact;
use Application\Model\ContactTable;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    const VERSION = '3.0.2dev';

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ContactTable::class =>  function($container) {
                    $tableGateway = $container->get(Model\ContactTableGateway::class);
                    return new Model\ContactTable($tableGateway);
                },
                Model\ContactTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Contact());

                    return new TableGateway('contact', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                ContactController::class => function ($container) {
                    return new ContactController(
                        $container->get(Model\ContactTable::class)
                    );
                },
            ]
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
