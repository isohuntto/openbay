# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.network "forwarded_port", guest: 80, host: 8008
  config.vm.provision "shell", path: "vagrant/provision.sh"

  # At the time of writing (Jan 2015) IsoHunt's remote sphinx provided in
  # http://isohunt.to/openbay/config.json is down.
  # Installing sphinx locally and increasing RAM size for it.
  config.vm.provider "virtualbox" do |v|
    v.memory = 2560
  end
end
