Capistrano::Configuration.instance(true).load do
  namespace :magento do
    namespace :deploy do
      task :setup do
        set :shared_children, %w{log media system var}
      end

      task :dependencies do
        run "cd #{current_path}; #{rake} environment=#{environment} magento:install_dependencies"
      end

      task :finalize_update, :except => {:no_release => true} do
        run "cd #{release_path}; #{rake} environment=#{environment} magento:tailor_environment"
        run "cd #{release_path}; #{rake} environment=#{environment} magento:core_config:import"
        run "cd #{release_path}; #{rake} environment=#{environment} magento:set_permissions"

        # mkdir -p is making sure that the directories are there for some SCM's that don't
        # save empty folders
        run "rm -rf #{latest_release}/public/system #{latest_release}/public/var #{latest_release}/public/media"
        run "mkdir -p #{latest_release}/tmp"

        run "ln -s #{shared_path}/media #{latest_release}/public/media"
        run "ln -s #{shared_path}/var #{latest_release}/public/var"
        run "ln -s #{shared_path}/system #{latest_release}/system"

        if fetch :normalize_asset_timestamps, true
          stamp = Time.now.utc.strftime "%Y%m%d%H%M.%S"
          asset_paths = %w(js skin).map { |p| "#{latest_release}/public/#{p}" }.join(' ')
          run "find #{asset_paths} -exec touch -t #{stamp} {} ';'; true", :env => {'TZ' => 'UTC'}
        end
      end
    end
  end
end
