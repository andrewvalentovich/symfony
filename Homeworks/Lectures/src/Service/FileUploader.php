<?php


namespace App\Service;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


class FileUploader
{
    /**
     * @var SluggerInterface
     */
    private $slugger;

    /**
     * @var string
     */
    private $uploadsPath;


    /**
     * FileUploader constructor.
     */
    public function __construct(string $uploadsPath, SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadFile(File $file)
    {
        $fileName = $this->slugger
            ->slug(pathinfo($file instanceof UploadedFile ? $file->getClientOriginalName() : $file->getFilename(), PATHINFO_FILENAME))
            ->append('-', uniqid())
            ->append('.', $file->guessExtension())
            ->toString()
        ;

        $newFile = $file->move($this->uploadsPath, $fileName);

        return $fileName;
    }
}