namespace :dev do
	desc 'Performs tasks required to setup a development environment.'
	task :setup do
		Rake::Task["#{project_type}:setup"].invoke if project_type
	end

  task :add_hosts_entry do
		task_desc 'Adding domain to hosts file'
    host = hostname environment
    if `grep '#{host}' /etc/hosts` === ''
      puts 'Appending /etc/hosts'
      `cp /etc/hosts /tmp/hosts`
			`echo "127.0.0.1\t#{host}" >> /tmp/hosts`
			`echo "fe80::1%lo0\t#{host}" >> /tmp/hosts`
			`sudo mv /tmp/hosts /etc/hosts`
		end
  end
	
	task :add_vhosts_entry do
		task_desc 'Adding domain to vhosts file'
    host = hostname environment
    if `grep '#{host}' /Applications/XAMPP/etc/extra/httpd-vhosts.conf` === ''
      puts 'Appending /Applications/XAMPP/etc/extra/httpd-vhosts.conf'
      `cp /Applications/XAMPP/etc/extra/httpd-vhosts.conf /tmp/httpd-vhosts.conf`
			`echo '<VirtualHost *:80>' >> /tmp/httpd-vhosts.conf`
			`echo '    ServerName #{host}' >> /tmp/httpd-vhosts.conf`
			`echo '    DocumentRoot #{public_root}' >> /tmp/httpd-vhosts.conf`
			`echo '</VirtualHost>' >> /tmp/httpd-vhosts.conf`
			`sudo mv /tmp/httpd-vhosts.conf /Applications/XAMPP/etc/extra/httpd-vhosts.conf`
			Rake::Task['dev:restart_apache'].invoke
    end
  end
	
	task :start_xampp do
		task_desc 'Starting XAMPP'
		system "sudo /Applications/XAMPP/xamppfiles/xampp startapache"
		system "sudo /Applications/XAMPP/xamppfiles/xampp startmysql"
		sleep 1
	end
	
	task :restart_apache do
		task_desc 'Restarting Apache'
		system "sudo /Applications/XAMPP/xamppfiles/xampp reloadapache"
	end

  task :create_folders do
    # create folders from defaults:create_folders section of config.yml
		task_desc 'Creating Folders'
    createFolders.length.times do |i|
      puts 'Creating folder: '+createFolders[i]
      `mkdir -p #{File.join(REPO_ROOT, createFolders[i])}`
    end
  end
end
