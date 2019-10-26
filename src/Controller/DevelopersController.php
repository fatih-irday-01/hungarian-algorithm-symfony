<?php

namespace App\Controller;

use App\Entity\Developers;
use App\Form\DevelopersType;
use App\Repository\DevelopersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/developers")
 */
class DevelopersController extends AbstractController
{
    /**
     * @Route("/", name="developers_index", methods={"GET"})
     */
    public function index(DevelopersRepository $developersRepository): Response
    {
        return $this->render('developers/index.html.twig', [
            'developers' => $developersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="developers_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $developer = new Developers();
        $form = $this->createForm(DevelopersType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($developer);
            $entityManager->flush();

            return $this->redirectToRoute('developers_index');
        }

        return $this->render('developers/new.html.twig', [
            'developer' => $developer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="developers_show", methods={"GET"})
     */
    public function show(Developers $developer): Response
    {
        return $this->render('developers/show.html.twig', [
            'developer' => $developer,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="developers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Developers $developer): Response
    {
        $form = $this->createForm(DevelopersType::class, $developer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('developers_index');
        }

        return $this->render('developers/edit.html.twig', [
            'developer' => $developer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="developers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Developers $developer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$developer->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($developer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('developers_index');
    }
}
