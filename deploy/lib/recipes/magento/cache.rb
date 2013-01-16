Capistrano::Configuration.instance(true).load do
  namespace :magento do
    namespace :cache do
      desc 'Expire the main cache (clears the var/cache directory).'
      task :expire do
        run "cd #{current_path}; #{rake} environment=#{environment} magento:cache:expire"
      end
    end
  end
end
