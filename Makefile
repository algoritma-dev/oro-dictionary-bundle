.PHONY: help
.DEFAULT_GOAL := help

help:
	@echo "COMMANDS"
	@echo "---------------------------------------------------------------------------------------------------------"
	@printf "\033[33mDocker Utils:%-30s\033[0m %s\n"
	@grep -E '^[a-zA-Z_-]+:.*?##1 .*$$' $(firstword $(MAKEFILE_LIST)) | awk 'BEGIN {FS = ":.*?##1 "}; {printf "\033[33m  - %-30s\033[0m %s\n", $$1, $$2}'
	@echo "---------------------------------------------------------------------------------------------------------"
	@printf "\033[36mDev:%-30s\033[0m %s\n"
	@grep -E '^[a-zA-Z_-]+:.*?##2 .*$$' $(firstword $(MAKEFILE_LIST)) | awk 'BEGIN {FS = ":.*?##2 "}; {printf "\033[36m  - %-30s\033[0m %s\n", $$1, $$2}'
	@echo "---------------------------------------------------------------------------------------------------------"
	@printf "\033[35mDatabase Utils:%-30s\033[0m %s\n"
	@grep -E '^[a-zA-Z_-]+:.*?##3 .*$$' $(firstword $(MAKEFILE_LIST)) | awk 'BEGIN {FS = ":.*?##3 "}; {printf "\033[35m  - %-30s\033[0m %s\n", $$1, $$2}'

##################
#### DOCKER ######
##################
XDEBUG_ENABLED = 0
DOCKER_COMPOSE = docker compose
DOCKER_COMPOSE_RUN = $(DOCKER_COMPOSE) run --rm --entrypoint="" -e XDEBUG_ENABLED=$(XDEBUG_ENABLED) --workdir=/application
DOCKER_WORKSPACE_TEST_SERVICE = workspace-test
DOCKER_WORKSPACE_CLI_SERVICE = workspace

COMPOSER = $(DOCKER_COMPOSE_RUN) $(DOCKER_WORKSPACE_CLI_SERVICE) composer
COMPOSER_TESTS = $(DOCKER_COMPOSE_RUN) $(DOCKER_WORKSPACE_TEST_SERVICE) composer

sh:
	$(DOCKER_COMPOSE_RUN) $(DOCKER_WORKSPACE_CLI_SERVICE) bash

vendor: composer.json $(wildcard composer.lock) ##2 Install composer dependencies
	$(COMPOSER) install --prefer-dist

vendor-req: composer.json $(wildcard composer.lock) ##2 Require composer dependency (es. make vendor-req algoritma/example-deps)
	$(COMPOSER) require $(filter-out $@,$(MAKECMDGOALS))

vendor-up: ##2 Update composer dependencies (es. make vendor-up or make vendor-up algoritma/example-deps)
	$(COMPOSER) update $(filter-out $@,$(MAKECMDGOALS))

vendor-rm: ##2 Remove composer dependencies
	$(COMPOSER) remove $(filter-out $@,$(MAKECMDGOALS))

run:
	$(COMPOSER) run $(filter-out $@,$(MAKECMDGOALS));

test:
	$(DOCKER_COMPOSE_RUN) $(DOCKER_WORKSPACE_TEST_SERVICE) ./bin/simple-phpunit --configuration=lib/app

.PHONY: vendor vendor-req vendor-up
