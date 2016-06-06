<?php

namespace Jalle19\VagrantRegistryGenerator;

use Jalle19\VagrantRegistryGenerator\Configuration\Parser as ConfigurationParser;
use Jalle19\VagrantRegistryGenerator\Filesystem\Factory as FilesystemFactory;
use Jalle19\VagrantRegistryGenerator\Registry\Reader;
use Jalle19\VagrantRegistryGenerator\Registry\Writer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class VagrantRegistryGenerator
 * @package Jalle19\VagrantRegistryGenerator
 */
class VagrantRegistryGenerator extends Command
{

    const COMMAND_NAME = 'vagrant-registry-generator';


    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName(self::COMMAND_NAME);
        $this->setDescription('Static Vagrant registry generator');

        $this->addArgument('registryPath', InputArgument::REQUIRED, 'The path to the Vagrant registry');
        $this->addArgument('outputPath', InputArgument::REQUIRED, 'The path where the output is generated');

        $this->addOption('awsAccessKey', null, InputOption::VALUE_OPTIONAL,
            'The AWS access key to use (required when using S3 paths)');
        $this->addOption('awsSecretKey', null, InputOption::VALUE_OPTIONAL,
            'The AWS secret key to use (required when using S3 paths)');
        $this->addOption('awsRegion', null, InputOption::VALUE_OPTIONAL,
            'The AWS region where your S3 bucket resides (required when using S3 paths)');
    }


    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configuration  = ConfigurationParser::parseConfiguration($input);
        $registryReader = new Reader($configuration,
            FilesystemFactory::makeFilesystem($configuration->getRegistryPath(), $configuration));
        $registryWriter = new Writer($configuration,
            FilesystemFactory::makeFilesystem($configuration->getOutputPath(), $configuration));

        $registry = $registryReader->readRegistry();
        $registryWriter->write($registry);
    }

}
