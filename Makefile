.PHONY: test build db dt dbi dphar csfix
.DEFAULT_GOAL := help

help: ## it shows help menu
	@awk 'BEGIN {FS = ":.*#"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z0-9_-]+:.*?#/ { printf "  \033[36m%-27s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

test: ## it launches tests
	php -d memory_limit=512M vendor/bin/phpunit --stop-on-failure

test-coverage: ## it launches tests coverage html
	XDEBUG_MODE=coverage php -d memory_limit=512M vendor/bin/phpunit --coverage-html public/coverage --stop-on-failure