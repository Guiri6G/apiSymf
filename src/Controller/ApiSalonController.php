<?php

namespace App\Controller;

use App\Repository\SalonRepository;
use App\Entity\Salon;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiSalonController extends AbstractController
{
    /**
     * @Route("/api/salon", name="api_salon_index", methods={"GET"})
     */
    public function index(SalonRepository $salonRepository): Response
    {
        try {

            return $this->json($salonRepository->findAll(), 200, [],  ['groups' => 'salon:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    //RetrieveOne method = get

    /**
     * @Route("/api/salon/{id}", name="api_salon_indexOne", methods={"GET"})
     */
    public function indexOne($id, SalonRepository $salonRepository): Response
    {
        try {

            return $this->json($salonRepository->find($id), 200, [],  ['groups' => 'salon:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // SEARCH

    /**
     * @Route("/api/salonS/{nom}", name="api_salon_indexName", methods={"GET"})
     */
    public function indexName($nom, SalonRepository $salonRepository): Response
    {
        try {

            return $this->json($salonRepository->findBy(['nom' => $nom]), 200, [],  ['groups' => 'barber:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    // Create method = POST

    /**
     * @Route("/api/salon", name="api_salon_store", methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $jsonRecu = $request->getContent();

        try {

            $salon = $serializer->deserialize($jsonRecu, Salon::class, 'json');
            // $errors = $validator->validate($salon);

            // if (count($errors) > 0) {
            //     return $this->json($errors, 400);
            // }

            $em->persist($salon);
            $em->flush();


            return $this->json($salon, 201, [], ['groups' => 'salon:read']);
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // UpdatePaiement method = put

    /**
     * @Route("/api/salon/{id}", name="api_salon_update", methods={"PUT"})
     */

    public function update($id, Request $request, SerializerInterface $serializer, SalonRepository $salonRepository, EntityManagerInterface $em)
    {

        try {

            $salon = $salonRepository->findOneBy(['id' => $id]);
            $data = json_decode($request->getContent(), true);

            $salon->setNom($data['nom']);
            $salon->setLocalisation($data['ville']);

            $em->persist($salon);
            $em->flush();

            return $this->json($salon, 201, [], ['groups' => 'salon:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    // DELETE method = delete

    /**
     * @Route("/api/salon/{id}", name="api_salon_deleteS", methods={"DELETE"})
     */

    public function deleteS($id, SalonRepository $salonRepository, EntityManagerInterface $em)
    {

        try {

            $salon = $salonRepository->findOneBy(['id' => $id]);
            $em->remove($salon);
            $em->flush();

            return $this->redirectToRoute("voir_salon");
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
