<?php

namespace SoosyzeExtension\Trumbowyg;

use Psr\Container\ContainerInterface;

class Installer implements \SoosyzeCore\System\Migration
{
    public function getDir()
    {
        return __DIR__;
    }

    public function install(ContainerInterface $ci)
    {
    }

    public function uninstall(ContainerInterface $ci)
    {
    }

    public function hookInstall(ContainerInterface $ci)
    {
    }

    public function hookUninstall(ContainerInterface $ci)
    {
    }

    public function seeders(ContainerInterface $ci)
    {
    }
}
