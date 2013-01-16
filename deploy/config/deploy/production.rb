production_domain = "hub.newicon.net"

set :environment, 'production'

role :app, production_domain
role :web, production_domain
role :db, production_domain, :primary => true