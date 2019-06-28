<?php

namespace App\DataFixtures;

use App\Entity\ProdectType;
use App\Entity\ProductCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $tetrad = new ProductCategory();
        $tetrad->setName('Тетрадь')
            ->setDescription('рабочая тетрадь для школьников');

        $tetradKletka = new ProdectType();
        $tetradKletka->setName('Тетрадь в клетку')
            ->setDescription('12 страниц переработанного дерева')
            ->setProductCategory($tetrad);

        $tetradLineyka = new ProdectType();
        $tetradLineyka->setName('Тетрадь в линейку')
            ->setDescription('48 страниц для диктантов по татарскому языку')
            ->setProductCategory($tetrad);

        $pen = new ProductCategory();
        $pen->setName('ручка')
            ->setDescription('обычная ручка');

        $redPen = new ProdectType();
        $redPen->setName('красная ручка эрикраузер')
            ->setDescription('красная ручка сына маминой подруги')
            ->setProductCategory($pen);

        $bluePen = new ProdectType();
        $bluePen->setName('синяя ручка')
            ->setDescription('ручка для повседневных задач')
            ->setProductCategory($pen);

        $karandash = new ProductCategory();
        $karandash->setName('карандаш')
            ->setDescription('просто карандаш');

        $karandashType = new ProdectType();
        $karandashType->setName('карандаш')
            ->setDescription('стержень карандаша селан из графита')
            ->setProductCategory($karandash);

        $manager->persist($tetrad);
        $manager->persist($tetradKletka);
        $manager->persist($tetradLineyka);
        $manager->persist($pen);
        $manager->persist($redPen);
        $manager->persist($bluePen);
        $manager->persist($karandash);
        $manager->persist($karandashType);

        $manager->flush();
    }
}
