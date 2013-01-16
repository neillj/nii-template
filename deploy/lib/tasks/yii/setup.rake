namespace :yii do
	desc "Setup Yii Installation"
	task :setup => ['dev:start_xampp', 'dev:add_hosts_entry', 'dev:add_vhosts_entry', 'dev:create_folders', 'yii:create_local_config'] do
		Rake::Task['db:setup'].invoke if deploy_config['backup']['do_restore']
		Rake::Task['yii:media:pull'].invoke if deploy_config['backup']['do_restore']
		puts "\nDeployment Complete"
	end
	
	desc "Create local.php config file."
	task :create_local_config do
		local_config_file = File.join REPO_ROOT, 'public', 'protected', 'app', 'config', 'local.php'
		task_desc 'Creating the local config file'
		puts local_config_file
		tmpl = '--'

		# get template
		contents = File.read(File.join(DEPLOY_ROOT,'lib','templates','yii','local.template.php'))
		
		# append db fields to config from database.yml
		['database','host','username','password'].each do |value|
			templateLookupFields['db_'+value] = db_config[value] || ''
		end
		
		# loop through config and find and replace
		templateLookupFields.each do |key,value|
			match = tmpl+key+tmpl
			contents = contents.gsub(/#{match}/, "#{value}")
		end
		
		# write config file to public/protected/app/config/local.php
		File.open(local_config_file, 'w') do |t|
			t.puts contents
		end
	end
end