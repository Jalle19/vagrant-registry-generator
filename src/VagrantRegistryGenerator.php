<?php

namespace Jalle19\VagrantRegistryGenerator;

use Bramus\Monolog\Formatter\ColoredLineFormatter;
use Jalle19\VagrantRegistryGenerator\Configuration\Parser as ConfigurationParser;
use Jalle19\VagrantRegistryGenerator\Filesystem\Factory as FilesystemFactory;
use Jalle19\VagrantRegistryGenerator\Registry\Reader;
use Jalle19\VagrantRegistryGenerator\Registry\Writer;
use Monolog\Logger;
use Monolog\Processor\PsrLogMessageProcessor;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
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

        $this->addArgument('registryPath', InputArgument::REQUIRED,
            'The path to the Vagrant registry (e.g. s3://my-bucket/my-prefix)');
        $this->addArgument('outputPath', InputArgument::REQUIRED,
            'The path where the output is generated (e.g. s3://my-bucket)');

        $this->addOption('awsAccessKey', null, InputOption::VALUE_OPTIONAL,
            'The AWS access key to use (required when using S3 paths). If not specified the value will be read from the AWS_ACCESS_KEY_ID environment variable');
        $this->addOption('awsSecretKey', null, InputOption::VALUE_OPTIONAL,
            'The AWS secret key to use (required when using S3 paths). If not specified the value will be read from the AWS_SECRET_ACCESS_KEY environment variable');
        $this->addOption('awsRegion', null, InputOption::VALUE_OPTIONAL,
            'The AWS region where your S3 bucket resides (required when using S3 paths)');
    }


    /**
     * @inheritdoc
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configuration = ConfigurationParser::parseConfiguration($input);
        $logger        = $this->configureLogger($output);

        $registryReader = new Reader($logger,
            FilesystemFactory::makeFilesystem($configuration->getRegistryPath(), $configuration));
        $registryWriter = new Writer($configuration, $logger,
            FilesystemFactory::makeFilesystem($configuration->getOutputPath(), $configuration));

        $registry = $registryReader->readRegistry();
        $registryWriter->write($registry);
    }


    /**
     * Configures and returns the logger instance
     *
     * @param OutputInterface $output
     *
     * @return LoggerInterface
     */
    private function configureLogger(OutputInterface $output)
    {
        $consoleHandler = new ConsoleHandler($output);
        $consoleHandler->setFormatter(new ColoredLineFormatter(null, "[%datetime%] %level_name%: %message%\n"));

        $logger = new Logger(self::COMMAND_NAME);
        $logger->pushHandler($consoleHandler);
        $logger->pushProcessor(new PsrLogMessageProcessor());

        return $logger;
    }

}
