<?php


namespace App\Controller;


use App\Entity\User;
use App\Form\UserType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    public function singUp
    (
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager,
        Session $session,
        ValidatorInterface $validator
    )
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setUsername($form->get('username')->getData());
            $user->setEmail($form->get('email')->getData());
            $password = $passwordEncoder->encodePassword($user, $form->get('password')->getData());
            $user->setPassword($password);
            try {
                $errors = $validator->validate($user);
                if (count($errors) > 0)
                {
                    return $this->render('authentication/register.html.twig', [
                        'form' => $form->createView(),
                        'errors' => $errors
                    ]);
                } else {
                    $entityManager->persist($user);
                    $entityManager->flush();
                    $session->getFlashBag()->add('success', sprintf('Account %s has been created!', $user->getUsername()));
                    return $this->redirectToRoute('homepage');
                }

            } catch (UniqueConstraintViolationException $exception) {
                $session->getFlashBag()->add('danger', 'Email and username has to be unique');
            }
        }
        return $this->render('authentication/register.html.twig', [
            'form' => $form->createView(),
            'errors' => []
        ]);
    }
}