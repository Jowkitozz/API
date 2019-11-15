<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TransferController extends AbstractController
{
    /**
     * @Route("/transfer", name="transfer")
     */
    public function index()
    {
        $data = json_decode($request->getContent(), true);
        $Emetteur = $data['compteEmetteur'];
        $Recepteur = $data['compteRecepteur'];
        $Solde = $data['solde'];
        var_dump($Emetteur);
        var_dump($Recepteur);
        var_dump($Solde);

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(User::class)->findOneBy(array('numberAccount' => $Recepteur));
        $product->setSold(200 + $Solde);
        $em->flush();
    }
}
