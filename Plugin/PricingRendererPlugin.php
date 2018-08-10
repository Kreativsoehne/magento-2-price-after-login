<?php
/**
 *
 * Kreativ&Söhne GmbH, Michael Fuchs <michael@kreativsoehne.de>
 *
 */
namespace kreativsoehne\PriceAfterLogin\Plugin;

class PricingRendererPlugin
{

    public $_customerSession;
    public $_scopeConfig;

    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->_customerSession = $session;
        $this->_scopeConfig = $scopeConfig;
    }

    /**
     * Only return price when user belongs to specific customer group.
     *
     * @return String
     */
    public function afterRender($subject, $result)
	{
        // is the limitation active?
	$limitActive = ($this->_scopeConfig->getValue('catalog/price/limit_active', \Magento\Store\Model\ScopeInterface::SCOPE_STORE) == 1) ? true : false;
	if(!$limitActive) return $result;

	// get the user group ids which are accepted for visible price tags
	$acceptedGroups = explode(",", $this->_scopeConfig->getValue('catalog/price/specificcustomergroup', \Magento\Store\Model\ScopeInterface::SCOPE_STORE));

	// get the current user's user group id
	$customerGroupId = $this->_customerSession->getCustomer()->getGroupId();

	return (in_array($customerGroupId, $acceptedGroups)) ? $result : false;
    }
}
