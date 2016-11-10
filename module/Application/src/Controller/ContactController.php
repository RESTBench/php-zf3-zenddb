<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\ContactTable as ContactModel;

use Application\Model\ContactTable;
use Zend\Mvc\Controller\AbstractActionController;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Model\ViewModel;

class ContactController extends AbstractActionController
{
    /**
     * @var ContactTable
     */
    protected $contactTable;



    public function __construct(ContactTable $model)
    {
$this->contactTable = $model;
    }



    /**
     * @return ContactTable
     */
    public function getContactTable()
    {
        if (!$this->contactTable) {
            $sm = $this->getServiceLocator();

            $this->contactTable = $sm->get('Application\Model\ContactTable');
        }

        return $this->contactTable;
    }

    public function indexAction()
    {
        $contactsObjects = $this->getContactTable()->fetchAll();

        return new ViewModel();
    }

    public function __invoke()
    {
        return $this->indexAction();
    }
}
