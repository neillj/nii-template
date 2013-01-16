Capistrano::Configuration.instance(true).load do
  before 'deploy:setup', 'magento:deploy:setup'
  after 'deploy:setup', 'magento:deploy:dependencies'

  after 'deploy:finalize_update', 'magento:deploy:finalize_update'
  after 'deploy:finalize_update', 'deploy:symlink_sitemap'

  after 'deploy', 'magento:cache:expire'
end
