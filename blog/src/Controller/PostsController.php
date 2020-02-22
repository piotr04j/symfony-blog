<?php


namespace App\Controller;


use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostsController extends AbstractController
{
    public function allPosts ()
    {
        $postRepository = $this->getDoctrine()
            ->getRepository(Post::class);
        $posts = $postRepository->findAll();
        return $this->render('posts/posts.html.twig', [
            'posts' => $posts
        ]);
    }

    public function removePost(int $postID, EntityManagerInterface $entityManager)
    {
        $postRepository = $this->getDoctrine()
            ->getRepository(Post::class);
        $post = $postRepository->findOneBy(['id' => $postID]);

        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('user_account');
    }
}