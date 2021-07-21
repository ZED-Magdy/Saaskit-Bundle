<?php


namespace ZedMagdy\Bundle\SaasKitBundle\Factory;


use ZedMagdy\Bundle\SaasKitBundle\Model\Tenant;
use ZedMagdy\Bundle\SaasKitBundle\Model\TenantInterface;

class TenantFactory
{
    public static function create(): TenantInterface
    {
        return new Tenant();
    }
}