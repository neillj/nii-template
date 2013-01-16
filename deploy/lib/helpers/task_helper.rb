require 'addressable/uri'

module TaskHelper
	def environment
		ENV['environment'] || 'development'
	end

	def deploy_config env = environment
    DEPLOY_CONFIG[env]
  end

  def db_config env = environment
    deploy_config(env)['database']
  end

  def hostname env = environment
    Addressable::URI.heuristic_parse(base_url(env)['unsecure']).normalized_host.to_s
  end
	
	def public_root env = environment
    File.join REPO_ROOT, deploy_config(env)['public_root']
  end

  def base_url env = environment
    deploy_config(env)['base_url']
  end

  def tailor_environment! env = environment
    script_path = DEPLOY_ROOT + "/lib/bin/tailor_environment.php"

    output = `php #{script_path} #{env}`
    puts output unless output === ''

    Dir[File.join DEPLOY_ROOT, 'config/environments', env, '*.rb'].each do |file|
      require file
    end
  end

  def import_textfile textfile
    `mysqlimport #{mysql_connection_args} --replace --local #{db_config['database']} #{textfile}`
  end

  def mysql_connection_args
    args = "-h #{db_config['host']} -u #{db_config['username']}"
    args += " -p#{db_config['password']}" unless db_config['password'].nil?
    args
  end

  def mysqldump_args options = {}
    tab_arg = options[:txt] ? "--tab=#{mysqldump_dir}" : ''
    add_drop_table_arg = options[:replace] ? '--skip-add-drop-table' : '--add-drop-table'
    replace_args = options[:replace] ? '--no-create-db --no-create-info --replace' : ''
    where_arg = options[:where] ? "--where=\"#{options[:where]}\"" : ''

    "#{mysql_connection_args} --quick #{add_drop_table_arg} #{replace_args} #{where_arg} --skip-lock-tables #{tab_arg} #{db_config['database']}"
  end

  def mysqldump_dir
    'tmp'
  end
	
	def from_backup
		ENV['from'] || 'production'
	end

  def remote_db_backup_path
    deploy_config['backup']['remote']['db_dir']
  end

  def remote_media_backup_path
    deploy_config['backup']['remote']['media_dir']
  end

  def remote_backup_user
    deploy_config['backup']['remote']['username']
  end

  def remote_backup_host
    deploy_config['backup']['remote']['host']
  end
	
	def remote_backup_user_and_host
		"#{remote_backup_user}@#{remote_backup_host}"
	end
	
	def local_media_path
		File.expand_path(File.join(REPO_ROOT, deploy_config['backup']['local']['media_dir']))
	end

  def dump_table table, options = {}
    `mysqldump #{mysqldump_args({:txt => true, :replace => true}.merge(options))} #{table.to_s} > #{DEPLOY_ROOT}/#{mysqldump_dir}/#{table.to_s}.sql`
  end

  def production?
    environment == 'production'
  end

  def development?
    environment == 'development'
  end

  def cms_tables
    %w{cms_block cms_block_store cms_page cms_page_store}
  end

  def createFolders
    deploy_config['create_folders']
  end

  def templateLookupFields
    deploy_config['localTemplateLookupFields']
  end

	def project_type
		deploy_config['project_type']
	end
	
	@@num = 0
	def task_desc text
		@@num += 1
		puts "\n#{@@num}. #{text}\n"
	end
	
end
