<?php


namespace App\Controller;


use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class UserAccountController extends AbstractController
{
    public function index(Request $request, EntityManagerInterface $entityManager)
    {


        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $username= $request->getSession()->get('_security.last_username');
            $userRepository = $this->getDoctrine()
                ->getRepository(User::class);
            $user = $userRepository->findOneBy(['username' => $username]);
            $userID = $user->getId();
            $post = $form->getData();
            $post->setAuthorId($userID);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('account/account.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}