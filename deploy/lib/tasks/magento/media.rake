namespace :magento do
  namespace :media do
    desc "Push media files (options: target=<environment>)"
    task :push do
      target = ENV['target']

      raise 'You must specify a target to push to.' unless target

      system "cap #{target} magento:media:transfer_up"
    end

    task :pull do
      raise "You can't pull media to the production environment." if production?

      from = ENV['from']

      raise 'You must specify an environment to pull from.' unless from

      system "cap #{from} magento:media:transfer_down"
    end

    desc "Backup Magento's media directory to backup server (options: period=<daily|weekly|monthly>)."
    task :backup => :set_permissions do
      period = ENV['period'] || 'daily'
      timestamp = Time.now.strftime '%Y-%m-%d_%H-%M-%S'

      # Sync media files to backup server
      user_and_host = "#{remote_backup_user}@#{remote_backup_host}"
      env_path = File.join remote_media_backup_path, environment
      current_path = File.join env_path, 'current'
      period_path = File.join env_path, period
      media_path = File.join 'public', 'media'

      system "rsync --verbose  --progress --stats --compress --rsh=/usr/bin/ssh --recursive --times --delete #{media_path} #{user_and_host}:#{current_path}"
      system "ssh #{user_and_host} 'mkdir -p #{current_path} #{period_path}; cd #{current_path}; tar cvf media.tar media; mv media.tar #{period_path}/media_#{timestamp}.tar'"
    end
  end
end
