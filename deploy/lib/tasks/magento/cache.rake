namespace :magento do
  namespace :cache do
    desc 'Expire the main cache (clears the var/cache directory).'
    task :expire do
      `rm -rf public/var/cache/*`
    end
  end
end
