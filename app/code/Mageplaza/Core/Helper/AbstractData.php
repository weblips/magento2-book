<?php

namespace Mageplaza\Core\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class AbstractData extends AbstractHelper
{
	protected $_data = [];

	protected $storeManager;
	protected $objectManager;

	public function __construct(
		Context $context,
		ObjectManagerInterface $objectManager,
		StoreManagerInterface $storeManager
	)
	{
		$this->objectManager = $objectManager;
		$this->storeManager  = $storeManager;
		parent::__construct($context);
	}

	public function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			$field,
			ScopeInterface::SCOPE_STORE,
			$storeId
		);
	}

	public function setData($name, $value)
	{
		$this->_data[$name] = $value;

		return $this;
	}

	public function getData($name)
	{
		if (array_key_exists($name, $this->_data)) {
			return $this->_data[$name];
		}

		return null;
	}

	public function getCurrentUrl()
	{
		$model = $this->objectManager->get('Magento\Framework\UrlInterface');

		return $model->getCurrentUrl();
	}

	public function createObject($path, $arguments = [])
	{
		return $this->objectManager->create($path, $arguments);
	}

	public function getObject($path)
	{
		return $this->objectManager->get($path);
	}
}