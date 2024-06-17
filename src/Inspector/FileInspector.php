<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Inspector;

use Symfony\Component\Finder\SplFileInfo;

class FileInspector
{
    public function getNamespace(SplFileInfo $file): string
    {
        $namespace = '';
        if (preg_match('/namespace\s+(.*?);/s', $file->getContents(), $matches) === 1) {
            $namespace = $matches[1];
        }

        return $namespace . '\\' . $file->getBasename('.php');
    }
}
