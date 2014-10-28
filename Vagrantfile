# -*- mode: ruby -*-
# vi: set ft=ruby :

# Vagrantfile API/syntax version. Don't touch unless you know what you're doing!
VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.box = "ubuntu/trusty32"

  config.vm.provision "shell", path: "bootstrap.sh"

  config.vm.network "private_network", ip: "192.168.33.10"

  config.vm.synced_folder ".", "/vagrant", :nfs => true

  config.vm.define :Nfq_Akademija do |t|
  end
  
  config.vm.provider "virtualbox" do |v|
  v.name = "Nfq_Akademija"
  end

end
