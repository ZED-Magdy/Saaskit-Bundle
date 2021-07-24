<?php
namespace ZedMagdy\Bundle\SaasKitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use ZedMagdy\Bundle\SaasKitBundle\Form\TenantType;
use ZedMagdy\Bundle\SaasKitBundle\Messages\CreateTenant;

/**
 * @Route(path="tenants")
 */
class CreateTenantController extends AbstractController
{
    private MessageBusInterface $bus;
    private string $filesPath;

    public function __construct(MessageBusInterface $bus, string $filesPath)
    {
        $this->bus = $bus;
        $this->filesPath = $filesPath;
    }

    /**
     * @Route(path="/create", name="saaskit_tenants_create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(TenantType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $files = array_diff(scandir($this->filesPath), array('.', '..'));
            if(in_array($form->getData()['name'].'.json', $files))
            {
                return $this->render('@SaasKit/create.html.twig', [
                    'form' => $form->createView(),
                    'error' => 'name already in use'
                ]);
            }
            $file = fopen($this->filesPath.'/'.$form->getData()['name'].'.json', 'x+');
            fwrite($file, json_encode($form->getData()));
            fclose($file);
            $this->bus->dispatch(
                new Envelope(
                        new CreateTenant(
                            $form->getData()['name'],
                            $form->getData()['adminEmail'],
                            $form->getData()['adminPassword']
                        )
                )
            );
            return $this->json(['status' => 'processing']);
        }
        return $this->render('@SaasKit/create.html.twig', [
            'form' => $form->createView(),
            'error' => null
        ]);
    }
}