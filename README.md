# Catch Coding Challenge 1

Read a data file, process each record, and produce an output file.

####Author:
Adrian B. <br>
dev.badrian@gmail.com

## Requirement

PHP Version 7.3+



## Installation

Use the package manager composer to install all dependencies.

```bash
composer install
```

## How to run
```bash
symfony console app:export-order <output_format>
  <output_format> : 
      default: csv
      supports: csv, yaml, json, xml
```