<?php
/**
 *
 * Kreativ&Söhne GmbH, Michael Fuchs <michael@kreativsoehne.de>
 *
 */
namespace KuS\PriceAfterLogin\Plugin;

class PricingRendererPlugin
{

    public $_session;

    public function __construct(
        \Magento\Customer\Model\Session $session
    )
    {
        $this->_session = $session;
    }

    /**
     * Only return price when user is logged in and belongs to specific customer group
     * Return false if no user is logged in.
     *
     * @return String
     */
    public function afterRender($subject, $result)
	{
        if ($this->_session->isLoggedIn()) {
            $customerGroupId = $this->_session->getCustomer()->getGroupId();

            if ($customerGroupId <= 5 || $customerGroupId == 9)
                return $result;
            else
                return false;
        }
        return false;
    }
}