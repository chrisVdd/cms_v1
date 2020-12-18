<?php


namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PostFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $postTitles = [
        'Post for test',
        'Super title for a post',
        'Another title'
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'main_posts', function($count) use ($manager) {

            $post = new Post();
            $post->setTitle($this->faker->randomElement(self::$postTitles))
                ->setContent(<<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
**turkey** shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF
                );
            // publish most articles
            if ($this->faker->boolean(70)) {
                $post->setCreateDate($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $post->setOnline(1);
            $post->setAuthor($this->getRandomReference('main_users'));
            $categories = $this->getRandomReferences('main_categories', $this->faker->numberBetween(0, 5));
            foreach ($categories as $category) {
                $post->addCategory($category);
            }

            return $post;
        });

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            PostCategoryFixtures::class,
            UserFixtures::class,
        ];
    }

}