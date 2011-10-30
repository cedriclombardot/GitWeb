<?php

namespace GitWeb\RepositoryBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;

class TreeExtension extends \Twig_Extension
{
    protected $loader;

    public function __construct(\Twig_LoaderInterface $loader)
    {
        $this->loader = $loader;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
        );
    }

    public function getFilters()
    {
        return array(
            'convert_for_url'          => new \Twig_Filter_Method($this, 'convertForUrl'),
            'to_breadcrumb'            => new \Twig_Filter_Method($this, 'toBreadcrumb'),
        );
    }

    public function toBreadcrumb($variable)
    {
        return explode('|', $variable);
    }

    public function convertForUrl($variable)
    {
       return str_replace('/', '|', $variable);
    }

    public function getName()
    {
        return 'tree';
    }

}
