set :stages, %w(production staging sandbox)
set :default_stage, 'sandbox'
set :domain, 'hub.newicon.net'
set :application, domain
set :repository, "git@github.com:newicon/Nii.git"
set :scm, :git
set :user, 'admin'
set :group, 'admin'
set :group_writable, false
set :deploy_to, "/srv/#{application}"
set :deploy_via, :remote_cache
set :use_sudo, false
set :bundle_gemfile,  "deploy/Gemfile"

after 'deploy', 'deploy:cleanup'
