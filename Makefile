.PHONY: help
help: ## This help
	@grep -Eh '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

include Makefile-api.mk
include Makefile-auth.mk

up: ## Builds, (re)creates, starts, and attaches to containers for a service.
	docker-compose up

up-d: ## Builds, (re)creates, starts, and attaches to containers for a service.
	docker-compose up -d

ps: ## List containers
	docker-compose ps

stop: ## Stops running containers without removing them
	docker-compose stop
