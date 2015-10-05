<?php
namespace Application\Controller;

use Currency\Repository\Currencies;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Utility\Registry;

class IndexController extends AbstractActionController
{
    /**
     * Initializer method for Registry
     * @return IndexController
     */
    protected function _init()
    {
        Registry::setServiceManager($this->serviceLocator);
        return $this;
    }

	public function indexAction()
	{
        $this->_init();
		return new ViewModel();
	}

    public function getJsonRatesAction()
    {
        $this->_init();
        return Currencies::getJsonRates();
    }
}
