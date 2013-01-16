namespace :db do
  desc 'Creates and populates the database'
  task :setup => ['db:create', 'db:restore'] do
		
	end

  desc 'Create database.'
  task :create do
		task_desc 'Creating the database'
    `echo 'CREATE DATABASE IF NOT EXISTS #{db_config['database']}' | mysql #{mysql_connection_args}`
  end

  desc 'Drop database.'
  task :drop do
    `echo 'DROP DATABASE #{db_config['database']}' | mysql #{mysql_connection_args}`
  end

  desc 'Backup database to backup server (options: period=<daily|weekly|monthly>).'
  task :backup do
    period = ENV['period'] || 'daily'
    timestamp = Time.now.strftime '%Y-%m-%d_%H-%M-%S'
    user_and_host = "#{remote_backup_user}@#{remote_backup_host}"
    backup_dir = File.join 'tmp', 'db_backup'
    env_path = File.join remote_db_backup_path, environment
    current_path = File.join env_path, 'current'
    period_path = File.join env_path, period
    filename = "#{db_config['database']}.sql"
    timestamped_filename = "#{db_config['database']}_#{timestamp}.sql"
    backup_file = File.join backup_dir, filename

    FileUtils.mkdir_p backup_dir

    system "mysqldump #{mysqldump_args} > #{backup_file}"

    # Sync backup to backup server
    system "rsync --verbose --progress --stats --compress --rsh=/usr/bin/ssh --times #{backup_file} #{user_and_host}:#{current_path}/#{filename}"
    system "ssh #{user_and_host} 'mkdir -p #{current_path} #{period_path}; cp #{current_path}/#{filename} #{period_path}/#{timestamped_filename}'"
  end

  desc 'Restore database from a backup (options: from=<environment>).'
  task :restore do
		task_desc 'Restoring the database'
    from = ENV['from'] || 'production'

    user_and_host = "#{remote_backup_user}@#{remote_backup_host}"
    filename = "#{db_config(from)['database']}.sql.gz"
    remote_path = File.join remote_db_backup_path, filename
    local_path = File.join 'tmp', filename

    system "rsync --verbose --progress --stats --compress --rsh=/usr/bin/ssh --times #{user_and_host}:#{remote_path} #{local_path}"
    system "gunzip -f #{local_path}"

    sql_file = File.join 'tmp', "#{db_config(from)['database']}.sql"
    system "cat #{sql_file} | mysql #{mysql_connection_args} #{db_config['database']}"

    tailor_environment!
  end
	
	desc 'Restore database from a backup (options: from=<environment>).'
  task :import do
		task_desc 'Importing the database'

    user_and_host = "#{remote_backup_user}@#{remote_backup_host}"
    filename = "#{db_config(from_backup)['database']}.sql.gz"
    remote_path = File.join remote_db_backup_path, filename
    local_path = File.join 'tmp', filename

    system "rsync --verbose --progress --stats --compress --rsh=/usr/bin/ssh --times #{user_and_host}:#{remote_path} #{local_path}"
    system "gunzip -f #{local_path}"

    sql_file = File.join 'tmp', "#{db_config(from_backup)['database']}.sql"
    system "cat #{sql_file} | mysql #{mysql_connection_args} #{db_config['database']}"

    tailor_environment!
  end
	
end
