<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;

/**
 * Class PostCategoryFixtures
 * @package App\DataFixtures
 */
class PostCategoryFixtures extends BaseFixture
{

    /**
     * @var string[]
     */
    static private $categoryTitles = [
        'PHP',
        'JS',
        'HTML',
    ];

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_categories', function($i) {

            $category = new Category();

            $category->setTitle($this->faker->randomElement(self::$categoryTitles));

            return $category;
        });

        $manager->flush();
    }
}