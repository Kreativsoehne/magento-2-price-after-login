# magento-2-price-after-login
A Magento 2 extension which lets you determine which user groups are able to see the prices at all. Not logged in users will not see prices, too. 

## installation
    1. $ composer require kreativsoehne/magento-2-price-after-login
    2. $ ./bin/magento module:enable kreativsoehne_PriceAfterLogin
    3. $ ./bin/magento setup:upgrade
	4. $ ./bin/magento setup:di:compile
    5. Profit.

## usage
To determine allowed user groups, navigate to the module's settings in Magento admin:

	Shops -> Settings -> Configuration -> Catalog -> Catalog -> Price

Activate "Display prices only for specific customer groups" to enable the extension's functionality.
After activating, choose all the user groups which are allowed to see prices. Keep on pressing the CMD (Mac) or the CTRL (Windows or Linux) key on your keyboard to choose multiple user groups.

## how it works
It's a simple interceptor plugin which expands the Magento\Framework\Pricing\Render::Render() method into an after method.
It will surpress any price rendering when the user is not member of one of the specified user groups.

## Notice:
This Extension is very simple. It does not perform any additional logic than just surpressing rendering prices when not allowed. 
If you have implemented your own price rendering outside of the system's price renderer, then this extension will not work properly or won't work at all.