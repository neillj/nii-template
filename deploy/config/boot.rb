require 'yaml'

DEPLOY_ROOT = File.expand_path(File.join(File.dirname(__FILE__), '..'))
REPO_ROOT = File.expand_path(File.join(DEPLOY_ROOT, '..'))
DEPLOY_CONFIG = YAML::load(File.open(File.join(DEPLOY_ROOT, 'config', 'config.yml')))

require File.join(DEPLOY_ROOT, 'lib', 'helpers', 'task_helper')

include TaskHelper
