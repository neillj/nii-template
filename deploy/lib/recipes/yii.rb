Capistrano::Configuration.instance(true).load do
	after 'deploy:finalize_update', 'yii:deploy:finalize_update'
end