<?php

namespace App\Controller;

use App\Repository\SlotsRepository;
use App\Entity\Slots;
use App\Entity\Salon;
use App\Entity\User;
use App\Entity\Barber;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiSlotsController extends AbstractController
{
    /**
     * @Route("/api/slots", name="api_slots_index", methods={"GET"})
     */
    public function index(SlotsRepository $slotsRepository): Response
    {
        try {

            return $this->json($slotsRepository->findAll(), 200, [],  ['groups' => 'slots:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    //RetrieveOne method = get

    /**
     * @Route("/api/slots/{id}", name="api_slots_indexOne", methods={"GET"})
     */
    public function indexOne($id, SlotsRepository $slotsRepository): Response
    {
        try {

            return $this->json($slotsRepository->find($id), 200, [],  ['groups' => 'slots:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // Create method = POST

    /**
     * @Route("/api/slots", name="api_slots_store", methods={"POST"})
     */
    public function store(Request $request, SerializerInterface $serializer, EntityManagerInterface $em)
    {
        $jsonRecu = $request->getContent();

        $data = json_decode($jsonRecu, true);
        try {

            $slots = new Slots();

            $salon = $em->getRepository(Salon::class)->find($data['idSalon']);
            $barber = $em->getRepository(Barber::class)->find($data['idBarber']);
            $user = $em->getRepository(User::class)->find($data['idUser']);

            $slots->setIdSalon($salon);
            $slots->setIdBarber($barber);
            $slots->setIdUser($user);
            $slots->setDebutRDV($data['DebutRDV']);
            $slots->setFinRDV($data['FinRDV']);

            $em->persist($slots);
            $em->flush();



            return new Response($this->json($slots, 201, [], ['groups' => 'slots:read']));
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    // UpdatePaiement method = put

    /**
     * @Route("/api/slots/{id}", name="api_slots_update", methods={"PUT"})
     */

    public function update($id, Request $request, SerializerInterface $serializer, SlotsRepository $slotsRepository, EntityManagerInterface $em)
    {

        try {

            $slots = $slotsRepository->findOneBy(['id' => $id]);
            $data = json_decode($request->getContent(), true);

            $slots->setIdSalon($data['idSalon']);
            $slots->setIdBarber($data['idBarber']);
            $slots->setIdUser($data['idUser']);

            $em->persist($slots);
            $em->flush();

            return $this->json($slots, 201, [], ['groups' => 'slots:read']);
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }


    // DELETE method = delete

    /**
     * @Route("/api/slots/{id}", name="api_slots_deleteS", methods={"DELETE"})
     */

    public function delete($id, SlotsRepository $slotsRepository, EntityManagerInterface $em)
    {

        try {

            $slots = $slotsRepository->findOneBy(['id' => $id]);
            $em->remove($slots);
            $em->flush();

            return $this->redirectToRoute("voir_slots");
        } catch (NotEncodableValueException $e) {

            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
