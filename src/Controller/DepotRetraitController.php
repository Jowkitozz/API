<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DepotRetraitController extends AbstractController
{

    public function DepotRetrait(Request $request)
    {
        // Ici on récupère les données entrés par l'utilisateur
        $data = json_decode($request->getContent(), true);
        $Recepteur = $data['numberAccount'];
        $Date = $data['date'];
        $Solde = $data['sold'];

        // On se connecte à la base de donnée et on récupère l'id du compte receveur.
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(User::class)->findOneBy(array('numberAccount' => $Recepteur));

        // Si c'est un dépot on dépose l'argent sinon c'est un retrait, il faut que le montant contienne un - ( négatif ).
        if ($Solde > 0) {
            $product->setSold($product->getSold() + $Solde);
            $em->flush();
            return new Response(sprintf('Ton solde est maintenant de : %s€', $product->getSold()));
        }
        // Lors du retrait, si je retire trop par rapport à mon solde, je ne peux pas retirer.
        if ($product->getSold() + $Solde < 0) {
            return new Response(sprintf('Tu ne peux pas dépenser cet argent sinon attention au découvert. Tu as encore : %s€',
                $product->getSold()));
        }
        // Si je peux, je retire.
        $product->setSold($product->getSold() + $Solde);
        $em->flush();

        return new Response(sprintf('Ton solde est maintenant de : %s€', $product->getSold()));
    }
}
