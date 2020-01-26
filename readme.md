# Code

You will find my code app/ParentHQ

# Steps to add new DataProvider

- Add data Provider Json file under `app/ParentHQ/jsons`
- Instantiate a new class of `AbstractDataProvider` with class name of the json file name
- Implements abstract methods in the instantiated DataProvider class

# Docker
- ./docker-compse.yml
- ./docker/web/Dockerfile
- ./docker/web/default.conf

##### before use the api or run unit test, please run `chmod -R 777 storage/*`