# vagrant-registry-generator

[![Build Status](https://travis-ci.org/Jalle19/vagrant-registry-generator.svg?branch=master)](https://travis-ci.org/Jalle19/vagrant-registry-generator) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Jalle19/vagrant-registry-generator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/Jalle19/vagrant-registry-generator/?branch=master)

This is a simple tool that can be used to generate a static registry overview for Vagrant boxes stored on S3. It is 
designed to be used together with the [packer-post-processor-vagrant-s3](https://github.com/lmars/packer-post-processor-vagrant-s3) 
Packer post-processor.

## Installation

Go to https://github.com/Jalle19/vagrant-registry-generator/releases/latest, right-click the 
`vagrant-registry-generator.phar` link, copy the URL and then run `wget <url>`. You can now run the tool using 
`php vagrant-registry-generator.phar`.

## Requirements

The tool assumes your Vagrant boxes are stored on S3 in the following directory structure:

```
bucket/prefix
  - json/
    - organization/
      - boxName.json
  - boxes/
    - organization/
      - boxName/
        - version/
          - box.box
```

## Usage

```
$ ./vagrant-registry-generator.phar --help
Usage:
  vagrant-registry-generator [options] [--] <registryPath> <outputPath>

Arguments:
  registryPath                       The path to the Vagrant registry
  outputPath                         The path where the output is generated

Options:
      --awsAccessKey[=AWSACCESSKEY]  The AWS access key to use (required when using S3 paths)
      --awsSecretKey[=AWSSECRETKEY]  The AWS secret key to use (required when using S3 paths)
      --awsRegion[=AWSREGION]        The AWS region where your S3 bucket resides (required when using S3 paths)
  -h, --help                         Display this help message
  -q, --quiet                        Do not output any message
  -V, --version                      Display this application version
      --ansi                         Force ANSI output
      --no-ansi                      Disable ANSI output
  -n, --no-interaction               Do not ask any interactive question
  -v|vv|vvv, --verbose               Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Help:
 Static Vagrant registry generator
```

`registryPath` and `outputPath` should be in the form of `s3://bucket/prefix`. You can also store the output locally 
by passing a local path to `outputPath`, e.g. `./dist`.

## License

MIT
