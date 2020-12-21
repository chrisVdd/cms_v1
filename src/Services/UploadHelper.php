<?php

namespace App\Services;

use Exception;
use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\FileExistsException as FileExistsExceptionAlias;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Class UploadHelper
 * @package App\Services
 */
class UploadHelper
{
    const POST_IMAGE        = 'post_image';
    const POST_REFERENCE    = 'post_reference';

    private $filesystem;
    private $privateFilesystem;
    private $requestStackContext;
    private $logger;
    private $publicAssetBaseUrl;

    /**
     * UploadHelper constructor.
     * @param FilesystemInterface $publicUploadsFilesystem
     * @param FilesystemInterface $privateUploadsFilesystem
     * @param RequestStackContext $requestStackContext
     * @param LoggerInterface $logger
//     * @param $publicAssetBaseUrl
     */
    public function __construct(
        FilesystemInterface $publicUploadsFilesystem,
        FilesystemInterface $privateUploadsFilesystem,
        RequestStackContext $requestStackContext,
        LoggerInterface $logger,
        string $uploadedAssetsBaseUrl)
    {
        $this->filesystem                   = $publicUploadsFilesystem;
        $this->privateFilesystem            = $privateUploadsFilesystem;
        $this->requestStackContext          = $requestStackContext;
        $this->logger                       = $logger;
        $this->publicAssetBaseUrl           = $uploadedAssetsBaseUrl;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string|null $existingFilename
     * @return string
     * @throws Exception
     */
    public function uploadPostImage(UploadedFile $uploadedFile, ?string  $existingFilename): string
    {
        /** @var string $newFilename */
        $newFilename = $this->uploadFile($uploadedFile, self::POST_IMAGE, true);

        if ($existingFilename) {

            try {
                $result = $this->filesystem->delete(self::POST_IMAGE.'/'.$existingFilename);

                if ($result === false) {
                    throw new Exception(sprintf('Could not delete old uploaded file "%s"', $existingFilename));
                }

            } catch (FileNotFoundException $e) {
                $this->logger->alert(sprintf('Old uploaded file "%s" was missing when trying to delete', $existingFilename));
            }
        }

        return $newFilename;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $directory
     * @param bool $isPublic
     * @return string
     * @throws FileExistsExceptionAlias
     * @throws Exception
     */
    private function uploadFile(UploadedFile $uploadedFile, string $directory, bool $isPublic)
    {
        if ($uploadedFile instanceof  UploadedFile) {
            $originalFilename = $uploadedFile->getClientOriginalName();
        } else {
            $originalFilename = $uploadedFile->getFilename();
        }

        $newFilename = Urlizer::urlize(pathinfo($originalFilename, PATHINFO_FILENAME)).'-'.uniqid().'.'.$uploadedFile->guessExtension();

        $filesystem = $isPublic ? $this->filesystem : $this->privateFilesystem;

        $stream = fopen($uploadedFile->getPathname(), 'r');
        $result = $this->filesystem->writeStream($directory.'/'.$newFilename, $stream);

        if ($result === false) {
            throw new Exception('Could not write uploaded file "%s" ', $newFilename);
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $newFilename;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string
     * @throws FileExistsExceptionAlias
     */
    public function uploadPostReference(UploadedFile $uploadedFile): string
    {
        return $this->uploadFile($uploadedFile, self::POST_REFERENCE, false);
    }

    /**
     * @param string $path
     * @return string
     */
    public function getPublicPath(string $path): string
    {
        return $this
                ->requestStackContext
                ->getBasePath().$this->publicAssetBaseUrl.'/'.$path;
    }

    /**
     * @param string $path
     * @return false|resource
     * @throws FileNotFoundException
     * @throws Exception
     */
    public function readStream(string $path)
    {
        $resource = $this->filesystem->readStream($path);

        if ($resource === false) {
            throw new Exception('Error opening stream for "%s" ', $path);
        }

        return $resource;
    }

    /**
     * @param string $path
     * @param bool $isPublic
     * @throws FileNotFoundException
     */
    public function deleteFile(string $path, bool $isPublic)
    {
        $filesystem = $isPublic ? $this->filesystem : $this->privateFilesystem;

        $result = $filesystem->delete($path);

        if ($result === false) {
            throw new \Exception(sprintf('Error deleting "%s" ', $path));
        }
    }


}