Capistrano::Configuration.instance(true).load do
  namespace :deploy do
    namespace :web do
      desc 'Present a maintenance page to visitors.'
      task :disable, :roles => :web, :except => { :no_release => true } do
        run "touch #{current_path}/public/maintenance.flag"
      end

      desc 'Makes the application web-accessible again.'
      task :enable, :roles => :web, :except => { :no_release => true } do
        run "rm #{current_path}/public/maintenance.flag"
      end
    end

    task :finalize_update, :except => { :no_release => true } do
      run "chmod -R g+w #{latest_release}" if fetch(:group_writable, true)
    end

    task :symlink_sitemap do
      latest_release_sitemap = "#{latest_release}/public/sitemap.xml"
      run "[ ! -f #{latest_release_sitemap} ] || rm #{latest_release_sitemap}"
      run "ln -s #{shared_path}/sitemap.xml #{latest_release_sitemap}"
    end
  end
end
