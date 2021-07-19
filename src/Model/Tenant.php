<?php


namespace ZedMagdy\Bundle\SaasKitBundle\Model;


class Tenant implements TenantInterface
{
    private string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }
}