<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiUserController extends AbstractController
{
    /**
     * @Route("/api/user", name="api_user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        try {

            return $this->json($userRepository->findAll(), 200, [],  ['groups' => 'user:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    //RetrieveOne method = get

    /**
     * @Route("/api/user/{id}", name="api_user_indexOne", methods={"GET"})
     */
    public function indexOne($id, UserRepository $userRepository): Response
    {
        try {

            return $this->json($userRepository->find($id), 200, [],  ['groups' => 'user:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Create method = POST

    /**
     * @Route("/api/user", name="api_user_store", methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $jsonRecu = $request->getContent();
        $data = json_decode($jsonRecu, true);


        try {
            $user = new User();
            $user->setUsername($data['Username']);
            $user->setPassword($data['mdpUser']);
            $user->setRoles($data['roleUser']);


            $em->persist($user);
            $em->flush();


            return new Response($this->json($user, 201, [], ['groups' => 'user:read']));
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // UpdatePaiement method = put

    /**
     * @Route("/api/user/{id}", name="api_user_update", methods={"PUT"})
     */

    public function update($id, Request $request, SerializerInterface $serializer, UserRepository $userRepository, EntityManagerInterface $em)
    {

        try {

            $user = $userRepository->findOneBy(['id' => $id]);
            $data = json_decode($request->getContent(), true);

            $user->setUsername($data['username']);
            $user->setRoles($data['ville']);

            $em->persist($user);
            $em->flush();

            return $this->json($user, 201, [], ['groups' => 'user:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    // DELETE method = delete

    /**
     * @Route("/api/user/{id}", name="api_user_deleteS", methods={"DELETE"})
     */

    public function delete($id, UserRepository $userRepository, EntityManagerInterface $em)
    {

        try {

            $user = $userRepository->findOneBy(['id' => $id]);
            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute("voir_user");
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
