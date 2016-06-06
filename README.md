# vagrant-registry-generator

This is a simple tool that can be used to generate a static registry overview for Vagrant boxes stored on S3. It is 
designed to be used together with the [packer-post-processor-vagrant-s3](https://github.com/lmars/packer-post-processor-vagrant-s3) 
Packer post-processor.

## Installation

TODO

## Usage

```
./vagrant-registry-generator.phar --awsAccessKey=<accessKey> --awsSecretKey=<secretKey> s3://<registryBucket>/prefix s3://<outputBucket>/prefix --awsRegion=<awsRegion>
```

## License

MIT
