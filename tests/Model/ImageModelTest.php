<?php

namespace App\Tests\Model;

use App\Exception\File\UnexistentFile;
use App\Exception\Image\CorruptedImageFile;
use App\Exception\Image\InvalidImage;
use App\Model\ImageModel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ImageModelTest extends WebTestCase
{
    const IMAGES_DIR = __DIR__.'/../Resources/Images';

    public function testPath()
    {
        $this->assertFileExists(ImageModel::getFolder(ImageModel::TYPE_TEMP));
        $this->assertEquals(
            'church-manager',
            pathinfo(ImageModel::getFolder(ImageModel::TYPE_TEMP), PATHINFO_FILENAME)
        );

        $this->assertFileExists(ImageModel::getFolder(ImageModel::TYPE_PUBLIC));
        $this->assertEquals(
            'public',
            pathinfo(ImageModel::getFolder(ImageModel::TYPE_PUBLIC), PATHINFO_FILENAME)
        );

        $this->assertFileExists(ImageModel::getFolder(ImageModel::TYPE_MEMBER_PICTURE));
        $this->assertEquals(
            'pictures',
            pathinfo(ImageModel::getFolder(ImageModel::TYPE_MEMBER_PICTURE), PATHINFO_FILENAME)
        );
    }

    public function testInvalidImages()
    {
        try {
            new ImageModel(self::IMAGES_DIR.'/albert-einstein-non-existent.gif');
        } catch (\Exception $ex) {
            $this->assertEquals(UnexistentFile::class, get_class($ex));
        }

        try {
            new ImageModel(self::IMAGES_DIR.'/albert-einstein.gif');
        } catch (\Exception $ex) {
            $this->assertEquals(InvalidImage::class, get_class($ex));
        }

        try {
            new ImageModel(self::IMAGES_DIR.'/albert-einstein-corrupted.png');
        } catch (\Exception $ex) {
            $this->assertEquals(CorruptedImageFile::class, get_class($ex));
        }
    }

    public function testCopyImage()
    {
        $imageModel = new ImageModel(self::IMAGES_DIR.'/albert-einstein-large.jpg');
        $path01 = $imageModel->getPath();
        $imageModel->copy(ImageModel::TYPE_MEMBER_PICTURE);
        $path02 = $imageModel->getPath();
        $this->assertNotEquals($path01, $path02);
        $this->assertFileExists($imageModel->getPath());
        $imageInfo = getimagesize($imageModel->getPath());
        $this->assertEquals($imageInfo[0], $imageModel->getWidth());
        $this->assertEquals($imageInfo[1], $imageModel->getHeight());
    }

    public function testMoveImage()
    {
        $tempFile = ImageModel::getFolder(ImageModel::TYPE_TEMP).'/albert-einstein-small.png';
        copy(self::IMAGES_DIR.'/albert-einstein-small.png', $tempFile);

        $imageModel = new ImageModel($tempFile);
        $path01 = $imageModel->getPath();
        $imageModel->move(ImageModel::TYPE_MEMBER_PICTURE);
        $path02 = $imageModel->getPath();
        $this->assertNotEquals($path01, $path02);
        $this->assertFileExists($imageModel->getPath());
        $imageInfo = getimagesize($imageModel->getPath());
        $this->assertEquals($imageInfo[0], $imageModel->getWidth());
        $this->assertEquals($imageInfo[1], $imageModel->getHeight());
    }

    public function testCopyRenameImage()
    {
        $imageModel = new ImageModel(self::IMAGES_DIR.'/albert-einstein-portrait.jpg');
        $path01 = $imageModel->getPath();
        $imageModel->copy(ImageModel::TYPE_MEMBER_PICTURE, 'dadidooo.tiff');
        $path02 = $imageModel->getPath();
        $this->assertNotEquals($path01, $path02);
        $this->assertFileExists($imageModel->getPath());
        $imageInfo = getimagesize($imageModel->getPath());
        $this->assertEquals($imageInfo[0], $imageModel->getWidth());
        $this->assertEquals($imageInfo[1], $imageModel->getHeight());
        $this->assertEquals('dadidooo.jpg', $imageModel->getBaseName());
    }

    public function testMoveRenameImage()
    {
        $tempFile = ImageModel::getFolder(ImageModel::TYPE_TEMP).'/albert-einstein-small.png';
        copy(self::IMAGES_DIR.'/albert-einstein-small.png', $tempFile);

        $imageModel = new ImageModel($tempFile);
        $path01 = $imageModel->getPath();
        $imageModel->move(ImageModel::TYPE_MEMBER_PICTURE, 'jumbatron.tiff');
        $path02 = $imageModel->getPath();
        $this->assertNotEquals($path01, $path02);
        $this->assertFileExists($imageModel->getPath());
        $imageInfo = getimagesize($imageModel->getPath());
        $this->assertEquals($imageInfo[0], $imageModel->getWidth());
        $this->assertEquals($imageInfo[1], $imageModel->getHeight());
        $this->assertEquals('jumbatron.png', $imageModel->getBaseName());
    }
}
