ifneq (,$(shell docker compose version >/dev/null 2>&1 && echo true))
	PHP=docker compose run --rm --no-deps php
else
	PHP=php
endif

PHP_CONSOLE_DEPS=vendor

vendor: composer.json
	@$(PHP) composer install -o -n --no-ansi
	@touch vendor || true

phpunit: $(PHP_CONSOLE_DEPS)
	@$(PHP) vendor/bin/phpunit --color=always

php-cs: $(PHP_CONSOLE_DEPS)
	@$(PHP) vendor/bin/php-cs-fixer check -vv

phpstan: $(PHP_CONSOLE_DEPS)
	@$(PHP) vendor/bin/phpstan analyse

check: php-cs phpstan phpunit