<?php

namespace App\Model;

use App\Exception\File\FailedFileCopy;
use App\Exception\File\FailedFileMove;
use App\Exception\File\UnexistentFile;
use App\Exception\Image\CorruptedImageFile;
use App\Exception\Image\FailedImageResize;
use App\Exception\Image\InvalidImage;
use App\Exception\Parameter\InvalidType;
use App\Helper\Validator\ClassConstantValidator;

class ImageModel
{
    // The web server accessible root folder
    const PATH_PUBLIC = __DIR__.'/../../public';
    // Where, inside the public folder, member pictures will be saved
    const PATH_WEB_MEMBER_PICTURES = '/members/pictures';
    // The full path to the member pictures folder
    const PATH_MEMBER_PICTURE = self::PATH_PUBLIC.self::PATH_WEB_MEMBER_PICTURES;

    const TYPE_TEMP = 1;
    const TYPE_PUBLIC = 2;
    const TYPE_MEMBER_PICTURE = 10;

    /** @var array */
    protected static $imageTypes = [
        0=>'unknown',
        1=>'gif',
        2=>'jpg',
        3=>'png',
        4=>'swf',
        5=>'psd',
        6=>'bmp',
        7=>'tiff',
        8=>'tiff',
        9=>'jpc',
        10=>'jp2',
        11=>'jpx',
        12=>'jb2',
        13=>'swc',
        14=>'iff',
        15=>'wbmp',
        16=>'xbm',
        17=>'ico',
        18=>'count',
    ];

    /** @var array */
    private static $validMimeTypes = [
        'image/jpeg',
        'image/png',
    ];

    /** @var bool */
    private $portraitOnly = false;

    /** @var int */
    private $maxHeight;

    /** @var float */
    private $percentage;

    /** @var int */
    private $height;

    /** @var int */
    private $width;

    /** @var string */
    private $extension;

    /** @var string */
    private $baseName;

    /** @var string */
    private $fileName;

    /** @var string */
    private $dirName;

    /** @var string */
    private $path;

    /**
     * @param string $fileName The file name of the image
     * @param int $maxHeight The max height the image can have
     * @param bool $portraitOnly If the image must be or not vertical
     *
     * @throws InvalidImage
     * @throws CorruptedImageFile
     * @throws UnexistentFile
     */
    public function __construct(string $fileName, int $maxHeight = 512, bool $portraitOnly = false)
    {
        $this->setPortraitOnly($portraitOnly);
        $this->setMaxHeight($maxHeight);
        $this->validateImage($fileName);
    }

    /**
     * @return bool
     */
    public function isPortraitOnly()
    {
        return $this->portraitOnly;
    }

    /**
     * @param bool $portraitOnly
     *
     * @return self
     */
    protected function setPortraitOnly(bool $portraitOnly)
    {
        $this->portraitOnly = $portraitOnly;

        return $this;
    }

    /**
     * @return int
     */
    protected function getMaxHeight()
    {
        return $this->maxHeight;
    }

    /**
     * @param int $maxHeight
     *
     * @return self
     */
    public function setMaxHeight(int $maxHeight)
    {
        $this->maxHeight = $maxHeight;

        return $this;
    }

    /**
     * @return float
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * @param float $percentage
     *
     * @return self
     */
    protected function setPercentage(float $percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getNewHeight()
    {
        return $this->getMaxHeight();
    }

    /**
     * @param int $height
     *
     * @return self
     */
    protected function setHeight(int $height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getNewWidth()
    {
        return ceil($this->getWidth() * $this->getPercentage());
    }

    /**
     * @param int $width
     *
     * @return self
     */
    protected function setWidth(int $width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     *
     * @return self
     */
    protected function setExtension(string $extension)
    {
        $this->extension = strtolower($extension);

        return $this;
    }

    /**
     * @return string
     */
    public function getBaseName()
    {
        return $this->baseName;
    }

    /**
     * @param string $baseName
     *
     * @return self
     */
    protected function setBaseName(string $baseName)
    {
        $this->baseName = $baseName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     *
     * @return self
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDirName()
    {
        return $this->dirName;
    }

    /**
     * @param string $dirName
     *
     * @return self
     */
    public function setDirName(string $dirName)
    {
        $this->dirName = $dirName;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @throws UnexistentFile
     *
     * @return self
     */
    public function setPath(string $path)
    {
        if (false === file_exists(trim($path))) {
            throw new UnexistentFile();
        }
        $this->path = trim($path);

        return $this;
    }

    /**
     * Get the folder correspondent to a given type.
     *
     * @param int $type The type constant of this class
     *
     * @throws InvalidType
     *
     * @return string
     */
    public static function getFolder(int $type)
    {
        $validator = new ClassConstantValidator(__CLASS__);
        if (false === $validator->isValid($type, '/^TYPE_.*$/')) {
            throw new InvalidType();
        }
        if (self::TYPE_TEMP === $type) {
            $tempDir = realpath(sys_get_temp_dir()).'/church-manager';
            if (false === file_exists($tempDir)) {
                mkdir($tempDir);
            }

            return $tempDir;
        }
        if (self::TYPE_PUBLIC === $type) {
            return realpath(self::PATH_PUBLIC);
        }
        if (self::TYPE_MEMBER_PICTURE === $type) {
            return realpath(self::PATH_MEMBER_PICTURE);
        }

        throw new InvalidType();
    }

    /**
     * Check if a fileName is a valid image fileName, if it's not corrupted and fills its basic data.
     *
     * @param string $fileName
     *
     * @throws InvalidImage
     * @throws CorruptedImageFile
     * @throws UnexistentFile
     *
     * @return string The file extension
     */
    protected function validateImage(string $fileName)
    {
        if (false === file_exists($fileName)) {
            throw new UnexistentFile();
        }

        $imageInfo = getimagesize($fileName);
        if (false === $imageInfo) {
            throw new CorruptedImageFile();
        }

        if (false === in_array($imageInfo['mime'], self::$validMimeTypes)) {
            throw new InvalidImage(null, 'Only ".jpg" and ".png" images are accepted.');
        }

        $this->setExtension('jpg');
        if ('image/png' === $imageInfo['mime']) {
            $this->setExtension('png');
        }

        $this->setWidth($imageInfo[0]);
        $this->setHeight($imageInfo[1]);

        if (true === $this->isPortraitOnly()) {
            if ($this->getWidth() > $this->getHeight()) {
                throw new InvalidImage(null, 'The image must be portrait oriented.');
            }
        }

        $fileInfo = pathinfo($fileName);
        $this->setFileName($fileInfo['filename']);
        $this->setBaseName($this->fileName.'.'.$this->getExtension());
        $this->setDirName($fileInfo['dirname']);
        $this->setPath($this->getDirName().'/'.$this->getBaseName());
        // Makes sure the image has an extension and that its is in lowercase
        if (true === empty(preg_match('/^[a-z]$/', $fileInfo['extension']))) {
            rename($fileName, $this->getPath());
        }

        $this->setPercentage(round((($this->maxHeight * 100) / $this->height)/100, 2));
    }

    /**
     * Move (and resize) a picture to the folder of the respective type.
     *
     * @param int $type The type of the image folder
     * @param string $newName If you want to rename the file, give the new name
     *
     * @throws InvalidType
     * @throws FailedFileMove
     * @throws FailedImageResize
     */
    public function move(int $type = self::TYPE_MEMBER_PICTURE, string $newName = null)
    {
        $validator = new ClassConstantValidator(__CLASS__);
        if (false === $validator->isValid($type, '/^TYPE_.*$/')) {
            throw new InvalidType();
        }
        $folder = self::getFolder($type);

        if (null !== $newName) {
            $baseName = pathinfo($newName, PATHINFO_FILENAME).'.'.$this->getExtension();
            $this->setBaseName($baseName);
        }

        if (false === rename($this->getPath(), $folder.'/'.$this->getBaseName())) {
            throw new FailedFileMove();
        }
        $this->setDirName($folder);
        $this->setPath($this->getDirName().'/'.$this->getBaseName());
        $this->resize();
    }

    /**
     * Copy (and resize) a picture to the folder of the respective type.
     *
     * @param int $type The type of the image folder
     * @param string $newName If you want to rename the file, give the new name
     *
     * @throws InvalidType
     * @throws FailedFileCopy
     * @throws FailedImageResize
     */
    public function copy(int $type = self::TYPE_MEMBER_PICTURE, string $newName = null)
    {
        $validator = new ClassConstantValidator(__CLASS__);
        if (false === $validator->isValid($type, '/^TYPE_.*$/')) {
            throw new InvalidType();
        }
        $folder = self::getFolder($type);

        if (null !== $newName) {
            $baseName = pathinfo($newName, PATHINFO_FILENAME).'.'.$this->getExtension();
            $this->setBaseName($baseName);
        }

        if (false === copy($this->getPath(), $folder.'/'.$this->getBaseName())) {
            throw new FailedFileCopy();
        }
        $this->setDirName($folder);
        $this->setPath($this->getDirName().'/'.$this->getBaseName());
        $this->resize();
    }

    /**
     * Resize a given image to maxHeight.
     *
     * @throws FailedImageResize
     */
    protected function resize()
    {
        if (512 === $this->getHeight()) {
            return;
        }

        try {
            if ('jpg' === $this->getExtension()) {
                $sourceImage = imagecreatefromjpeg($this->getPath());
            } else {
                $sourceImage = imagecreatefrompng($this->getPath());
            }
            $newImage = imagecreatetruecolor($this->getNewWidth(), $this->getNewHeight());
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            imagecopyresampled(
                $newImage,
                $sourceImage,
                0,
                0,
                0,
                0,
                $this->getNewWidth(),
                $this->getNewHeight(),
                $this->getWidth(),
                $this->getHeight()
            );

            $this->setWidth($this->getNewWidth());
            $this->setHeight($this->getNewHeight());

            if ('jpg' === $this->getExtension()) {
                return imagejpeg($newImage, $this->getPath());
            } else {
                return imagepng($newImage, $this->getPath());
            }
        } catch (\Exception $ex) {
            throw new FailedImageResize($ex, 'Could not resize the given image.');
        }
    }
}
