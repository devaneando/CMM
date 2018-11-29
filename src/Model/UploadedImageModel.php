<?php

namespace App\Model;

use App\Exception\File\FailedFileMove;
use App\Exception\File\UnexistentFile;
use App\Exception\Image\CorruptedImageFile;
use App\Exception\Image\InvalidImage;
use App\Model\ImageModel;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadedImageModel extends ImageModel
{
    /** @var UploadedFile */
    private $uploadedFile;

    /**
     * @param UploadedFile $uploadedFile The uploaded file
     * @param int $maxHeight The max height the image can have
     * @param bool $portraitOnly If the image must be or not vertical
     *
     * @throws InvalidImage
     * @throws CorruptedImageFile
     * @throws UnexistentFile
     * @throws FileException
     * @throws FailedFileMove
     */
    public function __construct(UploadedFile $uploadedFile, int $maxHeight = 512, bool $portraitOnly = false)
    {
        $this->setPortraitOnly($portraitOnly);
        $this->setMaxHeight($maxHeight);
        $this->uploadedFile = $uploadedFile;
        $savedUploadedFile = $this->upload();
        parent::__construct($savedUploadedFile, $maxHeight, $portraitOnly);
    }

    /**
     * Manage the copy of the image to the server
     * For more information, check:
     *     - https://symfony.com/doc/3.4/controller/upload_file.html
     *     - https://symfony.com/doc/3.x/bundles/SonataAdminBundle/cookbook/recipe_file_uploads.html.
     *
     * @throws FailedFileMove
     *
     * @return string The path to the saved image, or false, if some problem happens
     */
    protected function upload()
    {
        try {
            $this->uploadedFile->move(
                $this->getFolder(ImageModel::TYPE_TEMP),
                $this->uploadedFile->getClientOriginalName()
            );

            return $this->getFolder(ImageModel::TYPE_TEMP).'/'.$this->uploadedFile->getClientOriginalName();
        } catch (\Exception $ex) {
            throw new FailedFileMove($ex);
        }
    }
}
