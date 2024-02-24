<?php

namespace App\Controller;

use App\Entity\Objectif;
use App\Form\ObjectifType;
use App\Repository\ActivitePhysiqueRepository;
use App\Repository\ObjectifRepository;
use Doctrine\DBAL\Types\StringType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/interface', name: 'app_user_interface')]
class UserInterfaceController extends AbstractController
{
    #[Route('/', name: 'app_user_interface_base_user', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('user_interface/base_user.html.twig', [
            'controller_name' => 'UserInterfaceController',
        ]);
    }
    #[Route('/objectifs', name: 'app_user_interface_objectifs', methods: ['GET'])]
    public function display_pics(ObjectifRepository $objectifRepository): Response
    {
        return $this->render('user_interface/objectifs.html.twig', [
            'activities' => $objectifRepository->findAll(),
        ]);
    }
    #[Route('/objectifs/create_objectif/{data}', name:'app_user_interface_create_objectif', methods: ['POST', 'GET'])]
    public function create_objectif(string $data,ObjectifRepository $objectifRepository,ActivitePhysiqueRepository $activitePhysiqueRepository, EntityManagerInterface $entityManager, Request $request): Response 
    {
        $objectif = new Objectif();
        $form = $this->createForm(ObjectifType::class, $objectif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectif->setNomObjectif($data) ; 
            $entityManager->persist($objectif);
            $entityManager->flush();
            return $this->redirectToRoute('app_user_interface_objectifs', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/user_interface/newObjectif.html.twig', [
            'activities'=>$activitePhysiqueRepository->findAll(),
            'data_nom'=>$data,
            'objectif' => $objectif,
            'form' => $form,
        ]);    
     
    }
}
