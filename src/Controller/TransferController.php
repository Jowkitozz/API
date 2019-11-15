<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TransferController extends AbstractController
{
    /**
     * @Route("/transfer", name="transfer")
     */
    public function intern(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $Emetteur = $data['compteEmetteur'];
        $Recepteur = $data['compteRecepteur'];
        $Solde = $data['sold'];
        var_dump($Emetteur);
        var_dump($Recepteur);
        var_dump($Solde);

        $em = $this->getDoctrine()->getManager();
        $emetteur = $em->getRepository(User::class)->findOneBy(array('numberAccount' => $Emetteur));
        $emetteur->setSold($emetteur->getSold() - $Solde);
        $recepteur = $em->getRepository(User::class)->findOneBy(array('numberAccount' => $Recepteur));
        $recepteur->setSold($recepteur->getSold() + $Solde);
        $em->flush();

    }
}
