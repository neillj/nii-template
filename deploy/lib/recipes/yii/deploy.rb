Capistrano::Configuration.instance(true).load do
	namespace :yii do
		namespace :deploy do
			task :setup do
				set :shared_children, %w{log media system var}
			end

			task :finalize_update, :except => {:no_release => true} do
				run "mkdir -p #{shared_path}/assets"
				run "mkdir -p #{shared_path}/runtime"
				
				run "ln -s #{shared_path}/assets #{latest_release}/public/htdocs/assets"
				run "ln -s #{shared_path}/runtime #{latest_release}/public/protected/app/runtime"
				run "ln -s #{shared_path}/uploads #{latest_release}/uploads"
				run "ln -s #{shared_path}/local.php #{latest_release}/public/protected/app/config/local.php"
			end
		end
	end
end