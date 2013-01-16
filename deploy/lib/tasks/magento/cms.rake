namespace :magento do
  namespace :cms do
    desc "Push CMS data (options: target=<environment>)"
    task :push do
      target = ENV['target']

      raise 'You must specify a target to push to.' unless target

      `cap #{target} magento:cms:transfer_up`
      `cap #{target} magento:cms:import`
    end

    task :import do
      cms_tables.each do |table_name|
        import_textfile "#{DEPLOY_ROOT}/tmp/#{table_name}.txt"
      end
    end
  end
end
