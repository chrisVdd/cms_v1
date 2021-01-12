<?php

namespace App\Twig;

use App\Repository\PageRepository;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class MenuExtension
 * @package App\Twig
 */
class MenuExtension extends AbstractExtension
{
    /**
     * @var PageRepository
     */
    private $pageRepository;
    /**
     * @var Environment
     */
    private $twig;

    /**
     * MenuExtension constructor.
     * @param PageRepository $pageRepository
     * @param Environment $twig
     */
    public function __construct(
        PageRepository $pageRepository,
        Environment $twig)
    {
        $this->pageRepository   = $pageRepository;
        $this->twig             = $twig;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('menu_items',
                [$this, 'generateMenu'],
                [ 'is_safe' => ['html'] ]
            ),
        ];
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function generateMenu()
    {
        $items = $this->pageRepository->getItemsMenu();

//        dd($items);

        return $this->twig->render('includes/topbar.html.twig',
            ['items' => $items]
        );
    }
}