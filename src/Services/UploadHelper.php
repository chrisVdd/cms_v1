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
    const TEMPLATE_FILE     = 'uploaded_templates';

    private $filesystem;
    private $privateFilesystem;
    private $templateFilesystem;
    private $requestStackContext;
    private $logger;
    private $publicAssetBaseUrl;

    /**
     * UploadHelper constructor.
     * @param FilesystemInterface $publicUploadsFilesystem
     * @param FilesystemInterface $privateUploadsFilesystem
     * @param FilesystemInterface $templateUploadsFilesystem
     * @param RequestStackContext $requestStackContext
     * @param LoggerInterface $logger
     * @param string $uploadedAssetsBaseUrl
     */
    public function __construct(
        FilesystemInterface $publicUploadsFilesystem,
        FilesystemInterface $privateUploadsFilesystem,
        FilesystemInterface $templateUploadsFilesystem,
        RequestStackContext $requestStackContext,
        LoggerInterface $logger,
        string $uploadedAssetsBaseUrl)
    {
        $this->filesystem                   = $publicUploadsFilesystem;
        $this->privateFilesystem            = $privateUploadsFilesystem;
        $this->templateFilesystem            = $templateUploadsFilesystem;
        $this->requestStackContext          = $requestStackContext;
        $this->logger                       = $logger;
        $this->publicAssetBaseUrl           = $uploadedAssetsBaseUrl;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $directory
     * @param string $filesystemType
     * @return string
     * @throws FileExistsExceptionAlias
     */
    private function uploadFile(UploadedFile $uploadedFile, string $directory, string $filesystemType)
    {
        if ($uploadedFile instanceof  UploadedFile) {
            $originalFilename = $uploadedFile->getClientOriginalName();
        } else {
            $originalFilename = $uploadedFile->getFilename();
        }

        $newFilename = Urlizer::urlize(pathinfo($originalFilename, PATHINFO_FILENAME)).'-'.uniqid().'.'.$uploadedFile->guessExtension();
        $filesystem = $this->getFilesystem($filesystemType);

        $stream = fopen($uploadedFile->getPathname(), 'r');
        $result = $filesystem->writeStream($directory.'/'.$newFilename, $stream);

        if ($result === false) {
            throw new Exception('Could not write uploaded file "%s" ', $newFilename);
        }

        if (is_resource($stream)) {
            fclose($stream);
        }

        return $newFilename;
    }

    /**
     * @param string $filesystemType
     * @return FilesystemInterface
     */
    public function getFilesystem(string $filesystemType)
    {

        if ($filesystemType === 'public') {
            $filesystem = $this->filesystem;
        } elseif ($filesystemType === 'private') {
            $filesystem = $this->privateFilesystem;
        } elseif ($filesystemType === 'template') {
            $filesystem = $this->templateFilesystem;
        } else {
            $this->logger->alert("There is no filesystem");
        }

        return $filesystem;
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
        $newFilename = $this->uploadFile($uploadedFile, self::POST_IMAGE, "public");

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
     * @return string
     * @throws FileExistsExceptionAlias
     */
    public function uploadPostReference(UploadedFile $uploadedFile): string
    {
        return $this->uploadFile($uploadedFile, self::POST_REFERENCE,'private');
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return string
     * @throws FileExistsExceptionAlias
     */
    public function uploadTemplate(UploadedFile $uploadedFile): string
    {
        return $this->uploadFile($uploadedFile, self::TEMPLATE_FILE, "template");
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
     * @param bool $isPublic
     * @return false|resource
     * @throws FileNotFoundException
     * @throws Exception
     */
    public function readStream(string $path, bool $isPublic)
    {
        $filesystem = $isPublic ? $this->filesystem : $this->privateFilesystem;

        $resource = $filesystem->readStream($path);

        if ($resource === false) {
            throw new Exception('Error opening stream for "%s" ', $path);
        }

        return $resource;
    }

    /**
     * @param string $path
     * @param bool $isPublic
     * @throws FileNotFoundException
     * @throws Exception
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