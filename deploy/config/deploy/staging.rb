staging_domain = "staging.hub.newicon.net"

set :deploy_to, "/srv/#{staging_domain}"
set :environment, 'staging'

role :app, staging_domain
role :web, staging_domain
role :db, staging_domain, :primary => true