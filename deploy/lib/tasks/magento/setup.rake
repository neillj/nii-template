namespace :magento do
	task :setup do
		ENV['from'] = 'production'
		# Rake::Task['media:pull'].invoke
		# Hacky but gets around PHP errors that sometimes occur
		# sleep 1
		# Rake::Task['magento:tailor_environment'].invoke
	end

  desc "Create Magento's local.xml file."
  task :create_local_xml do
    require 'erb'

    template = File.read('./config/local.xml.erb')
    install_date = deploy_config['install_date']
    encryption_key = deploy_config['encryption_key']
    session_save = deploy_config['session_save']
    host = db_config['host']
    username = db_config['username']
    password = db_config['password']
    database = db_config['database']
    local_xml = ERB.new(template).result(binding)

    File.open('./public/app/etc/local.xml', 'w') { |f| f.write(local_xml) }
  end

  desc "Sets correct permissions required by Magento."
  task :set_permissions do
    `chmod -R o+w public/var public/media`
    `chmod o+w public/app/etc tmp`
  end

  desc 'Tailors the Magento install for your particular environment'
  task :tailor_environment => 'magento:create_local_xml' do
    tailor_environment!
  end

  task :install_dependencies do
    # No dependencies
  end
	
end
