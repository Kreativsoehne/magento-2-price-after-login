<?php
/**
 *
 * Kreativ&Söhne GmbH, Michael Fuchs <michael@kreativsoehne.de>
 *
 */
namespace kreativsoehne\PriceAfterLogin\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;

class AddHandles implements ObserverInterface
{
    protected $customerSession;
    public function __construct(
		CustomerSession $customerSession,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
	)
	{
        $this->_customerSession = $customerSession;
		$this->_scopeConfig = $scopeConfig;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        
        // is the limitation active?
        $limitActive = ($this->_scopeConfig->getValue('catalog/price/limit_active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) == 1) ? true : false;
	    if(!$limitActive) return $result;

        // get the user group ids which are accepted for paying with this payment method
        $acceptedGroups = explode(",", $this->_scopeConfig->getValue('catalog/price/specificcustomergroup', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));

        // get the current user's user group id
        $customerGroupId = $this->_customerSession->getCustomer()->getGroupId();

        if (!in_array($customerGroupId, $acceptedGroups)) {
            $layout = $observer->getEvent()->getLayout();
			$layout->getUpdate()->addHandle('customer_no_prices');
        }
    }
}
