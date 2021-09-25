<?php


namespace App\Service;


use League\Flysystem\Exception;
use League\Flysystem\FilesystemInterface;
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
     * @var FilesystemInterface
     */
    private $filesystem;


    /**
     * FileUploader constructor.
     */
    public function __construct(FilesystemInterface $articleFilesystem, SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
        $this->filesystem = $articleFilesystem;
    }

    public function uploadFile(File $file, ?string $oldFileName = null): string
    {
        $fileName = $this->slugger
            ->slug(pathinfo($file instanceof UploadedFile ? $file->getClientOriginalName() : $file->getFilename(), PATHINFO_FILENAME))
            ->append('-', uniqid())
            ->append('.', $file->guessExtension())
            ->toString()
        ;

        $stream = fopen($file->getPathname(), 'r');
        $result = $this->filesystem->writeStream($fileName, $stream);

        if (is_resource($stream)) {
            fclose($stream);
        }

        if (! $result) {
            throw new \Exception("Не удалось записать файл $fileName");
        }

        if ($oldFileName && $this->filesystem->has($oldFileName)) {
            $result = $this->filesystem->delete($oldFileName);
            if (! $result) {
                throw new \Exception("Не удалось удалить файл $fileName");
            }
        }

        return $fileName;
    }
}