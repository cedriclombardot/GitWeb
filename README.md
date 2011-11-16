# [In dev] GitWeb

It's a light interface to help you to browse fork and pull request on repositories

It's built on top of Symfony2, propel and GitFS

## Setup 

````
git clone git://github.com/cedriclombardot/GitWeb.git
cd GitWeb
git submodule update --init --recursive
````

Configure your database in config_dev.yml and build the schema

````
mkdir -p app/repositories/admin
mkdir -p app/repositories/user
git clone --bare git://github.com/cedriclombardot/GitWeb.git app/repositories/admin/demo.git
git clone app/repositories/admin/demo.git app/repositories/admin/demo.clone
./rebuild.sh
````




