<?php

declare(strict_types=1);

namespace AttributeAutoRegisterBundle\Inspector;

use Symfony\Component\Finder\SplFileInfo;

class FileInspector
{
    /**
     * Extracts the namespace from a file appending the class name.
     */
    public function getNamespace(SplFileInfo $file): string
    {
        if (preg_match('/namespace\s+(?P<path>.*?);/s', $file->getContents(), $matches) === 1) {
            return $matches['path'] . '\\' . $file->getBasename('.php');
        }

        return '';
    }
}
