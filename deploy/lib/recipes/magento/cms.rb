Capistrano::Configuration.instance(true).load do
  before 'magento:cms:push', 'magento:media:push'

  namespace :magento do
    namespace :cms do
      desc "Push CMS data (options: target=<environment>)"
      task :push do
        target = ENV['target']

        raise 'You must specify a target to push to.' unless target

        run "cd #{current_path}; #{rake} environment=#{environment} target=#{target} magento:cms:push"
      end

      task :transfer_up do
        cms_tables.each do |table_name|
          dump_table table_name
          filename = "#{table_name}.txt"
          upload File.join('tmp', filename), "#{current_path}/tmp/#{filename}"
        end
      end

      task :import do
        run "cd #{current_path}; #{rake} environment=#{environment} magento:cms:import"
      end
    end
  end
end
