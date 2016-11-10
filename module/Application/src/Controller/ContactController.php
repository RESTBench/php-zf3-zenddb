<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Model\Contact;
use Application\Model\ContactTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

class ContactController extends AbstractActionController
{
    /**
     * @var ContactTable
     */
    protected $contactTable;

    public function __construct(ContactTable $contactTable)
    {
        $this->contactTable = $contactTable;
    }

    public function indexAction()
    {
        $contacts = [];
        $contactsObjects = $this->contactTable->fetchAll();

        /** @var Contact $object */
        foreach ($contactsObjects as $object) {
            $contacts[] = $object->getArrayCopy();
        }

        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine( 'Content-Type', 'application/json' );
        $response->setContent(json_encode(['data' => $contacts]));

        return $response;
    }
}
