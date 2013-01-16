Capistrano::Configuration.instance(true).load do
	namespace :wordpress do
		namespace :deploy do
			task :setup do
				set :shared_children, %w{log media system var}
			end

			task :finalize_update, :except => {:no_release => true} do

			end
		end
	end
end