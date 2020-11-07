# cake-misc Jenkins/CI setup
Copy the 2 jenkins .sh files, as well as the Jenkinsfile into the root of your project
Copy the post-commit hook into .git/hooks/post-commit (adjusting to fit your needs - adjust remote repo locations as necessary)
$ chmod +x .git/hooks/post-commit


you should now have a working CI pipeline setup with jenkins
I use a local-store and dev-ci remote repos for each project - both pointing to /var/code/project_name.
local-store is on my dev box, while dev-ci is on a remote server being used as a jenkins slave.

** not sure if this is the best way to do it - but it has been working for me w/ my current setup **