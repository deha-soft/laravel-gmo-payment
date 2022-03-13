<?php

namespace DehaSoft\LaravelGmoPayment;
use App\Services\GMO\Payment\Api;
use App\Services\GMO\Payment\Consts;
use App\Services\GMO\Payment\RedirectUtil;
use App\Services\GMO\Payment\ShopAndSiteApi;
use App\Services\GMO\Payment\ShopApi;
use App\Services\GMO\Payment\SiteApi;

class GMO
{
    /**
     * Error messages
     *
     * @var $errorMessage
     */
    
    private $_errorMessage;
    /**
     * Connect GMO SiteApi
     *
     * @return SiteApi
     */
    public function connectGMOSite()
    {
        $site = new SiteApi(
            config('gmo.host'), config('gmo.site_id'), config('gmo.site_pass')
        );

        return $site;
    }

    /**
     * Connect GMO ShopApi
     *
     * @return ShopApi
     */
    public function connectGMOShop()
    {
        $site = new ShopApi(
            config('gmo.host'), config('gmo.shop_id'), config('gmo.shop_pass')
        );

        return $site;
    }

    /**
     * Connect GMO ShopAndSiteApi
     *
     * @return ShopAndSiteApi
     */
    public function connectGMOShopAndSite()
    {
        $shopAndSite = new ShopAndSiteApi(
            config('gmo.host'),
            config('gmo.shop_id'), config('gmo.shop_pass'),
            config('gmo.site_id'), config('gmo.site_pass')
        );

        return $shopAndSite;
    }

    /**
     * Get error message
     *
     * @param array $errors error code
     *
     * @return mixed|string
     */
    public function getErrorMessage($errors)
    {
        $this->_errorMessage = [];
        
        if ($errors) {
            if (isset($errors['ErrCode'])) {
                $this->_errorMessage[] = $errors['ErrCode'] . ':' .
                    Consts::getErrorMessage($errors['ErrInfo']);
            } else {
                foreach ($errors as $error) {
                    $this->_errorMessage[] = $error['ErrCode'] . ':' .
                        Consts::getErrorMessage($error['ErrInfo']);
                }
            }
        }
        
        return $this->_errorMessage;
    }
}