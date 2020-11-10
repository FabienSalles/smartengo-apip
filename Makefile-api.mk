DC_EXEC_API_PHP=docker-compose exec php

api/php-cs-check:
	./bin/api/php-cs-fixer fix --dry-run --diff

api/php-cs-fix:
	./bin/api/php-cs-fixer fix

api/phpstan:
	$(DC_EXEC_API_PHP) bin/phpstan analyse --memory-limit=-1

api/cc:
	$(DC_EXEC_API_PHP) rm -rf var/cache/*
