<?php


namespace ZedMagdy\Bundle\SaasKitBundle\Factory;


use ZedMagdy\Bundle\SaasKitBundle\Model\Tenant;

class TenantFactory
{
    public static function create(): Tenant
    {
        return new Tenant();
    }
}