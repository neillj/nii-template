namespace :yii do
	namespace :media do
		desc "Pull media files"
		task :pull do
			task_desc 'Downloading Media Files'
			raise "You can't pull media to the production environment." if production?
			system "rsync --progress --compress --rsh=/usr/bin/ssh --recursive #{remote_backup_user}@#{remote_backup_host}:#{remote_media_backup_path} #{local_media_path}"
		end
	end
end