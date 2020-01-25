<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Services\FormViolationsHandler;
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
        ValidatorInterface $validator,
        FormViolationsHandler $violationsHandler
    )
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $user = $form->getData();
            try {
                $errors = $validator->validate($user);
                if ($errors->count() > 0)
                {
                    $violationsMessages = $violationsHandler->getViolationMessages($errors);
                    return $this->render('authentication/register.html.twig', [
                        'form' => $form->createView(),
                        'violationsMessages' => $violationsMessages
                    ]);
                } else {
                    $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                    $user->setPassword($password);
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
            'violationsMessages' => []
        ]);
    }
}