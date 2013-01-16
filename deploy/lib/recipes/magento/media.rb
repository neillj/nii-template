Capistrano::Configuration.instance(true).load do
  namespace :magento do
    namespace :media do
      task :push do
        target = ENV['target']

         raise 'You must specify a target to push to.' unless target

         run "cd #{current_path}; #{rake} environment=#{environment} target=#{target} magento:media:push"
      end

      task :pull do
        from = ENV['from']

        raise 'You must specify a target to pull from.' unless from

        run "cd #{current_path}; #{rake} environment=#{environment} from=#{from} magento:media:pull"
      end

      task :transfer_up do
        find_servers_for_task(current_task).each do |server|
          system "rsync --verbose  --progress --stats --compress --rsh=/usr/bin/ssh --recursive public/media #{user}@#{server}:#{shared_path}"
        end
      end

      task :transfer_down do
        server = find_servers_for_task(current_task).first
        system "rsync --verbose  --progress --stats --compress --rsh=/usr/bin/ssh --recursive #{user}@#{server}:#{shared_path}/media public"
      end
    end
  end
end
