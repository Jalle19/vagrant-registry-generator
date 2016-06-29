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
[2016-06-06 17:01:54] NOTICE: Writing registry containing 3 manifests
[2016-06-06 17:01:54] INFO: Writing manifest foo/bar-vagrant to registry
[2016-06-06 17:01:54] INFO: Writing manifest foo/baz-vagrant to registry
[2016-06-06 17:01:54] INFO: Writing manifest foo/qux-vagrant to registry
```

### Running as a Packer post-processor

To automatically update the registry whenever a new artifact is built you can run the command as a Packer 
post-processor. Here's a complete example on how to use it in a post-processor chain together with 
[packer-post-processor-vagrant-s3](https://github.com/lmars/packer-post-processor-vagrant-s3) (change the path to the 
command if necessary):
 
```json
{
  "variables": {
    "ATLAS_ORGANIZATION": "my-organization",
    "BOX_NAME": "my-box",
    "AWS_ACCESS_KEY_ID": "retrieve this from env",
    "AWS_SECRET_ACCESS_KEY": "retrieve this from env",
    "AWS_REGION": "eu-west-1",
    "AWS_BUCKET": "my-s3-bucket"
  },
  "builders": [ ... ],
  "provisioners": [ ... ],
  "post-processors": [
    [
      {
        "type": "vagrant"
      },
      {
        "type": "vagrant-s3",
        "access_key_id": "{{ user `AWS_ACCESS_KEY_ID` }}",
        "secret_key": "{{ user `AWS_SECRET_ACCESS_KEY` }}",
        "region": "{{ user `AWS_REGION` }}",
        "bucket": "{{ user `AWS_BUCKET` }}",
        "manifest": "vagrant/json/{{ user `ATLAS_ORGANIZATION` }}/{{ user `BOX_NAME` }}.json",
        "box_dir": "vagrant/boxes/{{ user `ATLAS_ORGANIZATION` }}/{{ user `BOX_NAME` }}",
        "box_name": "{{ user `ATLAS_ORGANIZATION` }}/{{ user `BOX_NAME` }}"
      },
      {
        "type": "shell-local",
        "inline": ["php /opt/vagrant-registry-generator.phar --awsAccessKey {{ user `AWS_ACCESS_KEY_ID` }} --awsSecretKey {{ user `AWS_SECRET_ACCESS_KEY` }} --awsRegion {{ user `AWS_REGION` }} s3://{{ user `AWS_BUCKET` }}/vagrant s3://{{ user `AWS_BUCKET` }}/vagrant -vv"]
      }
    ]
  ]
}
```

## License

MIT
