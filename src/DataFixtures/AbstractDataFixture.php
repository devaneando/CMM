<?php

namespace App\DataFixtures;

use App\Exception\File\InvalidFile;
use App\Exception\File\UnexistentFile;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * Used as base class for fixtues, provides container and progress bar.
 */
abstract class AbstractDataFixture extends AbstractFixture implements ContainerAwareInterface
{
    const PATH_RESOURCES = __DIR__.'/Resources';
    const FALLBACK_LOCALE = 'en';

    /** @var ContainerInterface */
    private $container;

    /** @var string */
    private $locale;

    /** @var ConsoleOutput */
    private $output;

    /** @var array */
    protected $data;

    /** @var ProgressBar */
    private $progressBar;

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->locale = $this->container->getParameter('locale');
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return ConsoleOutput
     */
    public function getOutput()
    {
        if (null === $this->output) {
            $this->output = new ConsoleOutput();
        }

        return $this->output;
    }

    /**
     * Get the value of data.
     *
     * @param string $fileName The name of the file with the data
     *
     * @throws UnexistentFile
     * @throws InvalidFile
     *
     * @return array
     */
    public function getData(string $fileName = '')
    {
        if (true === empty($fileName)) {
            $this->loadData($fileName);
        }

        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return ProgressBar
     */
    public function getProgressBar()
    {
        if (null === $this->progressBar) {
            $this->progressBar = new ProgressBar($this->getOutput(), count($this->getData()));
        }

        return $this->progressBar;
    }

    /**
     * Step the progressBar.
     */
    public function stepIt()
    {
        $this->getProgressBar()->advance();
    }

    /**
     * Load a yaml data file into the data array.
     *
     * @param string $fileName
     *
     * @throws UnexistentFile
     * @throws InvalidFile
     */
    public function loadData(string $fileName)
    {
        $resourceFile = self::PATH_RESOURCES.'/'.$this->getLocale().'/'.$fileName;
        if (false === file_exists($resourceFile)) {
            $resourceFile = self::PATH_RESOURCES.'/'.self::FALLBACK_LOCALE.'/'.$fileName;
        } elseif (false === file_exists($resourceFile)) {
            throw new UnexistentFile();
        }

        return Yaml::parseFile($resourceFile);
    }
}
