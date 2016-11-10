<?php
namespace Application\Factory\Model;
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 10/11/16
 * Time: 10:52
 */
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\ContactTable;
use Zend\Db\TableGateway\TableGateway;

class ModelFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //var_dump($container);exit;
        return new  ContactTable($container->get(TableGateway::class));
    }
}