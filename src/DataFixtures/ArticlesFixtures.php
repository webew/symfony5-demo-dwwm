<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ArticlesFixtures extends Fixture
{
    private UserPasswordEncoderInterface $encoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->encoder = $userPasswordEncoderInterface;
    }

    public function load(ObjectManager $manager)
    {
        $lorem = "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Minima illum voluptate numquam, optio sapiente iste nulla excepturi eaque consequuntur, adipisci, at deleniti qui accusantium necessitatibus neque ullam aspernatur porro debitis?";
        $cat = new Categorie();
        $cat->setNom('Catégorie');
        $manager->persist($cat);

        $user = new User();
        $user->setEmail("toto@toto.fr");
        $hash = $this->encoder->encodePassword($user, "toto");
        $user->setPassword($hash);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $admin = new User();
        $admin->setEmail("admin@admin.fr");
        $hash = $this->encoder->encodePassword($admin, "admin");
        $admin->setPassword($hash);
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);


        for ($i = 1; $i <= 10; $i++) {
            $article = new Article();
            $article->setTitre("Article " . $i);
            $article->setContenu($lorem);
            $article->setImageSrc("img{$i}.jpg");
            $article->setDate(new DateTime());
            $article->setStatut(true);
            $article->setCategorie($cat);
            // créer des commentaires
            for ($j = 1; $j <= 5; $j++) {
                $commentaire = new Commentaire();
                $commentaire->setTitre("Bla bla");
                $commentaire->setTexte($lorem);
                $commentaire->setDate(new DateTime());
                $commentaire->setArticle($article);
                $commentaire->setUser($user);
                $manager->persist($commentaire);
            }

            $manager->persist($article);
        }

        $manager->flush();
    }
}
