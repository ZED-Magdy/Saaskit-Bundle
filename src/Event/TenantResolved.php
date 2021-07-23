<?php


namespace ZedMagdy\Bundle\SaasKitBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;

class TenantResolved extends Event
{
    private string $tenantId;
    private object $tenantConfig;

    public function __construct(string $tenantId, object $tenantConfig)
    {
        $this->tenantId = $tenantId;
        $this->tenantConfig = $tenantConfig;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }

    public function getTenantConfig(): object
    {
        return $this->tenantConfig;
    }
}