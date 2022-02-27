<?php


namespace SymfonySkillbox\HomeworkBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use SymfonySkillbox\HomeworkBundle\DependencyInjection\UnitFactoryExtension;

class UnitFactoryBundle extends Bundle
{
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new UnitFactoryExtension();
        }

        return $this->extension;
    }

}