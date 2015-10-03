<?php
namespace Api\Controller;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class RestApiV1Controller extends AbstractRestfulController
{

    protected $collectionOptions    = array('GET', 'POST');
    protected $resourceOptions      = array('GET', 'PUT', 'DELETE');

    /**
     * Helper method to get resourceOptions|collectionOptions
     * @return array
     */
    protected function _getOptions()
    {
        if($this->params()->fromRoute('id', false))
        {
            return $this->resourceOptions;
        }
        return $this->collectionOptions;
    }

    public function options()
    {
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Allow', implode(',', $this->_getOptions()));
    }

    /**
     * Check if HTTP method is allowed
     * @param $event
     * @return void|\Zend\Stdlib\ResponseInterface
     */
    public function checkOptions($event)
    {
        if(in_array($event->getReQuest()->getMethod(), $this->_getOptions()))
        {
            return; // Method is allowed
        }

        // Method isn't allowed
        $response = $this->getResponse();
        $response->setStatusCode(405);
        return $response;
    }

    public function setEventManager(EventManagerInterface $events)
    {
        $this->events = $events;
        $events->attach('dispatch', array($this, 'checkOptions'), 10);
    }

    public function getList()
    {   // Action used for GET requests without resource Id
        return new JsonModel(
            array('data' =>
                      array(
                          array('id'=> 1, 'name' => 'Mothership', 'band' => 'Led Zeppelin'),
                          array('id'=> 2, 'name' => 'Coda',       'band' => 'Led Zeppelin'),
                      )
            )
        );
    }
    public function get($id)
    {   // Action used for GET requests with resource Id
        return new JsonModel(array("data" => array('id'=> 2, 'name' => 'Coda', 'band' => 'Led Zeppelin')));
    }
    public function create($data)
    {   // Action used for POST requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));
    }
    public function update($id, $data)
    {   // Action used for PUT requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'Updated Album', 'band' => 'Updated Band')));
    }
    public function delete($id)
    {   // Action used for DELETE requests
        return new JsonModel(array('data' => 'album id 3 deleted'));
    }

}