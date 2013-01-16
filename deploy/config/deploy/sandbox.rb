sandbox_domain = "sandbox.hub.newicon.net"

set :deploy_to, "/srv/#{sandbox_domain}"
set :environment, 'sandbox'

role :app, sandbox_domain
role :web, sandbox_domain
role :db, sandbox_domain, :primary => true