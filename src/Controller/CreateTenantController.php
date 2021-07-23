<?php
namespace ZedMagdy\Bundle\SaasKitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ZedMagdy\Bundle\SaasKitBundle\Form\TenantType;

/**
 * @Route(path="tenants")
 */
class CreateTenantController extends AbstractController
{
    /**
     * @Route(path="/create", name="tenants.create", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        $form = $this->createForm(TenantType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
        }
        return $this->render('@SaasKit/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}