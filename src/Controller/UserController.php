<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        // On initialise la connexion à la DataBase
        $em = $this->getDoctrine()->getManager();

        // Ici on récupère les données entré dans le formulaire
        $data = json_decode($request->getContent(), true);
        $name = $data['name'];
        $firstName = $data['firstName'];
        $birthDate = $data['birthDate'];
        $adress = $data['adress'];
        $numberAccount = random_int(0000000000000, 1000000000000);
        $code = $data['code'];
        $sold = 200;

        // On crée un nouvel utilisateur
        $user = new User();
        $encoded = $encoder->encodePassword($user, $code);
        $user->setFirstName($firstName);
        $user->setNumberAccount($numberAccount);
        $user->setCode($encoded);
        $user->setName($name);
        $user->setBirthDate($birthDate);
        $user->setAdress($adress);
        $user->setSold($sold);

        $em->persist($user);
        $em->flush();

        // On retourne un message succes.
        return new Response(sprintf('User %s successfully created', $user->getCode()));
    }
    public function api()
    {
        // On vérifie que l'on est bien connecté avec le Token
        return new Response(sprintf('Logged in as %s', $this->getUser()->getCode()));
    }
}
