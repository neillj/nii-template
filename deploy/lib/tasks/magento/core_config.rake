namespace :magento do
  namespace :core_config do
    desc "Serialize Magento's core configuration data table."
    task :dump do
      # First set the Base URLs and other custom configuration used by production
      tailor_environment! 'production'

      # Now dump the core_config_data table (with only the Base URLs changed)
      dump_table :core_config_data, :where => deploy_config['core_config']['dump_where_clause']

      # Set the Base URLs and other custom configuration used in the current environment
      tailor_environment!

      # Move the table dump out of the tmp directory
      FileUtils.mv "#{mysqldump_dir}/core_config_data.txt", 'config/'
      FileUtils.rm "#{mysqldump_dir}/core_config_data.sql"
    end

    desc "Deserialize Magento's core configuration data table."
    task :import do
      import_textfile "#{DEPLOY_ROOT}/config/core_config_data.txt"

      tailor_environment!
    end
  end
end
