<?php

namespace App\Controller;

use App\Repository\BarberRepository;
use App\Entity\Barber;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiBarberController extends AbstractController

{
    // RETRIEVE ALL

    /**
     * @Route("/api/barber", name="api_barber_index", methods={"GET"})
     */
    public function index(BarberRepository $barberRepository): Response
    {
        try {

            return $this->json($barberRepository->findAll(), 200, [],  ['groups' => 'barber:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    //RetrieveOne

    /**
     * @Route("/api/barber/{id}", name="api_barber_indexOne", methods={"GET"})
     */
    public function indexOne($id, BarberRepository $barberRepository): Response
    {
        try {

            return $this->json($barberRepository->find($id), 200, [],  ['groups' => 'barber:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // SEARCH

    /**
     * @Route("/api/barberS/{id}", name="api_barber_indexForeign", methods={"GET"})
     */
    public function indexForeign($id, BarberRepository $barberRepository): Response
    {
        try {

            return $this->json($barberRepository->findBy(['idSalon' => $id]), 200, [],  ['groups' => 'barber:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    //  CREATE

    /**
     * @Route("/api/barber", name="api_barber_store", methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $jsonRecu = $request->getContent();

        try {

            $barber = $serializer->deserialize($jsonRecu, Barber::class, 'json');
            // $errors = $validator->validate($barber);

            // if (count($errors) > 0) {
            //     return $this->json($errors, 400);
            // }

            $em->persist($barber);
            $em->flush();


            return $this->json($barber, 201, [], ['groups' => 'barber:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // UPDATE

    /**
     * @Route("/api/barber/{id}", name="api_barber_update", methods={"PUT"})
     */

    public function update($id, Request $request, SerializerInterface $serializer, BarberRepository $barberRepository, EntityManagerInterface $em)
    {

        try {

            $barber = $barberRepository->findOneBy(['id' => $id]);
            $data = json_decode($request->getContent(), true);

            $barber->setNom($data['nom']);
            $barber->setPrenom($data['prenom']);
            $barber->setIdSalon($data['idSalon']);

            $em->persist($barber);
            $em->flush();

            return $this->json($barber, 201, [], ['groups' => 'barber:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    // DELETE

    /**
     * @Route("/api/barber/{id}", name="api_barber_deleteF", methods={"DELETE"})
     */

    public function deleteF($id, BarberRepository $barberRepository, EntityManagerInterface $em)
    {

        try {

            $barber = $barberRepository->findOneBy(['id' => $id]);
            $em->remove($barber);
            $em->flush();

            //  return $this->redirectToRoute("voir_barber");
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
