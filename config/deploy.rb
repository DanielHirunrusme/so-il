set :application, 'so-il'

set :repo_url, 'git@github.com:DanielHirunrusme/soil.git'

# Branch options
# Prompts for the branch name (defaults to current branch)
#ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

# Sets branch to current one
#set :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }

# Hardcodes branch to always be master
# This could be overridden in a stage config file
set :branch, :master

# set :deploy_to, "/srv/www/#{fetch(:application)}"

set :log_level, :debug

set :linked_files, %w{.env .htaccess app/wp-cache-config.php}
set :linked_dirs, %w{app/uploads app/cache}

set :file_permissions_paths, ["app/cache"]
set :file_permissions_users, ["www-data"]

namespace :git do
  task :update_repo_url do
    on roles(:all) do
      within repo_path do
        execute :git, 'remote', 'set-url', 'origin', fetch(:repo_url)
      end
    end
  end
end



namespace :deploy do

  desc 'Restart application'
  task :restart, :clear_cache do
    on roles(:app), in: :sequence, wait: 5 do
      execute :service, :apache2, :reload
      execute :service, :hhvm, :restart
    end
  end
  
  desc 'Fix permissions'
  task :fix_permissions do
    on roles(:app), in: :sequence do
      execute "chmod 755 #{current_path}/app"
      execute "chmod 666 #{current_path}/app/wp-cache-config.php"
      execute "rm -rf #{current_path}/app/cache/*"
    end
  end

end

before "deploy:updated", "deploy:set_permissions:acl"
after "deploy:symlink:release", "deploy:fix_permissions"

task :path do
  on roles fetch(:composer_roles) do
    execute :echo, '$PATH'
    execute 'php --version'
  end
end

set :composer_install_flags, '--no-scripts --optimize-autoloader'
