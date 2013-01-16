namespace :wordpress do
	desc "Setup WordPress Installation"
	task :setup => ['dev:add_hosts_entry', 'dev:create_folders', 'wordpress:create_local_config'] do
		Rake::Task['db:setup'].invoke if deploy_config['backup']['do_restore']
	end
	
	desc "Create wp_config.php config file."
	task :create_local_config do
		
	end
end