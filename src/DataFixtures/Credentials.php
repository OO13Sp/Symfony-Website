<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Demo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Credentials extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create Demo instances
        $demo1 = new Demo();
        $demo1->setType('Admin');
        
        $demo2 = new Demo();
        $demo2->setType('User');

        // Create User instances
        $user1 = new User();
        $user1->setName('John Doe');
        $user1->setPassword('password123');
        
        $user2 = new User();
        $user2->setName('Jane Doe');
        $user2->setPassword('password456');
        
        // Create the ManyToMany relation (link User to Demo)
        $user1->addType($demo1); // Adding user1 to demo1
        $user2->addType($demo2); // Adding user2 to demo2
        
        // Persist the entities
        $manager->persist($demo1);
        $manager->persist($demo2);
        $manager->persist($user1);
        $manager->persist($user2);
        
        // Apply the changes to the database
        $manager->flush();
    }
}
