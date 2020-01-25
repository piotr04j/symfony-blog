<?php


namespace App\Tests\Unit;


use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class FormTest  extends TypeTestCase
{
    /** @test */
   public function singUpSubmitValidData ()
   {
       $formData = [
           'username' => 'user1',
           'email' => 'user1@mail.com',
           'password' => ['first' => 'abc123', 'second' => 'abc123' ]
       ];

       $objectToCompare = new User();
       $form = $this->factory->create(UserType::class, $objectToCompare);

       $object = new User();
       $object->setEmail('user1@mail.com');
       $object->setUsername('user1');
       $object->setPassword('abc123');

       $form->submit($formData);

       $this->assertEquals($object, $objectToCompare);

       $this->assertTrue($form->isSynchronized());

       $view = $form->createView();
       $children = $view->children;

       foreach (array_keys($formData) as $key) {
           $this->assertArrayHasKey($key, $children);
       }
   }
}