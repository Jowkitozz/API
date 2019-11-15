<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransferController extends AbstractController
{
    /**
     * @Route("/transfer", name="transfer")
     */
    public function intern(Request $request)
    {
        // Ici on récupère les données entrées dans le formulaire
        $data = json_decode($request->getContent(), true);
        $Emetteur = $data['compteEmetteur'];
        $Recepteur = $data['compteRecepteur'];
        $Solde = $data['sold'];

        $em = $this->getDoctrine()->getManager();
        // Ici on récupère les informations du compte émetteur
        $emetteur = $em->getRepository(User::class)->findOneBy(array('numberAccount' => $Emetteur));
        $emetteur->setSold($emetteur->getSold() - $Solde);
        // Ici on récupère les informations du compte récepteur
        $recepteur = $em->getRepository(User::class)->findOneBy(array('numberAccount' => $Recepteur));
        $recepteur->setSold($recepteur->getSold() + $Solde);
        $em->flush();

        return new Response(sprintf('le compte : %s€ à viré au compte : %s d\' un montant de : %s', $emetteur->getNumberAccount(), $recepteur->getNumberAccount(), $Solde));

    }
}
