<?php


namespace ZedMagdy\Bundle\SaasKitBundle\Model;


interface TenantInterface
{
    public function getId(): string;
    public function setId(string $id): self;
}