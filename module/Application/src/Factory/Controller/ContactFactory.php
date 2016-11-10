<?php
namespace Application\Factory\Controller;

/**
 * Created by PhpStorm.
 * User: igor
 * Date: 10/11/16
 * Time: 10:41
 */
use Application\Controller\ContactController;
use Application\Model\ContactTable;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ContactFactory implements AbstractFactoryInterface {


    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        //var_dump($container);exit;
        return new ContactController($container->get('Application\Model\ContactTable'));
    }

    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $class = new \ReflectionClass($requestedName);
        $parentLocator = $serviceLocator->getServiceLocator();
        if( $constructor = $class->getConstructor() )
        {
            if( $params = $constructor->getParameters() )
            {
                $parameter_instances = [];
                var_dump($params);exit;
                foreach( $params as $p )
                {

                    if( $p->getClass() ) {
                        $cn = $p->getClass()->getName();
                        if (array_key_exists($cn, $this->aliases)) {
                            $cn = $this->aliases[$cn];
                        }

                        try {
                            $parameter_instances[] = $parentLocator->get($cn);
                        }
                        catch (\Exception $x) {
                            echo __CLASS__
                                . " couldn't create an instance of $cn to satisfy the constructor for $requestedName.";
                            exit;
                        }
                    }
                    else{
                        if( $p->isArray() && $p->getName() == 'config' )
                            $parameter_instances[] = $parentLocator->get('config');
                    }

                }
                return $class->newInstanceArgs($parameter_instances);
            }
        }

        return new $requestedName;

    }

    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return true;
    }
    protected $aliases = [
       ContactTable::class => 'ContactModel'
    ];
}