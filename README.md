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

The bucket prefix is optional. If the prefix is omitted, the registry is written to the root of the bucket which means 
you can easily enable the S3 static website hosting feature to access the registry.

## Usage

```
$ ./vagrant-registry-generator.phar --help
Usage:
  vagrant-registry-generator [options] [--] <registryPath> <outputPath>

Arguments:
  registryPath                       The path to the Vagrant registry (e.g. s3://my-bucket/my-prefix)
  outputPath                         The path where the output is generated (e.g. s3://my-bucket)

Options:
      --awsAccessKey[=AWSACCESSKEY]  The AWS access key to use (required when using S3 paths). If not specified the value will be read from the AWS_ACCESS_KEY_ID environment variable
      --awsSecretKey[=AWSSECRETKEY]  The AWS secret key to use (required when using S3 paths). If not specified the value will be read from the AWS_SECRET_ACCESS_KEY environment variable
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

`registryPath` and `outputPath` should be in the form of `s3://bucket` or `s3://bucket/prefix`. You can also store the output locally 
by passing a local path to `outputPath`, e.g. `./dist`.

To see what the program does, add `-vv` to the end of the command. Here's a sample of the output it produces on a 
successful run:

```
[2016-06-06 17:01:48] NOTICE: Fetching manifest files
[2016-06-06 17:01:49] INFO: Parsing manifest file at json/foo/bar-vagrant.json
[2016-06-06 17:01:50] INFO: Parsing manifest file at json/foo/baz-vagrant.json
[2016-06-06 17:01:51] INFO: Parsing manifest file at json/foo/qux-vagrant.json
[2016-06-06 17:01:51] NOTICE: Attempting to fetch additional file metadata for each box
[2016-06-06 17:01:52] INFO: Fetching metadata for box at boxes/foo/bar-vagrant/0.1.0/packer_virtualbox-iso_virtualbox.box
[2016-06-06 17:01:52] INFO: Fetching metadata for box at boxes/foo/bar-vagrant/0.2.0/packer_virtualbox-iso_virtualbox.box
[2016-06-06 17:01:53] INFO: Fetching metadata for box at boxes/foo/baz-vagrant/0.1.0/packer_virtualbox-iso_virtualbox.box
[2016-06-06 17:01:53] INFO: Fetching metadata for box at boxes/foo/qux-vagrant/0.1.0/packer_vmware-iso_vmware.box
[2016-06-06 17:01:54] INFO: Fetching metadata for box at boxes/foo/qux-vagrant/0.2.0/packer_virtualbox-iso_virtualbox.box
[2016-06-06 17:01:54] NOTICE: Writing registry containing 3 manifest(s) from 1 organization(s)
[2016-06-06 17:01:54] INFO: Writing organization foo to registry
[2016-06-06 17:01:54] INFO: Writing manifest foo/bar-vagrant to registry
[2016-06-06 17:01:54] INFO: Writing manifest foo/baz-vagrant to registry
[2016-06-06 17:01:54] INFO: Writing manifest foo/qux-vagrant to registry
```

## License

MIT
