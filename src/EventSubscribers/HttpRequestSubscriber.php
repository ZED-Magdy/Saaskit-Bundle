<?php

namespace ZedMagdy\Bundle\SaasKitBundle\EventSubscribers;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use ZedMagdy\Bundle\SaasKitBundle\Exceptions\TenantDoesNotExist;
use ZedMagdy\Bundle\SaasKitBundle\Model\TenantInterface;
use ZedMagdy\Bundle\SaasKitBundle\Event\TenantResolved;

class HttpRequestSubscriber implements EventSubscriberInterface
{
    private string $filesPath;
    private string $identifier;
    private TenantInterface $tenant;
    private EventDispatcherInterface $dispatcher;

    public function __construct(string $identifier, string $filesPath, TenantInterface $tenant, EventDispatcherInterface $dispatcher)
    {
        $this->identifier = $identifier;
        $this->filesPath = $filesPath;
        $this->tenant = $tenant;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param RequestEvent $event
     * @throws TenantDoesNotExist
     */
    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        if($this->hasTenant($request))
        {
            $this->resolveTenant($request);
        }
    }

    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function hasTenant(Request $request): bool
    {
        list($tenantName, $baseUri) = $this->resolveTenantName($request);
        return isset($tenantName) && isset($baseUri);
    }

    /**
     * @param Request $request
     * @return array
     */
    private function resolveTenantName(Request $request): array
    {
        if ($this->identifier === "prefix") {
            $segments = explode('.', $request->getHttpHost(), 2);
            $tenantName = $segments[0];
            $baseUri = $segments[1] ?? null;
        } else {
            $segments = explode('/', rtrim(ltrim($request->getUri(), $request->getScheme().'://'), '/'));
            $tenantName = $segments[1] ?? null;
            $baseUri = $segments[0];
        }
        return array($tenantName, $baseUri);
    }


    /**
     * @param Request $request
     * @throws TenantDoesNotExist
     */
    private function resolveTenant(Request $request)
    {
        [$tenant, $uri] = $this->resolveTenantName($request);
        $files = array_diff(scandir($this->filesPath), array('.', '..'));
        if(in_array($tenant.'.json', $files))
        {
            $contents = json_decode(file_get_contents($this->filesPath.'/'.$tenant.'.json'));
            $this->tenant->setId($contents->id);
            $this->dispatcher->dispatch(new TenantResolved($this->tenant->getId(), $contents));
        }else {
            throw new TenantDoesNotExist("Tenant of id {$tenant} does not exist in our system");
        }
    }
}